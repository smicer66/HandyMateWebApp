<?php

namespace App\Http\Controllers;

use \DateTime;
use \Hash;
use \Milon\Barcode\DNS1D;


class ProjectController extends Controller
{
    
	public function __construct() {
        parent::__construct();
    }
	
	
	public function getTest($plate=NULL)
	{
	    /*$this->soapWrapper->add('Currency', function ($service) {
          $service
            ->wsdl('http://41.60.10.144:7191/WcfServer2/Service1.svc?wsdl')
            ->trace(true);
        });
    
        // Without classmap
        $response = $this->soapWrapper->call('Currency.SoapgetRtxCesbyRegNum', [
				'RegNum' => $plate,
				'Qtr' => 2
			]);*/
			
		$pdf = \PDF::loadView('receipt2', compact('wflist', 'type', 'listing', 'detail', 'title', 'header', 'breadcrumbs'))->setPaper('a4', 'landscape');
		return $pdf->download('Transaction Report.pdf');
    
        //dd($response);
	}
	
	public function getTaskDetails($url)
	{
		$project = \App\Models\Project::where('project_url', '=', $url)->with('created_by_user', 'district')->first();
		if($project!=null)
		{
			$userProjects = \App\Models\Project::where('created_by_user_id', '=', $project->created_by_user_id)->get();
			$allProjects = 0;
			$completedProjects = 0;
			$openProjects = 0;
			$assignedProjects = 0;
			foreach($userProjects as $userProject)
			{
				$allProjects++;
				if($userProject->status=='COMPLETED')
				{
					$completedProjects++;
				}
				else if($userProject->status=='OPEN')
				{
					$openProjects++;
				}
				else if($userProject->status=='IN PROGRESS')
				{
					$assignedProjects++;
				}
			}
			//dd($project->created_at);
			$newTime = $project->created_at;
			$newTime = $newTime->addDays($project->bidding_period);
			$userFavs = $project->created_by_user->person_favorites==null ? [] : json_decode($project->created_by_user->person_favorites, TRUE);
			$projectWatchlist = \Auth::user() && \Auth::user()->project_watchlist!=null ? json_decode(\Auth::user()->project_watchlist, TRUE) : [];
			//dd(\Auth::user());
			//dd($project->created_by_user);
			$displayOtherProjects = false;
			$otherProjects = \App\Models\Project::whereNotIn('id', [$project->id])->with('state')->get();
			if($otherProjects->count()>3)
			{
				$displayOtherProjects = true;
				$otherProjects = $otherProjects->random(3);
			}
			else if($otherProjects->count()==0)
			{
				$displayOtherProjects = false;
				$otherProjects = [];
			}
			else 
			{
				$displayOtherProjects = true;
				$otherProjects = $otherProjects->random($otherProjects->count());
			}
			
			$allowBidding = false;
			$projectSkills = $project->skills;
			//dd($projectSkills);
			if(\Auth::user() && \Auth::user()->role_type=='Artisan')
			{
				$userSkills = \Auth::user()->artisanSkills;
				
				foreach($userSkills as $userSkill)
				{
					foreach($projectSkills as $projectSkill)
					{
						//dd([$userSkill->skill]);
						if($projectSkill->skill->id==$userSkill->skill->id)
						{
							$allowBidding = true;
						}
					}
				}
			}
			//967307151
			//dd(33);
			$projectBid = NULL;
			$winningBid = \App\Models\ProjectBid::where('project_id', '=', $project->id)->where('status', '=', 'Won')->first();
			//$projectBids = \App\Models\ProjectBid::where('project_id', '=', $project->id)->get();
			$projectBids = $project->bids;
			
			if(\Auth::user() && \Auth::user()->role_type=='Artisan')
			{
				//$projectBid = \App\Models\ProjectBid::where('project_id', '=', $project->id)->where('bid_by_user_id', '=', \Auth::user()->id)->first();
				if($projectBids!=null)
				{
					foreach($projectBids as $pd)
					{
						if($pd->bid_by_user_id==\Auth::user()->id)
						{
							$projectBid = $pd;
						}
					}
				}
			}
			//dd($project);
			
			$str = '{"request-reference":"20190810-ZICB-1570570297438","request":{"amount":20,"referenceNo":"8773774987","srcBranch":"000","payCurrency":"ZMW","srcAcc":"1019000001258","remarks":"Debit 20.0 From Wallet Account #1019000001258","payDate":"2019-10-08"},"response":{"exchangeRate":null,"destBranch":null,"tekHeader":{"tekesbrefno":"7074d2da-aab9-eb5b-6154-3b2822cc7151","warnList":{},"hostrefno":null,"errList":{"ST-SAVE-054":"Failed to Save","TR-11002":"Parameters passed are blank.","FT-C0003":"Reference Number could not be generated."},"msgList":{},"status":"FAIL","username":"TEKESBCORP"},"amountDebit":null,"amountCredit":null,"destAcc":null,"payDate":null},"preauthUUID":"b01b20dc-92eb-407b-9309-cc993916f005","timestamp":1570570297439,"status":200}';
			//$str1 = '{"request-reference":"20191110-ZICB-1570778883970","request":{"request":{"accountNos":"1019000001258","serviceKey":"aedd3681c6ec02d5f5c33f2effa3b683"},"service":"ZB0644"},"response":{"ACCOUNT_SUMMARY":{"tekHeader":{"tekesbrefno":"aac0753f-de4b-9643-169e-2bcac7471bd8","warnList":{},"hostrefno":null,"errList":{"ST-SAVE-024":"Failed to Query Data","ST-GRP03":"User is restricted to query the details of this customer 9000257"},"msgList":{},"status":"FAIL","username":"TEKESBRETAIL"},"accountSummaryList":[]},"QUERY_BY_MOBILE":{"message":"no Account Linked to mobile number 260979810007"},"QUERY_BY_ACCOUNT":{"customerAddress":"12 Paseli Road ","blockedamount":0,"accountcurrency":"ZMW","unCollectedAmt":0,"accountTitle":"Wallet Account","accountclass":null,"customerName":"Salso Denis","currentbalance":10158,"availablebalance":10158,"brnCode":"101","dr_INT_DUE":0,"accountno":"1019000001258","custShortName":"Salso","classdesc":null,"customerNo":"9000257","branchname":"ZICB"},"ACCOUNT_SIGNATURE":{"S:Envelope":{"xmlns:S":"http://schemas.xmlsoap.org/soap/envelope/","S:Body":{"QUERYFCUBSSIGSERVICE_IOFS_RES":{"FCUBS_BODY":{"Svvws-Sifsigmaster-IO":{"CUSTOMER_NUMBER":9000257,"SIGID":9000257},"FCUBS_ERROR_RESP":{"ERROR":{"ECODE":"SM-SSO16","EDESC":"No Records Found"}}},"xmlns":"http://fcubs.ofss.com/service/FCUBSSigService","FCUBS_HEADER":{"BRANCH":"001","CORRELID":null,"MSGSTAT":"FAILURE","ENTITY":null,"ACTION":"EXECUTEQUERY","OPERATION":"QueryFCUBSSigService","UBSCOMP":"FCUBS","DESTINATION":"BANKLINK","SOURCE":"FLEXCUBE","USERID":"NEWGEN","FUNCTIONID":"STDCIFIS","SERVICE":"FCUBSSigService","MSGID":6119284000460574}}}}},"FLEXCUBE":{"S:Envelope":{"xmlns:S":"http://schemas.xmlsoap.org/soap/envelope/","S:Body":{"QUERYCUSTACC_IOFS_RES":{"FCUBS_BODY":{"Cust-Account-IO":{"ACC":1019000001258,"BRN":101},"FCUBS_ERROR_RESP":{"ERROR":[{"ECODE":"ST-SAVE-024","EDESC":"Failed to Query Data"},{"ECODE":"ST-VALS-002","EDESC":"Record Not Found for Branch-101:Account-1019000001258"}]}},"xmlns":"http://fcubs.ofss.com/service/FCUBSAccService","FCUBS_HEADER":{"BRANCH":"001","CORRELID":null,"MSGSTAT":"FAILURE","ENTITY":null,"ACTION":"EXECUTEQUERY","OPERATION":"QueryCustAcc","UBSCOMP":"FCUBS","DESTINATION":"NEWGEN","SOURCE":"FLEXCUBE","USERID":"NEWGEN","FUNCTIONID":"STDCUSAC","SERVICE":"FCUBSAccService","MSGID":6119284000460576}}}}},"QUERY_BY_CUSTOMER":{"lastName":"Denis","customerDisplayName":null,"bankingUnitType":null,"mobileNumber":"260979810007","customerRelationType":null,"customerName2":null,"codCompany":null,"phoneNo":"260979810007","idCustomer":"9000257","custFlag":"\u0000","customerType":"WALLET","isPrimary":null,"countryCode":null,"add5":null,"add2":null,"descCustType":"WALLET","add1":"12 Paseli Road","add4":null,"email":"denis93@yahoo.com","add3":null,"passportNumber":null,"codBranch":"001","sex":"M","accNo":{},"dateOfBirth":"1960-12-06 02:00:00","secureCodeHash":null,"customerName":"NO NAME SPECIFIED","firstName":"Salso","nationality":null,"middleName":null,"salutation":null}},"preauthUUID":"3d9293ef-c097-44ad-905a-26333fac7268","timestamp":1570778883971,"status":200}';
			$str1 = '{"request-reference":"20191110-ZICB-1570779527884","request":{"firstName":"Salaman","lastName":"Johnny","uniqueValue":"7829901022","mobileNumber":"260967307151","sex":"M","uniqueType":"NRC","dateOfBirth":"1960-12-06","currency":"ZMW","add2":"","accType":"WA","add1":"Plot 110 Cadastral Zone","email":"smicer66@yahoo.com"},"response":{"tekHeader":{"tekesbrefno":"ab05783d-b1e9-ccae-8d03-e94fde6a12b9","warnList":{},"hostrefno":null,"errList":{},"msgList":{"TEKESBWALLET_3":"HTTP STATUS CODE=500","TEKESBWALLET_4":"500 null"},"status":"FAIL","username":"TEKESBRETAIL"},"cust":null},"preauthUUID":"5dcf5959-7533-4266-ba83-6243d3e7f28f","timestamp":1570779527885,"status":200}';
			//dd([json_decode($str), json_decode($str1)]);
			//dd($projectWatchlist);//$project_watchlist
			$countries = \App\Models\Country::all();
			$displayMessaging = false; 
			if($project->open_to_discussion==1 && !in_array($project->status, ['CANCELED', 'COMPLETED']))
			{
				if(\Auth::user() && \Auth::user()->role_type=='Private Client' && \Auth::user()->id==$project->created_by_user_id && $winningBid!=null)
				{
					$displayMessaging = true;
				}
				else
				{
					if(\Auth::user() && \Auth::user()->role_type!='Private Client')
					{
						$displayMessaging = true;
					}
				}
			}
			
			//dd($displayMessaging);
			//dd(\Auth::user()->guarantor[0]->district);
			return view('task-details', compact('displayMessaging', 'projectBids', 'countries', 'projectBid', 'winningBid', 'allowBidding', 'displayOtherProjects', 'otherProjects', 'project', 'userFavs', 'projectWatchlist', 'completedProjects', 'allProjects', 'openProjects', 'completedProjects', 'assignedProjects'));
		}
		else
		{
			return \Redirect::back()->with('error', 'Invalid project selected. No project was found');
		}
	}
	
	
	public function getDeleteSkill($listId=NULL)
	{
		$skill_ = \App\Models\Skill::where('id', '=', $listId)->first();
		if($skill_==null)
			return \Redirect::back()->with('error', 'Skill not found.');
		
		$skill_->delete();
		return \Redirect::back()->with('success', 'Skill deleted successfully');
	}
	
	
	public function getNewSkills($listId=NULL)
	{
		$header=  'My Projects';
		$title=  'My Projects';
		$detail = 'List of all my projects';
		$type = "My Projects";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All My Projects', 'url'=>null, 'active'=>1]];
		$skill = null;
		if($listId!=null)
		{
			$skill = \App\Models\Skill::where('id', '=', $listId)->first();
		}
		return view('admin.new-project-skills', compact('listing', 'header', 'listId', 'title', 'detail', 'type', 'breadcrumbs', 'skill'));
	}
	
	public function postNewSkills($listId=NULL, \Illuminate\Http\Request $request)
	{
		//dd($listId);
		if($listId!=null)
		{
			$all = $request->all();
			$rules = ['skillname' => 'required'];
				
			$messages = [
				'skillname.required' => 'You must provide at a skill name'
			];
			$validator = \Validator::make($request->all(), $rules, $messages);
			if($validator->fails())
			{
				$errMsg = json_decode($validator->messages(), true);
				$str_error = "";
				$i = 1;
				foreach($errMsg as $key => $value)
				{
					foreach($value as $val) {
						$str_error = $str_error.($val)."<br>";
					}
				}
				//dd($str_error);
				return \Redirect::back()->withInput($all)->with('error', $str_error);
			}
			
			$skill = $all['skillname'];
			$inspection_required = isset($all['inspection_required']) ? $all['inspection_required'] : 0;
			$updated = false;
			
			if($skill!=null && strlen(trim($skill))>0)
			{
				$skill_ = \App\Models\Skill::where('id', '=', $listId)->first();
				if($skill_!=null)
				{
					$insp = $inspection_required;
					//dd($insp);
					$skill_->skill_name = $skill;
					$skill_->inspection_required = $insp;
					$skill_->skill_slug = strtolower(str_slug($skill, '-'));
					$skill_->save();
					$updated = true;
				}
			}
			
			//dd(33);
			if($updated==true)
			{
				return \Redirect::to('/admin/all-skills')->with('success', 'Skill updated successfully.');
			}
			return \Redirect::back()->withInput($all)->with('error', 'Skill could not be updated successfully. Please try again');
		}
		else
		{
			$all = $request->all();
			$rules = ['skillname' => 'min:1'];
				
			$messages = [
				'skillname.min' => 'You must provide at least one skill'
			];
			$validator = \Validator::make($request->all(), $rules, $messages);
			if($validator->fails())
			{
				$errMsg = json_decode($validator->messages(), true);
				$str_error = "";
				$i = 1;
				foreach($errMsg as $key => $value)
				{
					foreach($value as $val) {
						$str_error = $str_error.($val)."<br>";
					}
				}
				//dd($str_error);
				return \Redirect::back()->withInput($all)->with('error', $str_error);
			}
			
			$skills = $all['skillname'];
			$inspection_required = isset($all['inspection_required']) ? $all['inspection_required'] : [];
			$created = false;
			for($i=0; $i<sizeof($skills); $i++)
			{
				$skill = $skills[$i];
				$skill = $skills[$i];
				if($skill!=null && strlen(trim($skill))>0)
				{
					$skill_ = \App\Models\Skill::where('skill_name', '=', $skill)->first();
					if($skill_==null)
					{
						$insp = in_array(($i+1), $inspection_required) ? 1 : 0;
						$skill_ = new \App\Models\Skill();
						$skill_->skill_name = $skill;
						$skill_->inspection_required = $insp;
						$skill_->skill_slug = strtolower(str_slug($skill, '-'));
						//dd($skill_);
						$skill_->save();
						$created = true;
						
						
					}
				}
			}
			
			if(sizeof($skills)>0)
			{
				$users = \App\User::where('role_type', '=', 'Artisan')->get();
				foreach($users as $user)
				{
					$notif_code = strtolower(str_random(8));
					$notification_contents = '<span class="label label-success">NEW</span> New skills added to our platform';
					$notification_url = '/notifications/'.$notif_code;
					$receiver_user_id = $user->id;
					$type = 'NEW_SKILL';
					addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, NULL);
				}
			}
			
			if($created==true)
			{
				return \Redirect::to('/admin/all-skills')->with('success', 'New skill(s) created successfully.');
			}
			return \Redirect::back()->withInput($all)->with('error', 'New skills(s) could not be created successfully. Please try again');
		}
	}
	
	
	public function addPersonToFavorites($userCode)
	{
		if(\Auth::user() && \Auth::user()->user_code!=$userCode)
		{
			$person_favorites = \Auth::user()->person_favorites==null ? null : json_decode(\Auth::user()->person_favorites, TRUE);
			
			$user = \App\User::where('user_code', '=', $userCode)->first();
			if($user==null)
			{
				return \Redirect::back()->with('error', 'Your addition to your favorites was not successful. We could not find the person matching your selection with an active profile on our platform. Please try again');
			}
			
			if($person_favorites==null)
			{
				$person_favorites = [];
				array_push($person_favorites, $user->id);
			}
			else
			{
				if(in_array($user->id, $person_favorites))
				{
					
				}
				else
				{
					array_push($person_favorites, $user->id);
				}
			}
			
			$user_ = \Auth::user();
			$user_->person_favorites = json_encode($person_favorites);
			$user_->save();
			return \Redirect::back()->with('success', 'Your selection has been added to your list of favorite people');
		}
		else
		{
			if(\Auth::user() && \Auth::user()->user_code==$userCode)
			{
				return \Redirect::back()->with('error', 'You can not add your profile to your list of favorite people');
			}
			return \Redirect::back()->with('error', 'You need to be logged in to add people to your list of favorites');
		}
		
	}
	
	public function removePersonFromFavorites($userCode)
	{
		if(\Auth::user() && \Auth::user()->user_code!=$userCode)
		{
			$person_favorites = \Auth::user()->person_favorites==null ? [] : json_decode(\Auth::user()->person_favorites, TRUE);
			
			$user = \App\User::where('user_code', '=', $userCode)->first();
			if($user==null)
			{
				return \Redirect::back()->with('error', 'Your addition to your favorites was not successful. We could not find the person matching your selection with an active profile on our platform. Please try again');
			}
			
			if(sizeof($person_favorites)==0)
			{
				$person_favorites = null;
			}
			else
			{
				if(in_array($user->id, $person_favorites))
				{
					$new_person_favorites = [];
					foreach($person_favorites as $person_favorite)
					{
						if($person_favorite!=$user->id)
							array_push($new_person_favorites, $person_favorite);
					}
					$person_favorites = $new_person_favorites;
				}
			}
			
			$user_ = \Auth::user();
			$user_->person_favorites = json_encode($person_favorites);
			$user_->save();
			return \Redirect::back()->with('success', 'Your selection has been removed from your list of favorite people');
		}
		else
		{
			if(\Auth::user() && \Auth::user()->user_code==$userCode)
			{
				return \Redirect::back()->with('error', 'You can not remove your profile from your list of favorite people');
			}
			return \Redirect::back()->with('error', 'You need to be logged in to remove people from your list of favorites');
		}
		
	}
	
	
	public function addProjectToWatchlist($project_url)
	{
		$project_watchlists = \Auth::user() && \Auth::user()->project_watchlist!=null ? json_decode(\Auth::user()->project_watchlist, TRUE) : null;
		
		//dd($project_watchlists);
			
		$project = \App\Models\Project::where('project_url', '=', $project_url)->first();
		if($project==null)
		{
			return \Redirect::back()->with('error', 'Project addition to your watchlist was not successful. We could not find the project to add to your watchlist. Please try again');
		}
		
		if($project_watchlists==null)
		{
			//dd(33);
			$project_watchlists = [];
			array_push($project_watchlists, $project->id);
		}
		else
		{
			//dd($project);
			if(in_array($project->id, $project_watchlists))
			{
				//dd(333);
			}
			else
			{
				//dd(33);
				array_push($project_watchlists, $project->id);
			}
		}
		//dd($project_watchlists);
		$user_ = \Auth::user();
		$user_->project_watchlist = json_encode($project_watchlists);
		$user_->save();
		return \Redirect::back()->with('success', 'Your selection has been added to your list of project watchlist');
		
	}
	
	public function removeProjectFromWatchlist($project_url)
	{
		
		$project_watchlists = \Auth::user()->project_watchlist==null ? [] : json_decode(\Auth::user()->project_watchlist, TRUE);
		
		$project = \App\Models\Project::where('project_url', '=', $project_url)->first();
		if($project==null)
		{
			return \Redirect::back()->with('error', 'Project addition to your watchlist was not successful. We could not find a project matching your selection. Please try again');
		}
		
		if(sizeof($project_watchlists)==0)
		{
			$project_watchlists = null;
		}
		else
		{
			if(in_array($project->id, $project_watchlists))
			{
				$new_project_watchlists = [];
				foreach($project_watchlists as $project_watchlist)
				{
					if($project_watchlist!=$project->id)
						array_push($new_project_watchlists, $project_watchlist);
				}
				$project_watchlists = $new_project_watchlists;
			}
		}
		
		$user_ = \Auth::user();
		$user_->project_watchlist = json_encode($project_watchlists);
		$user_->save();
		return \Redirect::back()->with('success', 'Your selection has been removed from your project watchlist');
		
		
	}
	
	
	public function getBidOnProject($project_url)
	{
		$project = \App\Models\Project::where('project_url', '=', $projectUrl)->first();
		if($project!=null)
		{
			return \Redirect::to('/project-details/'.$project->project_url);
		}
		else
			return \Redirect::back()->with('error', 'Project could not be found');
	}
	
	
	public function releaseProjectBidFunds($project_ref, $bid_code, \Illuminate\Http\Request $request)
	{
		\DB::beginTransaction();
		$project = \App\Models\Project::where('project_ref', '=', $project_ref)->where('paid_out_yes', '=', 0)->first();
		//dd($project);
		if($project!=null)
		{
			if($project->status=='COMPLETED')
			{
				$projectBid = \App\Models\ProjectBid::where('bid_code', '=', $bid_code)->first();
				
				if($projectBid==null)
				{
					\DB::rollback();
					return \Redirect::back()->with('error', 'We could not release the workers funds as we could not find a valid bid. Please try again');	
				}
				
				$project->paid_out_yes = 1;
				$project->save();
				
				
				$all = $request->all();
				$receiver = null;
				
				$trans_ref = strtoupper(str_random(16));
				$params1 = [];
				$params1['project_id'] = $project->id;
				$currency = $project->project_currency;
				
				$transaction = new \App\Models\Transaction();
				$transaction->transaction_user_id = \Auth::user()->id;
				$transaction->reference_no = $trans_ref;
				$transaction->total_amount = $projectBid->bid_amount;
				$transaction->project_id = $project->id;
				$transaction->payment_channel = 'WEB';
				$transaction->status = 'SUCCESS';
				$transaction->payment_type = 'BID PAYMENT';
				$transaction->currency = $currency;
				$transaction->request_data = json_encode($params1);
				if($transaction->save())
				{
					$serviceAccountAmount = $projectBid->bid_amount * 0.05;
					$creditAccountAmount = $projectBid->bid_amount - $serviceAccountAmount;
					$wallet = \App\Models\Wallet::where('wallet_user_id', '=', $project->assigned_bidder_id)->where('currency', '=', $currency)->first();
					if($wallet==null)
					{
						$wallet = new \App\Models\Wallet();
						$wallet->wallet_user_id = $project->assigned_bidder_id;
						$wallet->wallet_number = strtoupper(str_random(8));
						$wallet->currency = $currency;
						$wallet->current_balance = 0.0;
						$wallet->save();
					}
					
					$wt = new \App\Models\WalletTransaction();
					$wt->wallet_id = $wallet->id;
					$wt->amount = $creditAccountAmount;
					$wt->transaction_type = 'CREDIT';
					$wt->transaction_ref = strtoupper(strtolower(str_random(16)));
					$wt->paid_by_user_id = $project->created_by_user_id;
					$wt->status = 'SUCCESS';
					$wt->wallet_user_id = $project->assigned_bidder_id;
					$wt->save();
					
					$wallet->current_balance = $wallet->current_balance + $creditAccountAmount;
					$wallet->save();
					
					$otherProjects = \App\Models\Project::whereNotIn('id', [$project->id])->with('state')->get();
					if($otherProjects->count()>3)
					{
						$displayOtherProjects = true;
						$otherProjects = $otherProjects->random(3);
					}
					else if($otherProjects->count()==0)
					{
						$displayOtherProjects = false;
						$otherProjects = [];
					}
					else 
					{
						$displayOtherProjects = true;
						$otherProjects = $otherProjects->random($otherProjects->count());
					}
					
					$notif_code = strtolower(str_random(8));
					$notification_contents = '<span class="label label-success">PAY</span> Your payment has been released';
					$notification_url = '/notifications/'.$notif_code;
					$receiver_user_id = $project->assigned_bidder_id;
					$type = "PAYMENT_RELEASE";
					addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
					
					
					$msg = 'Payment for project #'.strtoupper($project->project_ref).' has been released';
					//send_sms($project->assigned_bidder->mobile_number, $msg, $utilities, null);
					send_mail('email.funds_release_notify_artisan', $project->assigned_bidder->email_address, $project->assigned_bidder->last_name . ' ' . $project->assigned_bidder->first_name,
						'HandyMade - Payment for project #'.strtoupper($project->project_ref).' has been released',
						[
							'last_name' => $project->assigned_bidder->last_name, 
							'first_name' => $project->assigned_bidder->first_name,
							'client_first_name' => $project->assigned_bidder->first_name,
							'project' => $project,
							'releasedAmount' => $creditAccountAmount,
							'serviceAccountAmount' => $serviceAccountAmount,
							'projectBid' => $projectBid,
							'otherProjects' => $otherProjects
						]
					);
					
					\DB::commit();
					return \Redirect::back()->with('success', 'The sum of '.$currency.''.number_format($projectBid->bid_amount, 2, '.', ',').' has been released to '.$projectBid->bid_by_user->first_name.'. Thank you for using HandyMade');
				}
				else
				{
					\DB::rollback();
					return \Redirect::back()->with('error', 'We could not release the sum of '.$currency.''.number_format($projectBid->bid_amount, 2, '.', ',').' to '.$projectBid->bid_by_user->first_name);	
				}
			}
			else
			{
				\DB::rollback();
				return \Redirect::back()->with('error', 'The current status of the project does not allow you to release funds to the worker. First indicate that that project has been completed before you can release funds to the worker');
			}
		}
		else
		{
			\DB::rollback();
			return \Redirect::back()->with('error', 'Project could not be found');
		}
	}
	
	
	
	public function sendProjectMessage($project_url, \Illuminate\Http\Request $request)
	{
		\DB::beginTransaction();
		$project = \App\Models\Project::where('project_url', '=', $project_url)->first();
		if($project!=null)
		{
			if($project->status=='OPEN' || $project->status=='ASSIGNED' ||  $project->status=='IN PROGRESS')
			{
				if($project->status=='ASSIGNED' && $project->assigned_bidder_id!=\Auth::user()->id && \Auth::user()->role_type=='Artisan')
				{
					return \Redirect::back()->with('error', 'You can not send a message on this project');
				}
				if((\Auth::user()->role_type=='Private Client' || \Auth::user()->role_type=='Corporate Client') && \Auth::user()->id!=$project->created_by_user_id)
				{
					return \Redirect::back()->with('error', 'You can not send a message on this project');
				}
				$all = $request->all();
				
				$receiver = null;
				if(isset($all['receiver']) && \Auth::user()->role_type=='Private Client')
				{
					$receiver = $all['receiver'];
					$receiver = \App\User::where('user_code', '=', $receiver)->first();
				}
				
				$messageThreadCode1 = "";
				$messageThreadCode2 = "";
				if($project->status=='ASSIGNED')
				{
					if(\Auth::user()->role_type=='Artisan')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						$messageThreadCode2 = $project->id."".$project->created_by_user->user_code."".\Auth::user()->user_code;
					}
					else if(\Auth::user()->role_type=='Private Client')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$project->assigned_bidder->user_code;
						$messageThreadCode2 = $project->id."".$project->assigned_bidder->user_code."".\Auth::user()->user_code;
					}
				}
				else if($project->status=='OPEN')
				{
					if(\Auth::user()->role_type=='Artisan')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						$messageThreadCode2 = $project->id."".$project->created_by_user->user_code."".\Auth::user()->user_code;
					}
					else if(\Auth::user()->role_type=='Private Client')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$receiver->user_code;
						$messageThreadCode2 = $project->id."".$receiver->user_code."".\Auth::user()->user_code;
					}
				}
				else if($project->status=='IN PROGRESS')
				{
					if(\Auth::user()->role_type=='Artisan')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						$messageThreadCode2 = $project->id."".$project->created_by_user->user_code."".\Auth::user()->user_code;
					}
					else if(\Auth::user()->role_type=='Private Client')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$project->assigned_bidder->user_code;
						$messageThreadCode2 = $project->id."".$project->assigned_bidder->user_code."".\Auth::user()->user_code;
					}
				}
				$messageThread = \App\Models\MessageThread::where('project_id', '=', $project->id)->whereIn('threadCode', [$messageThreadCode1, $messageThreadCode2])->first();
				
				if($messageThread==null)
				{
					$messageThread = new \App\Models\MessageThread();
					if($project->status=='ASSIGNED')
					{
						if(\Auth::user()->role_type=='Artisan')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						}
						else if(\Auth::user()->role_type=='Private Client')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$project->assigned_bidder->user_code;
						}
					}
					else if($project->status=='OPEN')
					{
						if(\Auth::user()->role_type=='Artisan')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						}
						else if(\Auth::user()->role_type=='Private Client')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$receiver->user_code;
						}
					}
					else if($project->status=='IN PROGRESS')
					{
						if(\Auth::user()->role_type=='Artisan')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						}
						else if(\Auth::user()->role_type=='Private Client')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$project->assigned_bidder->user_code;
						}
					}
					$messageThread->project_id = $project->id;
					$messageThread->last_message = '';
					$messageThread->save();
					
				}
				
				$message = new \App\Models\Message();
				$message->sender_user_id = \Auth::user()->id;
				
				if(\Auth::user()->role_type=='Private Client')
				{
					if($project->status=='ASSIGNED')
						$message->receipient_user_id = \Auth::user()->id;
					else if($project->status=='OPEN')
						$message->receipient_user_id = $receiver->id;
					if($project->status=='IN PROGRESS')
						$message->receipient_user_id = \Auth::user()->id;
				}
				else if(\Auth::user()->role_type=='Artisan')
				{
					if($project->status=='ASSIGNED')
						$message->receipient_user_id = $project->created_by_user->id;
					else if($project->status=='OPEN')
						$message->receipient_user_id = $project->created_by_user->id;
					if($project->status=='IN PROGRESS')
						$message->receipient_user_id = \Auth::user()->id;
				}
				
				$message->message_body = $all['message'];
				$message->project_id = $project->id;
				$message->receipient_read_yes = 1;
				$message->message_thread_id = $messageThread->id;
				$message->message_code = strtolower(str_random(8));
				$message->save();
                \DB::commit();
				
				
				$notif_code = strtolower(str_random(8));
				$notification_contents = '<span class="label label-success">NEW</span> You have a new message';
				$notification_url = '/notifications/'.$notif_code;
				$receiver_user_id = $message->receipient_user_id;
				$type = "NEW_MESSAGE";
				addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $messageThread->id);


                $messageThread->last_message_id = $message->id;
                $messageThread->last_message = $all['message'];
				$messageThread->save();
				return \Redirect::back()->with('success', 'Your message has been sent successfully');
			}
			else
			{
				\DB::rollback();
				return \Redirect::back()->with('error', 'The current status of the project does not allow you to send a message');
			}
		}
		else
		{
			\DB::rollback();
			return \Redirect::back()->with('error', 'Project could not be found');
		}
	}
	
	
	public function sendSupportMessage($project_url, \Illuminate\Http\Request $request)
	{
		//dd($request->all());
		\DB::beginTransaction();
		$project = \App\Models\Project::where('project_url', '=', $project_url)->first();
		if($project!=null)
		{
			if($project->status=='OPEN' || $project->status=='ASSIGNED')
			{
				if($project->status=='ASSIGNED' && $project->assigned_bidder_id!=\Auth::user()->id)
				{
					return \Redirect::back()->with('error', 'You can not send a message on this project');
				}
				if(\Auth::user()->role_type=='Private Client' && \Auth::user()->id!=$project->created_by_user_id)
				{
					return \Redirect::back()->with('error', 'You can not send a message on this project');
				}
				$all = $request->all();
				
				$receiver = null;
				if(isset($all['receiver']) && \Auth::user()->role_type=='Private Client')
				{
					$receiver = $all['receiver'];
					$receiver = \App\User::where('user_code', '=', $receiver)->first();
				}
				
				$messageThreadCode1 = "";
				$messageThreadCode2 = "";
				if($project->status=='ASSIGNED')
				{
					if(\Auth::user()->role_type=='Artisan')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						$messageThreadCode2 = $project->id."".$project->created_by_user->user_code."".\Auth::user()->user_code;
					}
					else if(\Auth::user()->role_type=='Private Client')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$project->assigned_bidder->user_code;
						$messageThreadCode2 = $project->id."".$project->assigned_bidder->user_code."".\Auth::user()->user_code;
					}
				}
				else if($project->status=='OPEN')
				{
					if(\Auth::user()->role_type=='Artisan')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						$messageThreadCode2 = $project->id."".$project->created_by_user->user_code."".\Auth::user()->user_code;
					}
					else if(\Auth::user()->role_type=='Private Client')
					{
						$messageThreadCode1 = $project->id."".\Auth::user()->user_code."".$receiver->user_code;
						$messageThreadCode2 = $project->id."".$receiver->user_code."".\Auth::user()->user_code;
					}
				}
				$messageThread = \App\Models\SupportThread::where('project_id', '=', $project->id)->whereIn('threadCode', [$messageThreadCode1, $messageThreadCode2])->first();
				$newThread = false;
				if($messageThread==null)
				{
					$messageThread = new \App\Models\SupportThread();
					if($project->status=='ASSIGNED')
					{
						if(\Auth::user()->role_type=='Artisan')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						}
						else if(\Auth::user()->role_type=='Private Client')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$project->assigned_bidder->user_code;
						}
					}
					else if($project->status=='OPEN')
					{
						if(\Auth::user()->role_type=='Artisan')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$project->created_by_user->user_code;
						}
						else if(\Auth::user()->role_type=='Private Client')
						{
							$messageThread->threadCode = $project->id."".\Auth::user()->user_code."".$receiver->user_code;
						}
					}
					$messageThread->project_id = $project->id;
					$messageThread->last_message = '';
					$messageThread->save();
					$newThread = true;
				}
				
				
				$all_user_files = [];
				if ($request->hasFile('supportFiles')) {
					$files = $request->file('supportFiles');
					//dd($files);
					//dd($files);
					foreach($files as $file)
					{
						$file_name = str_random(25) . '.' . $file->getClientOriginalExtension();
						$dest = 'img/clients/';
						$file->move($dest, $file_name);
						$userFile = new \App\Models\UserFile();
						$userFile->file_name = $file_name;
						$userFile->image_type = 'SUPPORT MESSAGE';
						$userFile->save();
						array_push($all_user_files, $userFile);
					}
				}
				
				//dd(11);
				$message = new \App\Models\SupportMessage();
				$message->sender_user_id = \Auth::user()->id;
				
				if(\Auth::user()->role_type=='Private Client')
				{
					if($project->status=='ASSIGNED')
						$message->receipient_user_id = \Auth::user()->id;
					else if($project->status=='OPEN')
						$message->receipient_user_id = $receiver->id;
				}
				else if(\Auth::user()->role_type=='Artisan')
				{
					if($project->status=='ASSIGNED')
						$message->receipient_user_id = $project->created_by_user->id;
					else if($project->status=='OPEN')
						$message->receipient_user_id = $project->created_by_user->id;
				}
				
				$message->message_body = $all['message'];
				$message->project_id = $project->id;
				$message->receipient_read_yes = 1;
				$message->message_thread_id = $messageThread->id;
				$message->message_code = strtolower(str_random(8));
				$message->save();
				
				
				
				
				$notif_code = strtolower(str_random(8));
				$notification_contents = '<span class="label label-success">TKT</span> New support ticket opened/updated';
				$notification_url = '/notifications/'.$notif_code;
				$receiver_user_id = $message->receipient_user_id;
				$type = "NEW_SUPPORT_TICKET";
				addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $messageThread->id);
				
				
				foreach($all_user_files as $all_user_file)
				{
					$all_user_file->support_message_id = $message->id;
					$all_user_file->save();
				}
				
				$messageThread->last_message = $all['message'];
				$messageThread->save();
				\DB::commit();
				
				if($newThread==true)
					return \Redirect::back()->with('success', 'Your support thread has been raised successfully');
				else
					return \Redirect::back()->with('success', 'Your support messsage has been sent successfully');
			}
			else
			{
				\DB::rollback();
				return \Redirect::back()->with('error', 'The current status of the project does not allow you to send a message');
			}
		}
		else
		{
			\DB::rollback();
			return \Redirect::back()->with('error', 'Project could not be found');
		}
	}
	
	public function cancelProject($projectUrl, \Illuminate\Http\Request $request)
	{
		\DB::beginTransaction();
		$project = \App\Models\Project::where('project_url', '=', $projectUrl)->where('created_by_user_id', '=', \Auth::user()->id)->first();
		if($project!=null)
		{
			$all = $request->all();
			$rules = ['cancelationReason' => 'required'];
				
			$messages = [
				'cancelationReason.required' => 'You must provide a reason for the cancelation of your project'
			];
			$validator = \Validator::make($request->all(), $rules, $messages);
			if($validator->fails())
			{
				$errMsg = json_decode($validator->messages(), true);
				$str_error = "";
				$i = 1;
				foreach($errMsg as $key => $value)
				{
					foreach($value as $val) {
						$str_error = $str_error.($val)."<br>";
					}
				}
				return \Redirect::back()->withInput($all)->with('error', $str_error);
			}
			
			if($project->status=='OPEN')
			{
				if(\Auth::user() && \Auth::user()->role_type=='Private Client')
				{
					
					$projectBids = \App\Models\ProjectBid::where('project_id', '=', $project->id)->where('status', '=', 'Valid')->get();
					if($projectBids!=null)
					{
						foreach($projectBids as $projectBid)
						{
							//SEND EMAIL INFORMING PROJECT HAS BEEN CANCELED
						}
					}
					
					$project->canceled_reason = utf8_encode($all['cancelationReason']);
					$project->status = 'CANCELED';
					if($project->save())
					{
						$trans_ref = strtoupper(str_random(16));
						$params1 = [];
						$params1['project_id'] = $project->id;
						$currency = $project->project_currency;
						//dd($currency);
						$transaction = new \App\Models\Transaction();
						$transaction->transaction_user_id = \Auth::user()->id;
						$transaction->reference_no = $trans_ref;
						$transaction->total_amount = $project->budget + $project->vat  + $project->service_charge ;
						$transaction->project_id = $project->id;
						$transaction->payment_channel = 'WEB';
						$transaction->status = 'SUCCESS';
						$transaction->payment_type = 'PROJECT CANCELATION';
						$transaction->currency = $currency;
						$transaction->request_data = json_encode($params1);
						if($transaction->save())
						{
							$cancelation_charge = CANCELATION_FEE;
							$trans_ref = strtoupper(str_random(16));
							$transaction = new \App\Models\Transaction();
							$transaction->transaction_user_id = \Auth::user()->id;
							$transaction->reference_no = $trans_ref;
							$transaction->total_amount = $cancelation_charge ;
							$transaction->project_id = $project->id;
							$transaction->payment_channel = 'WEB';
							$transaction->status = 'SUCCESS';
							$transaction->payment_type = 'CANCELATION FEE';
							$transaction->currency = $currency;
							$transaction->request_data = json_encode($params1);
							if($transaction->save())
							{
								
								if($project->bids!=null)
								{
									foreach($project->bids as $bid)
									{
										$notif_code = strtolower(str_random(8));
										$notification_contents = '<span class="label label-success">PRJ</span> Project #'.strtoupper($project->project_ref).' Canceled';
										$notification_url = '/notifications/'.$notif_code;
										$receiver_user_id = $bid->bid_by_user_id;
										$type = "PROJECT_CANCEL";
										addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
									}
								}
				
								\DB::commit();
								return \Redirect::back()->with('success', 'Your project has been canceled and your funds placed in an escrow account for a refund. The necessary cancelation charges were applied to your funds');
							}
							else
							{
								\DB::rollback();
								return \Redirect::back()->with('error', 'Your project could not be canceled. Please try to cancel the project again');
							}
						}
						else
						{
							\DB::rollback();
							return \Redirect::back()->with('error', 'Your project could not be canceled. Please try to cancel the project again');
						}
					}
					else
					{
						\DB::rollback();
						return \Redirect::back()->with('error', 'Your project could not be canceled. Please try to cancel the project again');
					}
				}
				else
				{
					\DB::rollback();
					return \Redirect::back()->with('error', 'You can not cancel this project as you are not the project owner');
				}
			}
			else
			{
				\DB::rollback();
				return \Redirect::back()->with('error', 'You can not cancel this project as its not longer open for cancelation');
			}
		}
	}
	
	
	public function markProjectCompleted($projectUrl, \Illuminate\Http\Request $request)
	{
		
		\DB::beginTransaction();
		$project = null;
		if(\Auth::user() && \Auth::user()->role_type=='Private Client')
			$project = \App\Models\Project::where('project_url', '=', $projectUrl)->where('created_by_user_id', '=', \Auth::user()->id)->first();
		else if(\Auth::user() && \Auth::user()->role_type=='Artisan')
			$project = \App\Models\Project::where('project_url', '=', $projectUrl)->first();
		
		//dd($project);
		if($project!=null)
		{
			$all = $request->all();
			$rules = ['rating' => 'required', 'reviewClient'=>'required'];
				
			$messages = [
				'rating.required' => 'Provide a rating for this project in regards to the client',
				'reviewClient.required' => 'Provide a review of the clients performance during the project'
			];
			$validator = \Validator::make($request->all(), $rules, $messages);
			if($validator->fails())
			{
				$errMsg = json_decode($validator->messages(), true);
				$str_error = "";
				$i = 1;
				foreach($errMsg as $key => $value)
				{
					foreach($value as $val) {
						$str_error = $str_error.($val)."<br>";
					}
				}
				//dd($str_error);
				return \Redirect::back()->withInput($all)->with('error', $str_error);
			}
			//dd(11);
			if($project->status=='IN PROGRESS')
			{
				//dd(\Auth::user()->role_type);
				if(\Auth::user() && \Auth::user()->role_type=='Private Client' && $project->created_by_user_id==\Auth::user()->id)
				{
					$project->worker_rating = $all['rating'];
					$project->worker_review = utf8_encode($all['reviewClient']);
					$project->status = 'COMPLETED';
					$project->completed_by_worker = 1;
					$project->paid_out_yes = 0;
					if($project->save())
					{
						$user_ = \App\User::where('id', '=', $project->assigned_bidder_id)->first();
						$userRating = $user_->total_user_rating;
						$totalRatingCount = $user_->rating_count;
						$userRating = $userRating * 5;
						$userRating = $userRating + $all['rating'];
						$totalRatingCount = $totalRatingCount + 1;
						$userRating = $userRating/$totalRatingCount;
						$user_->total_user_rating = $userRating;
						$user_->rating_count = $totalRatingCount;
						$user_->save();
						\DB::commit();
						
						$notif_code = strtolower(str_random(8));
						$notification_contents = '<span class="label label-success">PRJ</span> Project #'.strtoupper($project->project_ref).' Completed! You can release workers payment';
						$notification_url = '/notifications/'.$notif_code;
						$receiver_user_id = $project->created_by_user_id;
						$type = "CLIENT_RELEASE_PAYMENT";
						addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
						
						
						$notif_code = strtolower(str_random(8));
						$notification_contents = '<span class="label label-success">PRJ</span> Project #'.strtoupper($project->project_ref).' Completed! Client confirmation of completion';
						$notification_url = '/notifications/'.$notif_code;
						$receiver_user_id = $project->assigned_bidder_id;
						$type = "CLIENT_COMPLETION_CONFIRMATION";
						addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
						
						return \Redirect::back()->with('success', 'Your project has been marked as completed. Please proceed to release the workers funds.');
					}
					else
					{
						\DB::rollback();
						return \Redirect::back()->with('error', 'Your project could not be marked as completed. Please try to mark the project as completed again');
					}
				}
				else if(\Auth::user() && \Auth::user()->role_type=='Artisan' && $project->assigned_bidder_id==\Auth::user()->id)
				{
					
					$project->client_rating = $all['rating'];
					$project->client_review = utf8_encode($all['reviewClient']);
					$project->completed_by_worker = 1;
					if($project->save())
					{
						$user_ = \App\User::where('id', '=', $project->created_by_user_id)->first();
						$userRating = $user_->total_user_rating;
						$totalRatingCount = $user_->rating_count;
						$userRating = $userRating * 5;
						$userRating = $userRating + $all['rating'];
						$totalRatingCount = $totalRatingCount + 1;
						$userRating = $userRating/$totalRatingCount;
						$user_->total_user_rating = $userRating;
						$user_->rating_count = $totalRatingCount;
						$user_->save();
						\DB::commit();
						
						$notif_code = strtolower(str_random(8));
						$notification_contents = '<span class="label label-success">PRJ</span> Project #'.strtoupper($project->project_ref).' Completed! Please confirm completion';
						$notification_url = '/notifications/'.$notif_code;
						$receiver_user_id = $project->created_by_user_id;
						$type = "WORKER_COMPLETION_CONFIRMATION";
						addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
						
						
						return \Redirect::back()->with('success', 'The project has been marked as completed. A notification has been sent to the client to release your payment. Thank you for patronizing out service');
					}
					else
					{
						\DB::rollback();
						return \Redirect::back()->with('error', 'The project has been marked as completed. Please try to mark the project as completed again');
					}
				}
				else
				{
					\DB::rollback();
					return \Redirect::back()->with('error', 'You can not mark this project as completed as you are not the project owner or you did not work on this project');
				}
			}
			else
			{
				\DB::rollback();
				return \Redirect::back()->with('error', 'You can not mark this project as completed until it has been assigned to a worker');
			}
		}
		\DB::rollback();
		return \Redirect::back()->with('error', 'We could not find this project on our platform');
	}
	
	
	public function assignBidToProject($project_code, $project_bid_code)
	{
		\DB::beginTransaction();
		$project = \App\Models\Project::where('project_ref', '=', strtoupper($project_code))->where('status', '=', 'OPEN')->where('created_by_user_id', '=', \Auth::user()->id)->first();
		
		if($project!=null)
		{
			$projectBid = \App\Models\ProjectBid::where('bid_code', '=', strtoupper($project_bid_code))->where('status', '=', 'VALID')->where('project_id', '=', $project->id)->first();
			if($projectBid!=null)
			{
				$project->assigned_bidder_id = $projectBid->bid_by_user_id;
				$project->status = 'ASSIGNED';
				if($project->save())
				{
					$projectBid->status = 'WON';
					$projectBid->save();
					\DB::commit();
					
					$notif_code = strtolower(str_random(8));
					$notification_contents = '<span class="label label-success">WON</span> Bid for project #'.strtoupper($project->project_ref).' Won! Please confirm acceptance';
					$notification_url = '/notifications/'.$notif_code;
					$receiver_user_id = $project->assigned_bidder_id;
					$type = "BID_WON";
					addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
					
					return \Redirect::back()->with('success', 'Your selected bid has been assigned the winning bid for this project.');
				}
				else
				{
					\DB::rollback();
					return \Redirect::back()->with('error', 'Your project could not be marked as completed. Please try to mark the project as completed again');
				}
			}
			else
			{
				\DB::rollback();
				return \Redirect::back()->with('error', 'Your selected bid could not be found. Please try to specify which bid has won again');
			}
		}
		\DB::rollback();
		return \Redirect::back()->with('error', 'We could not find this project on our platform');
	}
	
	
	public function acceptHandleProjectBid($project_code, $project_bid_code)
	{
		\DB::beginTransaction();
		$project = \App\Models\Project::where('project_ref', '=', strtoupper($project_code))->where('status', '=', 'ASSIGNED')->first();
		
		if($project!=null)
		{
			$projectBid = \App\Models\ProjectBid::where('bid_code', '=', strtoupper($project_bid_code))->where('status', '=', 'WON')->where('bid_by_user_id', '=', \Auth::user()->id)->where('project_id', '=', $project->id)->first();
			if($projectBid!=null)
			{
				$project->assigned_bidder_id = $projectBid->bid_by_user_id;
				$project->status = 'IN PROGRESS';
				if($project->save())
				{
					\DB::commit();
					
					$notif_code = strtolower(str_random(8));
					$notification_contents = '<span class="label label-success">PRJ</span> Project #'.strtoupper($project->project_ref).' accepted to be handled';
					$notification_url = '/notifications/'.$notif_code;
					$receiver_user_id = $project->created_by_user_id;
					$type = "PROJECT_ACCEPTANCE";
					addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
					
					
					return \Redirect::back()->with('success', 'Your assigned project has officially started. Remember to regularly update your client on the progress of your project. On completion of your project, 
						visit the project page to indicate you have completed the project');
				}
				else
				{
					\DB::rollback();
					return \Redirect::back()->with('error', 'Your project could not be started. Please try again');
				}
			}
			else
			{
				\DB::rollback();
				return \Redirect::back()->with('error', 'Your selected bid could not be found. Please try again');
			}
		}
		\DB::rollback();
		return \Redirect::back()->with('error', 'We could not find this project on our platform');
	}
	
	
	
	
	public function postProjectBid($projectUrl, \Illuminate\Http\Request $request)
	{
		$project = \App\Models\Project::where('project_url', '=', $projectUrl)->first();
		if($project!=null)
		{
			$all = $request->all();
			$rules = ['bidamount' => 'required', 'deliveryPeriod' => 'required', 'periodType' => 'required'];
				
			$messages = [
				'bidamount.required' => 'You must provide your bid amount to place a bid', 
				'deliveryPeriod.required' => 'You must specify how long it would take you to deliver the project', 
				'periodType.required' => 'Specify the currency your bid is in'
			];
			$validator = \Validator::make($request->all(), $rules, $messages);
			if($validator->fails())
			{
				$errMsg = json_decode($validator->messages(), true);
				$str_error = "";
				$i = 1;
				foreach($errMsg as $key => $value)
				{
					foreach($value as $val) {
						$str_error = $str_error.($val)."<br>";
					}
				}
				return \Redirect::back()->withInput($all)->with('error', $str_error);
			}
			
			if($project->status=='OPEN')
			{
				if(\Auth::user() && \Auth::user()->role_type=='Artisan')
				{
					$userSkills = \Auth::user()->artisanSkills;
					$projectSkills = $project->skills;
					foreach($userSkills as $userSkill)
					{
						foreach($projectSkills as $projectSkill)
						{
							//dd([$userSkill->skill]);
							if($projectSkill->skill->id==$userSkill->skill->id)
							{
								$allowBidding = true;
							}
						}
					}
					
					if($allowBidding==true)
					{
						if($all['bidamount']<=$project->budget)
						{
							$projectBid = \App\Models\ProjectBid::where('bid_by_user_id', '=', \Auth::user()->id)->where('status', '=', 'Valid')->first();
							$notification_contents = '<span class="label label-success">BID</span> New Bid for Project #'.strtoupper($project->project_ref).' updated';
							if($projectBid==null)
							{
								$projectBid = new \App\Models\ProjectBid();
								$projectBid->bid_by_user_id = \Auth::user()->id;
								$projectBid->status = 'Valid';
								$projectBid->project_id = $project->id;
								$notification_contents = '<span class="label label-success">BID</span> Bid for Project #'.strtoupper($project->project_ref).' received';
							}
							
							$bid_vat = 0.05*$all['bidamount'];
							$bid_service_charge = 0.05*$all['bidamount'];
							$projectBid->bid_details = $all['bid_details'];
							$projectBid->bid_amount = $all['bidamount'];
							$projectBid->bid_period = $all['deliveryPeriod'];
							$projectBid->bid_period_type = $all['periodType'];
							$projectBid->vat = $bid_vat;
							$projectBid->service_charge = $bid_service_charge;
							$projectBid->bid_code = rand(1000000000, 9999999999);
							if($projectBid->save())
							{
								
								$notif_code = strtolower(str_random(24));
								
								$notification_url = '/notifications/'.$notif_code;
								$receiver_user_id = $project->created_by_user_id;
								$type = "BID_PLACED";
								addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
					
								return \Redirect::back()->with('success', 'Your bid has been sent to the client. You may decided to update your bid while the project is still open');
							}
							else
							{
								return \Redirect::back()->with('error', 'Your bid could not be submitted. You may try to submit your bid again');
							}
						}
						else
						{
							return \Redirect::back()->with('error', 'Your bid amount is more than the specified budget for working on this project. The maximum budget of this project is '.$project->currency.''.number_format($project->budget, 2, '.', ','));
						}
					}
					else
					{
						return \Redirect::back()->with('error', 'You do not have the required skills to work on this project. If you have the skills specified on the project page, add the skills to your set of skills in your profile page');
					}
				}
				else
				{
					return \Redirect::back()->with('error', 'You do not have a Worker account/profile to bid on this project. Sign up for a Worker account/profile to place bids on projects');
				}
			}
			else
			{
				return \Redirect::back()->with('error', 'Invalid project. This project is no longer available for bidding');
			}
		}
	}
	
	
	public function getAllProjects()
	{
		$filterskills = \App\Models\Skill::orderBy('skill_name')->get()->toArray();
		$projects = \App\Models\Project::orderBy('created_at', 'DESC')->get();
		//dd($skills);
		return view('project-list', compact('projects', 'filterskills'));
	}
	
	
	public function getMyProjects()
	{
		$filterskills = \App\Models\Skill::orderBy('skill_name')->get()->toArray();
		$projects = \App\Models\Project::whereNull('deleted_at');
		if(\Auth::user() && \Auth::user()->role_type=='Artisan')
		{
			$bidList = \App\Models\ProjectBid::where('bid_by_user_id', '=', \Auth::user()->id)->get();
			$arr_ = [];
			$bids = [];
			foreach($bidList as $pl)
			{
				array_push($arr_, $pl->project_id);
				$bids[$pl->project_id."-"] = $pl;
			}
			$projects = $projects->whereIn('id', $arr_)->orderBy('created_at', 'DESC')->get();
			
			if($projects->count()==0)
			{
				return \Redirect::back()->with('error', 'You either do not have any projects you have bidded on or have worked on previously');
			}
			
			return view('artisan-project-list', compact('projects', 'filterskills', 'bids'));
		}
		else if(\Auth::user() && \Auth::user()->role_type=='Private Client')
		{
			$projects = $projects->where('created_by_user_id', '=', \Auth::user()->id)->orderBy('created_at', 'DESC')->get();
			
			if($projects->count()==0)
			{
				return \Redirect::back()->with('error', 'You do not have any projects posted on the platform yet');
			}
			
			return view('client-project-list', compact('projects', 'filterskills', 'avgBidAmount'));
		}
		//dd($skills);
		
	}
	
	public function getNewTaskStepOne($projectUrl=NULL)
	{
		$project = null;
		if($projectUrl!=null)
		{
			$project = \App\Models\Project::where('project_url', '=', $projectUrl)->first();
		}
		$countries = \App\Models\Country::all();
		$provinces = \App\Models\States::all();
		//dd($provinces);
		return view('new-task-step-one', compact('countries', 'project', 'provinces'));
	}
	
	public function getNewTaskStepTwo()
	{
		$data = session()->get('step_one_project_data');
		if($data==null)
		{
			return \Redirect::to('/new-project-step-one');
		}
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		return view('new-task-step-two', compact('skills'));
	}
	
	public function getNewTaskStepThree()
	{
		$data = session()->get('step_two_project_data');
		if($data==null)
		{
			return \Redirect::to('/new-project-step-one');
		}
		$artisans = \App\User::where('role_type', '=', 'Artisan')->get();
		//dd($artisans->get());
		return view('new-task-step-three', compact('artisans'));
	}
	
	public function getNewTaskStepFour()
	{
		$data = session()->get('step_three_project_data');
		if($data==null)
		{
			return \Redirect::to('/new-project-step-one');
		}
		$stepOneData = session()->get('step_one_project_data');
		$stepOneData = json_decode($stepOneData);
		$stepTwoData = session()->get('step_two_project_data');
		$stepTwoData = json_decode($stepTwoData);
		$stepThreeData = session()->get('step_three_project_data');
		$stepThreeData = json_decode($stepThreeData);
		//dd([$stepOneData, $stepTwoData, $stepThreeData]);
		
		$skills = \App\Models\Skill::whereIn('id', $stepTwoData->skills)->get();
		$province = \App\Models\States::where('id', '=', $stepOneData->province)->first();
		$district = \App\Models\Lga::where('id', '=', $stepOneData->district)->first();
		$artisans = isset($stepThreeData->artisanList) ? \App\User::whereIn('id', $stepThreeData->artisanList)->get() : null;
		return view('new-task-step-four', compact('skills', 'artisans', 'province', 'district', 'stepOneData', 'stepTwoData', 'stepThreeData'));
	}
	
	public function postNewTaskStepOne(\Illuminate\Http\Request $request)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
		
		$all = $request->all();
		//dd($all);
		$rules = ['title' => 'required', 'startDate' => 'required', 'endDate' => 'required', 'address' => 'required', 
			'deliveryPeriod' => 'required', 'country' => 'required', 'province' => 'required', 'district' => 'required', 
			'budget' => 'required', 'description' => 'required'];
			
		$messages = [
				'title.required' => 'You must provide a title for your project', 'startDate.required' => 'You must provide the start date of your project', 'address.required' => 'Provide your home address which will be verified', 
				'endDate.required' => 'You must provide the end date of your project', 'country.required' => 'You must provide the country you live in', 'province.required' => 'You must provide the province you live in', 
				'district.numeric' => 'Provide the district you live in', 'deliveryPeriod.required' => 'Provide the maximum period allowed for bids to be submitted',
				'budget.required' => 'Specify your maximum acceptable budget. You will need to escrow this amount to create this project', 
				'description.require' => 'Provide details about your project to enable workers bid appropriately'
			];
		$validator = \Validator::make($request->all(), $rules, $messages);
		if($validator->fails())
		{
			$errMsg = json_decode($validator->messages(), true);
			$str_error = "";
			$i = 1;
			foreach($errMsg as $key => $value)
			{
				foreach($value as $val) {
					$str_error = $str_error.($val)."<br>";
				}
			}
			dd($str_error);
			return \Redirect::back()->withInput($all)->with('error', $str_error);
		}
		
		session()->put('step_one_project_data', json_encode($all));
		return \Redirect::to('/new-project-step-two');
	}
	
	protected function postNewTaskStepTwo(\Illuminate\Http\Request $request)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
		
		$all = $request->all();
		//dd($all);
		$rules = ['skills' => 'required|min:1|max:12'];
			
		$messages = [
				'skills.required' => 'You must specify your skillset',
				'skills.max' => 'Maximum number of skills you can select is 12',
				'skills.min' => 'Miniumum number of skills you can select is 1'
			];
		$validator = \Validator::make($request->all(), $rules, $messages);
		if($validator->fails())
		{
			$errMsg = json_decode($validator->messages(), true);
			$str_error = "";
			$i = 1;
			foreach($errMsg as $key => $value)
			{
				foreach($value as $val) {
					$str_error = $str_error.($val)."<br>";
				}
			}
			//dd($str_error);
			return \Redirect::back()->withInput($all)->with('error', $str_error);
		}
		session()->put('step_two_project_data', json_encode($all));
		return \Redirect::to('/new-project-step-three');
	}
	
	protected function postNewTaskStepThree(\Illuminate\Http\Request $request)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
		
		$all = $request->all();
		session()->put('step_three_project_data', json_encode($all));
		return \Redirect::to('/new-project-step-four');
	}
	
	
	protected function postNewTaskStepFour(\Illuminate\Http\Request $request)
    {
        \DB::beginTransaction();
		try
		{
			$password = null;
			$stepOneData = session()->get('step_one_project_data');
			$stepOneData = json_decode($stepOneData, TRUE);
			$stepTwoData = session()->get('step_two_project_data');
			$stepTwoData = json_decode($stepTwoData, TRUE);
			$stepThreeData = session()->get('step_three_project_data');
			$stepThreeData = json_decode($stepThreeData, TRUE);
			//dd([$stepOneData, $stepTwoData, $stepThreeData]);
			
			$title = $stepOneData["title"];
			$startDate = $stepOneData["startDate"];
			$endDate = $stepOneData["endDate"];
			$deliveryPeriod = $stepOneData["deliveryPeriod"];
			$biddingPeriodType = $stepOneData["biddingPeriodType"];
			$address = $stepOneData["address"];
			$city = $stepOneData["city"];
			$country = $stepOneData["country"];
			$currency = $stepOneData["currency"];
			$province = $stepOneData["province"];
			$district = $stepOneData["district"];
			$budget = $stepOneData["budget"];
			$description = $stepOneData['description'];
			//$open_to_discussion = $stepOneData['open_to_discussion'];
			$skills = $stepTwoData["skills"];
			$artisans = $stepThreeData!=null && isset($stepThreeData['artisanList']) && sizeof($stepThreeData['artisanList'])>0 ? $stepThreeData['artisanList'] : null;
			$projectId = isset($stepOneData['projectId']) ? $stepOneData['projectId'] : NULL;
			
			
			$project = new \App\Models\Project();
			
			if($projectId!=null)
			{
				$project = \App\Models\Project::where('id', '=', $projectId)->first();
				if($project==null)
					return \Redirect::back()->with('error', 'Project not found. Update failed');
			}
			else
			{
				$project_ref = strtoupper(str_random(8));
				
				$project->project_ref = 	$project_ref;
			}
			
			$vat = (5*$budget)/100;
			$service_charge = (5*$budget)/100;
			$project->title =	 				$title;
			$project->status =	 				'PENDING';
			$project->budget = 					$budget;
			$project->vat = 					$vat;
			$project->service_charge = 			$service_charge;
			$project->limit_bidders = 			$artisans==null ? 0 : 1;
			$project->expected_start_date = 	$startDate;
			$project->expected_completion_date = $endDate;
			$project->bidding_period = 			$deliveryPeriod;
			$project->bidding_period_type =		$biddingPeriodType;
			$project->project_location = 		$address;
			$project->city = 					$city;
			$project->country_located_id = 		explode('|||', $country)[0];
			$project->province_located_id = 	explode('|||', $province)[0];
			$project->district_located_id =		$district;
			$project->project_currency =		$currency;
			$project->project_url =	 			strtolower(str_slug($title, '-'));
			$project->description = 			utf8_encode(strip_tags($description));
			$project->created_by_user_id =		\Auth::user()->id;
			$project->open_to_discussion = 		1;
			//dd($project);
			if($project->save())
			{
				foreach($skills as $skill)
				{
					$projectSkill = new \App\Models\ProjectSkill();
					$projectSkill->project_id = $project->id;
					$projectSkill->skill_id = $skill;
					$projectSkill->save();
				}
				$trans_ref = strtoupper(str_random(16));
				$params = array();
				$params['merchantId'] = MERCHANT_ID;
				$params['deviceCode'] = DEVICE_CODE;
				$params['serviceTypeId'] = '1981511018900';
				$params['orderId'] = $trans_ref;
				$params['payerName'] = \Auth::user()->last_name." ".\Auth::user()->first_name.(isset(\Auth::user()->other_name) && \Auth::user()->other_name!=null ? \Auth::user()->other_name : "");
				$params['payerEmail'] = (isset(\Auth::user()->email_address) && \Auth::user()->email_address!=null ? \Auth::user()->email_address : "");
				$params['payerPhone'] = (isset(\Auth::user()->mobile_number) && \Auth::user()->mobile_number!=null ? \Auth::user()->mobile_number : "");
				$params['payerId'] = \Auth::user()->mobile_number;
				$params['nationalId'] = \Auth::user()->national_id;

				$totalAmount = 0;
				$amt = 0;
				$params['amount'][0] = (number_format($budget, 2, '.', ''));
				$params['paymentItem'][0] = 'Project Budget';
				$params['amount'][1] = (number_format($vat, 2, '.', ''));
				$params['paymentItem'][1] = 'VAT(5%)';
				$params['amount'][2] = (number_format($service_charge, 2, '.', ''));
				$params['paymentItem'][2] = 'Service Charge (5%)';
				$totalAmount = (number_format(($budget + $vat + $service_charge), 2, '.', ''));
				
				
				
				
				
				
				
				
				

				$params['responseurl'] = 'http://rartisan.com/route/complete';
				//dd($academic_year_term);
				
				$scope = [];
				if($projectId!=null)
					array_push($scope, 'UPGRADE PROJECT');
				else
					array_push($scope, 'NEW PROJECT');
				
				$params['scope'] = join('|', $scope);
				$params['description'] = $project->title;
				$params['merchant_defined_data1'] = 'NEW_PROJECT_FEE';
				$toHash = $params['merchantId'].$params['deviceCode'].$params['serviceTypeId'].
						$params['orderId'].(number_format($totalAmount, 2, '.', '')).$params['responseurl'].PAYMENT_API_KEY;


				$hash = hash('sha512', $toHash);
				$params['hash'] = $hash;
				$params['currency'] = $currency;
				$params['payment_options'] = 'VISA|BANK|EAGLECARD|UBA';
				$pay_opt = [];
				array_push($pay_opt, 'VISA');
				array_push($pay_opt, 'UBA');
				array_push($pay_opt, 'BANK');
				array_push($pay_opt, 'EAGLECARD');
				array_push($pay_opt, 'MTNMMONEY');
				array_push($pay_opt, 'AIRTELMMONEY');
				array_push($pay_opt, 'ZAMTELMMONEY');
				array_push($pay_opt, 'PROBASEWALLET');
				$params['payment_options'] = join('|', $pay_opt);
				
				$bankAccounts = \App\Models\BankAccount::where('status', '=', 'Active')->with('bank')->get();
				$bankAccount_ = [];
				$k=1;
				$params['merchant_defined_data'] = [];
				
				foreach($bankAccounts as $bankAccount)
				{
					$arr_1['name'] = 'bank_code_'.$k++;
					$arr_1['value'] = $bankAccount->bank->code;
					array_push($params['merchant_defined_data'], $arr_1);
				}
				array_push($params['merchant_defined_data'], ['name'=>'bank_count', 'value'=>$bankAccounts->count()]);
				//dd($params);
				
				$params1 = $params;
				$transaction = new \App\Models\Transaction();
				$transaction->transaction_user_id = \Auth::user()->id;
				$transaction->reference_no = $trans_ref;
				$transaction->total_amount = $totalAmount;
				$transaction->project_id = $project->id;
				$transaction->payment_channel = 'WEB';
				$transaction->status = 'PENDING';
				$transaction->payment_type = 'NEW PROJECT';;
				$transaction->currency = $currency;
				$transaction->request_data = json_encode($params1);
				if($transaction->save())
				{
					\DB::commit();
					
					//session()->remove('step_one_project_data');
					//session()->remove('step_two_project_data');
					//session()->remove('step_three_project_data');
					//dd($password);
					return view('probasepay', compact('params'));
				}
				else
				{
					//dd(12);
					\DB::rollback();
					if($userId!=null)
						return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
					else
						return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
				}
			}
			else
			{
				//dd(13);
				\DB::rollback();
				if($userId!=null)
					return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
				else
					return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
			}		
			
		}
		catch(Exception $e)
		{
			//dd(14);
			\DB::rollback();
			if($userId!=null)
				return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
			else
				return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
		}
	}
	
	
	public function getProjectList()
	{
		$listing = null;
		$listing = \App\Models\Project::where('created_by_user_id', '=', \Auth::user()->id)->get();
		
		$header=  'My Projects';
		$title=  'My Projects';
		$detail = 'List of all my projects';
		$type = "My Projects";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All My Projects', 'url'=>null, 'active'=>1]];
		
		
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	public function getAllProjectList()
	{
		$listing = null;
		$listing = \App\Models\Project::all();
		
		$header=  'All Projects';
		$title=  'All Projects';
		$detail = 'List of all projects';
		$type = "All Projects";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Projects', 'url'=>null, 'active'=>1]];
		
		
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	
	
	
	public function getSupportTickets($project_code=null)
	{
		$listing = null;
		$project = null;
		if($project_code!=null)
		{
			$project = \App\Models\Project::where('project_ref', '=', $project_code)->first();
			$header=  'Support Tickets Under Project - '.$project->title;
			$title=  'All Support Tickets Under Project - '.$project->title;
			$detail = 'List of all support tickets Under Project - '.$project->title;
			$type = "All Support Tickets";
			$breadcrumbs = [];
			$makerCheckerList = [];
			$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Support Tickets', 'url'=>null, 'active'=>1]];
			
			
			$listing = \App\Models\SupportThread::where('project_id', '=', $project->id)->get();
			if($listing!=null && $listing->count()>0)
			{
				$messageFirst = \App\Models\SupportThread::where('project_id', '=', $project->id)->orderBy('created_at', 'DESC')->first();
				
				$messages = [];
				$messageUsers = [];
				if($messageFirst!=null)
				{
					$messages = \App\Models\SupportMessage::where('message_thread_id', '=', $messageFirst->id)->orderBy('created_at', 'ASC')->get();
					foreach($messages as $message)
					{
						//dd($message->created_by_user);
						if(!in_array(($message->created_by_user->first_name." ".$message->created_by_user->last_name), $messageUsers))
							array_push($messageUsers, $message->created_by_user->first_name." ".$message->created_by_user->last_name);
						if(!in_array(($message->receipient_user->first_name." ".$message->receipient_user->last_name), $messageUsers))
							array_push($messageUsers, $message->receipient_user->first_name." ".$message->receipient_user->last_name);
					}
				}
			}
			else
			{
				return \Redirect::back()->with('error', 'There are no support tickets linked to this project');
			}
		}
		else
		{
			$listing = \App\Models\SupportThread::all();
			if($listing!=null && $listing->count()>0)
			{				
				$header=  'All Support Tickets';
				$title=  'All Support Tickets';
				$detail = 'List of all support tickets';
				$type = "All Support Tickets";
				$breadcrumbs = [];
				$makerCheckerList = [];
				$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Support Tickets', 'url'=>null, 'active'=>1]];
				
				$messageFirst = \App\Models\SupportThread::orderBy('created_at', 'DESC')->first();
				$messages = [];
				$messageUsers = [];
				if($messageFirst!=null)
				{
					$messages = \App\Models\SupportMessage::where('message_thread_id', '=', $messageFirst->id)->orderBy('created_at', 'ASC')->get();
					foreach($messages as $message)
					{
						//dd($message->created_by_user);
						if(!in_array(($message->created_by_user->first_name." ".$message->created_by_user->last_name), $messageUsers))
							array_push($messageUsers, $message->created_by_user->first_name." ".$message->created_by_user->last_name);
						if(!in_array(($message->receipient_user->first_name." ".$message->receipient_user->last_name), $messageUsers))
							array_push($messageUsers, $message->receipient_user->first_name." ".$message->receipient_user->last_name);
					}
				}
			}
			else
			{
				return \Redirect::back()->with('error', 'There are no support tickets linked to this project');
			}
		}
		//dd($messages);
		return view('admin.listings', compact('messageUsers', 'messages', 'project', 'listing', 'messageFirst', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	
	
	public function postSendSupportTicketReply(\Illuminate\Http\Request $request)
	{
		\DB::beginTransaction();
		$all = $request->all();
		$selectedThreadCode = $all['selectedThreadCode'];
		$supportThread = \App\Models\SupportThread::where('threadCode', '=', $selectedThreadCode)->where('status', '=', 'OPEN')->first();
		//dd($supportThread);
		if($supportThread!=null)
		{
			$supportMessage = new \App\Models\SupportMessage();
			$supportMessage->sender_user_id = \Auth::user()->id;
			$supportMessage->receipient_user_id = $all['receipient_id'];
			$supportMessage->message_body = $all['reply'];
			$supportMessage->project_id = $supportThread->project_id;
			$supportMessage->receipient_read_yes = 0;
			$supportMessage->message_thread_id = $supportThread->id;
			$supportMessage->message_code = strtolower(str_random(8));
			$supportMessage->save();
			//dd($supportMessage);
			\DB::commit();
			
			$notif_code = strtolower(str_random(8));
			$notification_contents = '<span class="label label-success">TKT</span> New support ticket updated';
			$notification_url = '/notifications/'.$notif_code;
			$receiver_user_id = $supportMessage->receipient_user_id;
			$type = "SUPPORT_TICKET_UPDATED";
			addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, NULL);
								
			return \Redirect::back()->with('success', 'Support ticket updated successfully');
		}
		else
		{
			\DB::rollback();
			return \Redirect::back()->with('error', 'Project could not be found');
		}
	}
	
	public function adminCancelProject($projectCode)
	{
		$project = \App\Models\Project::where('project_ref', '=', $projectCode)->whereNotIn('status', ['CANCELED'])->first();
		if($project!=null)
		{
			$project->status = 'CANCELED';
			$project->save();
			
			$wallet = \App\Models\Wallet::where('wallet_user_id', '=', $project->created_by_user_id)->where('currency', '=', $project->project_currency)->first();
			if($wallet==null)
			{
				$wallet = new \App\Models\Wallet();
				$wallet->wallet_user_id = $project->created_by_user_id;
				$wallet->wallet_number = strtoupper(strtolower(str_random(8)));
				$wallet->currency = $project->project_currency;
				$wallet->current_balance = 0.0;
				$wallet->save();
			}
			
			$creditAccountAmount = $project->budget + $project->vat;
			$wt = new \App\Models\WalletTransaction();
			$wt->wallet_id = $wallet->id;
			$wt->amount = $creditAccountAmount;
			$wt->transaction_type = 'CREDIT';
			$wt->transaction_ref = strtoupper(strtolower(str_random(16)));
			$wt->paid_by_user_id = $project->created_by_user_id;
			$wt->status = 'SUCCESS';
			$wt->wallet_user_id = $project->created_by_user_id;
			$wt->save();
			
			$wallet->current_balance = $wallet->current_balance + $creditAccountAmount;
			$wallet->save();
			
			\DB::commit();
			
			
			$bids = \App\ProjectBid::where('project_id', '=', $project->id)->get();
			foreach($bids as $bid)
			{
				$notif_code = strtolower(str_random(8));
				$notification_contents = '<span class="label label-success">TKT</span> Project cancelation by support team';
				$notification_url = '/notifications/'.$notif_code;
				$receiver_user_id = $bid->bid_by_user_id;
				$type = "PROJECT_CANCELATION";
				addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
			}
				
				
			return \Redirect::back()->with('error', 'Your project has been canceled successfully');
		}
		return \Redirect::back()->with('error', 'You can not cancel this project as the project either does not exist or it has been previously canceled');
	}
	
	
	
	public function getSkillList()
	{
		$listing = null;
		$listing = \App\Models\Skill::all();
		
		$header=  'All Skills';
		$title=  'All Skills';
		$detail = 'List of all skills';
		$type = "All Skills";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Skills', 'url'=>null, 'active'=>1]];
		
		
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	
}

?>
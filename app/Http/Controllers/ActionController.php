<?php

namespace App\Http\Controllers;

use \DateTime;
use \Hash;
use \Milon\Barcode\DNS1D;


class ActionController extends Controller
{
    
	public function __construct() {
        parent::__construct();
    }
	
	public function getIndex()
	{
		
		$skills = \App\Models\Skill::all();
		$countries = \App\Models\Country::all();
		$provinces = \App\Models\States::all();
		return view('index', compact('skills', 'countries', 'provinces'));
	}
	
	public function getMyTransactionList()
	{
		$transactions = [];
		if(\Auth::user()->role_type=='Private Client')
		{
			$transactions = \App\Models\Transaction::whereNull('deleted_at')->where('transaction_user_id', '=', \Auth::user()->id)->with('project')->orderBy('created_at', 'DESC')->get();
			return view('transaction-list', compact('transactions'));
		}
		else if(\Auth::user()->role_type=='Artisan')
		{
			$wallet = \App\Models\Wallet::where('wallet_user_id', '=', \Auth::user()->id)->first();
			$transactions = \App\Models\WalletTransaction::whereNull('deleted_at')->where('wallet_id', '=', $wallet->id)->orderBy('created_at', 'DESC')->get();
			//dd($transactions);
			return view('wallet-transaction-list', compact('transactions'));
		}
		//dd($transactions);
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
	
	
	
	public function getStateByCountry($country_id) {
		$states = \App\Models\States::where('country_id', $country_id);
		if($states->count() != 0) {
			$data = [];
			$data[0] = "-Select One-";
			foreach($states->get() as $k) {
				$data[$k->id] = $k->name;
			}
			return response()->json(['status' => 1, 'data' => $data]);
		}

		return response()->json(['status' => 0]);
	}
	
	
	public function getThreadMessageByCode($code) {
		$messageFirst = \App\Models\MessageThread::where('threadCode', '=', $code)->first();
		$messages = [];
		$messageUsers = [];
		if($messageFirst!=null)
		{
			$messages = \App\Models\Message::where('message_thread_id', '=', $messageFirst->id)->orderBy('created_at', 'ASC')->get();
			if($messages->count()==0)
			{
				return response()->json(['status' => 0]);
			}
			else
			{
				$project = \App\Models\Project::where('id', '=', $messageFirst->project_id)->orderBy('created_at', 'ASC')->first();
				$allData = [];
				$msgs = [];
				$conversers = [];
				foreach($messages as $message)
				{
					$userData['sender_img'] = $message->created_by_user->default_image!=null ? $message->created_by_user->default_image->file_name : '/img/clients/default.png';
					$userData['receiver_img'] = $message->receipient_user->default_image!=null ? $message->receipient_user->default_image->file_name : '/img/clients/default.png';
					$userData['sender_name'] = $message->created_by_user->first_name." ".$message->created_by_user->last_name;
					$userData['receiver_name'] = $message->receipient_user->first_name." ".$message->receipient_user->last_name;
					$userData['message'] = $message->message_body;
					$userData['message_code'] = $message->message_code;
					$userData['date_sent'] = date('d M Y', strtotime($message->created_at));
					array_push($msgs, $userData);
					if(!in_array(($message->created_by_user->first_name." ".$message->created_by_user->last_name), $conversers))
						array_push($conversers, $message->created_by_user->first_name." ".$message->created_by_user->last_name);
					if(!in_array(($message->receipient_user->first_name." ".$message->receipient_user->last_name), $conversers))
						array_push($conversers, $message->receipient_user->first_name." ".$message->receipient_user->last_name);
				}
				$allData['messages'] = $msgs;
				$allData['project'] = $project->title;
				$allData['conversers'] = join(', ', $conversers);
				
				//dd($allData);
				return response()->json(['status' => 1, 'data' => $allData]);
			}
		}
		
		if($states->count() != 0) {
			$data = [];
			$data[0] = "-Select One-";
			foreach($states->get() as $k) {
				$data[$k->id] = $k->name;
			}
			return response()->json(['status' => 1, 'data' => $data]);
		}

		return response()->json(['status' => 0]);
	}
	
	
	public function getSupportThreadMessageByCode($code) {
		$messageFirst = \App\Models\SupportThread::where('threadCode', '=', $code)->first();
		$messages = [];
		$messageUsers = [];
		if($messageFirst!=null)
		{
			$messages = \App\Models\SupportMessage::where('message_thread_id', '=', $messageFirst->id)->orderBy('created_at', 'ASC')->get();
			if($messages->count()==0)
			{
				return response()->json(['status' => 0]);
			}
			else
			{
				$project = \App\Models\Project::where('id', '=', $messageFirst->project_id)->orderBy('created_at', 'ASC')->first();
				$allData = [];
				$msgs = [];
				$conversers = [];
				foreach($messages as $message)
				{
					$userData['sender_id'] = $message->created_by_user->id;
					$userData['sender_img'] = $message->created_by_user->default_image!=null ? $message->created_by_user->default_image->file_name : 'default.png';
					$userData['receiver_img'] = $message->receipient_user->default_image!=null ? $message->receipient_user->default_image->file_name : 'default.png';
					$userData['sender_name'] = $message->created_by_user->role_type=='Administrator' ? 'Support Staff' : $message->created_by_user->first_name." ".$message->created_by_user->last_name;
					$userData['receiver_name'] = $message->receipient_user->first_name." ".$message->receipient_user->last_name;
					$userData['message'] = $message->message_body;
					$userData['message_code'] = $message->message_code;
					$userData['date_sent'] = date('d M Y', strtotime($message->created_at));
					array_push($msgs, $userData);
					if(!in_array(($message->created_by_user->first_name." ".$message->created_by_user->last_name), $conversers))
						array_push($conversers, $message->created_by_user->first_name." ".$message->created_by_user->last_name);
					if(!in_array(($message->receipient_user->first_name." ".$message->receipient_user->last_name), $conversers))
						array_push($conversers, $message->receipient_user->first_name." ".$message->receipient_user->last_name);
				}
				$allData['messages'] = $msgs;
				$allData['project'] = $project->title;
				$allData['ticketId'] = 'Ticket: #'.join('-', str_split($messageFirst->threadCode, 4));
				$allData['conversers'] = join(', ', $conversers);
				$allData['thread_code'] = $message->message_code;
				
				//dd($allData);
				return response()->json(['status' => 1, 'data' => $allData]);
			}
		}
		
		if($states->count() != 0) {
			$data = [];
			$data[0] = "-Select One-";
			foreach($states->get() as $k) {
				$data[$k->id] = $k->name;
			}
			return response()->json(['status' => 1, 'data' => $data]);
		}

		return response()->json(['status' => 0]);
	}
	
	public function getLgaByState($state_id) {
        $lga = \App\Models\Lga::where('state_id', $state_id);
        if($lga->count() != 0) {
            $data = [];
			$data[null] = "-Select One-";
            foreach($lga->get() as $k) {
                $data[$k->id] = $k->lga_name;
            }
			
			//dd($data);
            return response()->json(['status' => 1, 'data' => $data]);
        }

		
        return response()->json(['status' => 0]);
    }
	
	
	public function getUserData()
	{
		$user = \App\Models\User::where('id', '=', \Auth::user()->id)->first();
		return response()->json(['status' => 1, 'data'=>$user]);
	}
	
	public function postUpdateCustomerProfile(\Illuminate\Http\Request $request)
	{
		$all = $request->all();
		$skills5 = $all['skills'];
		$all['skills'] = explode(',', $skills5);
		//return response()->json(['all'=> $all]);
		$rules['firstname'] = 'required';
		$rules['lastname'] = 'required';
		$rules['homeaddress'] = 'required';
		$rules['city'] = 'required';
		$rules['country'] = 'required';
		$rules['state_id'] = 'required';
		$rules['lga_id'] = 'required';
		$rules['gender'] = 'required';
		$rules['nationalid'] = 'required';
		$rules['dob'] = 'required';
		$rules['guarantorfirstname'] = 'required';
		$rules['guarantorlastname'] = 'required';
		$rules['guarantorhomeaddress'] = 'required';
		$rules['guarantorcity'] = 'required';
		$rules['guarantor_country'] = 'required';
		$rules['guarantorprefix'] = 'required';
		$rules['guarantormobilenumber'] = 'required';
		$rules['guarantor_state_id'] = 'required';
		$rules['guarantor_lga_id'] = 'required';
		
		$user = \App\User::where('id', '=', \Auth::user()->id)->first();
		if($user->role_type=='Artisan')
		{
			$rules['skills'] = 'required';
		}
		
		
		$messages['firstname.required'] =  'Provide your first name';
		$messages['lastname.required'] =  'Provide your last name';
		$messages['homeaddress.required'] =  'Provide your home address';
		$messages['city.required'] =  'Provide your city';
		$messages['country.required'] =  'Provide your country';
		$messages['state_id.required'] =  'Provide your province';
		$messages['lga_id.required'] =  'Provide your district';
		$messages['gender.required'] =  'Provide your gender';
		$messages['nationalid.required'] =  'Provide your National Id';
		$messages['dob.required'] =  'Provide your date of birth';
		$messages['guarantorfirstname.required'] =  'Provide your guarantors first name';
		$messages['guarantorlastname.required'] =  'Provide your guarantors last name';
		$messages['guarantorhomeaddress.required'] =  'Provide your guarantors home address';
		$messages['guarantorcity.required'] =  'Provide the city your guarantor lives in';
		$messages['guarantor_country.required'] =  'Provide the country your guarantor lives in';
		$messages['guarantorprefix.required'] =  'Specify your guarantors international phone code';
		$messages['guarantormobilenumber.required'] =  'Provide your guarantors mobile number';
		$messages['guarantor_state_id.required'] =  'Specify the province your guarantor lives in';
		$messages['guarantor_lga_id.required'] =  'Specify the district your guarantor lives in';
		if($user->role_type=='Artisan')
		{
			$messages['skills.required'] =  'Specify your skills';
			//$messages['skills.max'] =  'Specify a maximum of 12 skills';
		}
		
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
			return response()->json(['status' => 1, 'message' => $str_error]);
		}
		
		if(sizeof($all['skills'])>12)
		{
			return response()->json(['status' => 1, 'message' => 'You can only select a maximum of 12 skills']);
		}
		
		if($user==null)
		{
			return response()->json(['status' => 1, 'message' => 'You need to be logged in to update your profile.']);
		}
		else
		{
			//$user->image_id = $username;
			$user->first_name = $all['firstname'];
			$user->last_name = $all['lastname'];
			$user->other_name = $all['othername'];
			$user->home_address = $all['homeaddress'];
			$user->city = $all['city'];
			$user->country_id = $all['country'];
			$user->district_id = $all['lga_id'];
			$user->gender = $all['gender'];
			$user->national_id = $all['nationalid'];
			$user->date_of_birth = $all['dob'];
			$user->district_id = $all['lga_id'];
			$user->country_id = explode('|||', $all['country'])[0];
			$user->validated = 1;
			$user->profile = $all['profile'];
			if($user->save())
			{
				$guarantor = new \App\Models\Guarantor();
				if($user->guarantor->count() > 0)
				{
					$guarantor = $user->guarantor[0];
					$guarantor = \App\Models\Guarantor::where('id', '=', $guarantor->id);
					$guarantor->delete();
				}
				$guarantor = new \App\Models\Guarantor();
				$guarantor->first_name = $all['guarantorfirstname'];
				$guarantor->other_name = $all['guarantorothername'];
				$guarantor->last_name = $all['guarantorlastname'];
				$guarantor->address = $all['guarantorhomeaddress'];
				$guarantor->city = $all['guarantorcity'];
				$guarantor->country_id = explode('|||', $all['guarantor_country'])[0];
				$guarantor->state_id = $all['guarantor_state_id'];
				$guarantor->district_id = $all['guarantor_lga_id'];
				$guarantor->mobile_number = $all['guarantorprefix']."".$all['guarantormobilenumber'];
				$guarantor->user_id = $user->id;
				$guarantor->save();
				
				
				if($user->role_type=='Artisan')
				{
					$artisanSkillsExisting = \App\Models\ArtisanSkill::where('user_id', '=', $user->id)->whereNotIn('skill_id', $all['skills'])->get();
					if($artisanSkillsExisting!=null && $artisanSkillsExisting->count()>0)
					{
						foreach($artisanSkillsExisting as $ase)
						{
							$ase->delete();
						}
					}
					for($i=0; $i<sizeof($all['skills']); $i++)
					{
						$ase = new \App\Models\ArtisanSkill();
						$ase->user_id = $user->id;
						$ase->skill_id = $all['skills'][$i];
						$ase->save();
					}
				}
				
				if($user->role_type=='Corporate Client' || $user->role_type=='Private Client')
					return response()->json(['status' => 0, 'message' => 'Thank you for updating your profile. Its time to create your first new project', 'user'=>$user]);
				else if($user->role_type=='Artisan')
					return response()->json(['status' => 0, 'message' => 'Thank you for updating your profile. You can start applying/bidding to work on projects', 'user'=>$user]);
			}
			else
			{
				return response()->json(['status' => 1, 'message' => 'We could not setup an account for you. Please try again']);
			}
		}
	}
	
	public function postCreateCustomerAccount(\Illuminate\Http\Request $request)
	{
		$all = $request->all();
		//return response()->json(['status' => 0, 'all'=> $all]);
		$rules['roleType'] = 'required';
		$rules['prefix'] = 'required';
		$rules['username'] = 'required';
		$rules['password'] = 'required';
		$rules['confirmpassword'] = 'required|same:password';

		
		$messages = [
			'roleType.required' => 'You must specify if you are an artisan or a client',
			'prefix.required' => 'Specify your mobile country code',
			'username.required' => 'Provide your mobile number',
			'password.required' => 'Provide a valid password',
			'confirmpassword.required' => 'Retype your password in the confirmation field',
			'confirmpassword.same' => 'Your password must match the password provided in the confirmation field',
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
			return response()->json(['status' => 1, 'message' => $str_error]);
		}
		
		$username = $all['prefix'].$all['username'];
		$user = \App\User::where('username', '=', $username)->first();
		if($user!=null)
		{
			return response()->json(['status' => 1, 'message' => 'This mobile number has already signed up for this service. If you need to add a '.$all['roleType'].' to your profile, log in and switch to '.$all['roleType'].' mode']);
		}
		else
		{
			$user = new \App\User();
			$user->username = $username;
			$user->password = \Hash::make($all['password']);
			$user->mobile_number = $username;
			$user->role_type = $all['roleType']=='CLIENT' ? 'Private Client' : 'Artisan';
			$user->status = 'Active';
			$user->total_user_rating = 0.00;
			$user->rating_count  = 0;
			$user->user_code = strtoupper(str_random(12));
			/*$user->image_id = $username;
			$user->gender = $username;
			$user->national_id = $username;
			$user->date_of_birth = $username;
			$user->district_id = $username;
			$user->country_id = $username;
			$user->activate_code = $username;
			$user->validated = $username;
			$user->profile = $username;
			$user->person_favorites = $username;
			$user->project_watchlist = $username;*/
			if($user->save())
			{
				$credentials_ = $request->only('prefix', 'username', 'password');
				//$credentials = \Input::all();
				$utilities = \App\Models\Utility::where('id', '=', 1)->first();
				$prfix = $request->get('prefix');
				$usname = $request->get('username');
				$mob = "";
				if(strpos($usname, '0')==0)
				{
					$mob = $prfix."".substr($usname, 1);
				}
				else
				{
					$mob = $prfix."".$usname;
				}
				$credentials['username'] = $mob;
				$credentials['password'] = $request->get('password');
				$token = null;
				$acctCount = 0;
				
				$user = null;
				if (\Auth::attempt($credentials, $request->has('remember'))) {
					$user = \Auth::user();
				}
				//dd(323);
				$msg = "Welcome to HandyMate. Please ensure you complete the process of providing your details. Your login credentials are:\nUsername: ".$username."\nPassword:".$all['password'];
				
				//dd($utilities);
				send_sms($username, $msg, $utilities, $user=NULL);
				return response()->json(['status' => 0, 'message' => 'Welcome to HandyMate. We have setup an account for you. Please proceed with the signup process', 'user'=>$user]);
			}
			else
			{
				return response()->json(['status' => 1, 'message' => 'We could not setup an account for you. Please try again']);
			}
		}
	}
	
	
	public function getUserByUserCode($userCode)
	{
		$user = \App\User::where('user_code', '=', $userCode)->with('default_image')->first();
		if($user!=null)
		{
			return response()->json(['status' => 1, 'data' => $user->toArray()]);
		}
		return response()->json(['status' => 0]);
			//dd($user->toArray());
	}
	
	public function getTaskDetails()
	{
		
		return view('task-details');
	}
	
	public function getNewTaskStepOne()
	{
		$countries = \App\Models\Country::all();
		$provinces = \App\Models\States::all();
		//dd($provinces);
		return view('new-task-step-one', compact('countries', 'provinces'));
	}
	
	public function getNewTaskStepTwo()
	{
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		return view('new-task-step-two', compact('skills'));
	}
	
	public function getNewTaskStepThree()
	{
		$artisans = \App\Models\User::all();
		return view('new-task-step-three', compact('artisans'));
	}
	
	public function getNewTaskStepFour()
	{
		$artisans = \App\Models\User::all();
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		return view('new-task-step-four', compact('skills', 'artisans'));
	}
}

?>
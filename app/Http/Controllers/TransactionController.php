<?php

namespace App\Http\Controllers;

use \DateTime;
use \Hash;
use \Milon\Barcode\DNS1D;


class TransactionController extends Controller
{
    
	public function __construct() {
        parent::__construct();
    }
	
	
	public function postHandleProbasePayResponse($domain=NULL)
	{
		$balance = 0;
		$input = \Input::all();
		//dd($input);

        $arr = [];

		$status = isset($input['status']) ? $input['status'] : NULL;
		$rpin = null;

		\DB::beginTransaction();

  
		
		if($status!=NULL && ($status=="PENDING")) 
		{
			$transRefs = [];
            if(isset($input['transactionRefs']))
            {
                $transRefs = $input['transactionRefs'];
                $transRefs = (json_decode($transRefs));
                
                foreach($transRefs as $key => $val)
                {
                    array_push($arr,  $key);
                }
            }
            $transRefs = $arr;
			
			if(isset($input['reason']))
				$reason = $input['reason'];
			if(isset($input['merchantId']))
				$merchantId = $input['merchantId'];
			if(isset($input['deviceCode']))
				$deviceCode = $input['deviceCode'];
			if(isset($input['rpin']))
				$rpin = $input['rpin'];
			$transactionRef = "";
			if(isset($input['transactionRef']))
				$transactionRef = $input['transactionRef'];
			if(isset($input['transactionRefs']))
				$transactionRef = join(',', $transRefs);
			if(isset($input['transactionDate']))
				$transactionDate = $input['transactionDate'];
			if(isset($input['orderId']))
				$orderId = $input['orderId'];
			//dd($input);
			if(isset($input['paymentreference']))
				$orderId = $input['paymentreference'];


			$transaction = PaymentHistories::where('ref_no', '=', $orderId);
			if($transaction->count()>0) 
			{
				$transaction = $transaction->first();
			}
			
			//dd($transaction);
			$request_data = $transaction->request_data;
			
			if($request_data!=null)
				$request_data = json_decode($request_data, TRUE);
			
			$project_id = $transaction->project_id;
			$project = \App\Models\Project::where('id', '=', $project_id)->first();
			if($project!=null)
			{
				DB::commit();
				$project->status = 'OPEN';
				$project->save();
				return \Redirect::to('/project-details/'.$project->project_url)->with('message', 'Your payment has been registered on the system as pending. Once we confirm receipt of your payment, your payment status will be updated');
			}
			//dd('/school-fees-receipt/'.$orderId);
			
		}
		else if($status!=NULL && ($status=="00" || $status=="ACCEPT")) {

            //dd(22);
            $transRefs = [];
            if(isset($input['transactionRefs']))
            {
                $transRefs = $input['transactionRefs'];
                $transRefs = (json_decode($transRefs));
                
                foreach($transRefs as $key => $val)
                {
                    array_push($arr,  $key);
                }
            }
            $transRefs = $arr;
			/*if(isset($input['statusmessage']))
				$statusmessage = $input['statusmessage'];*/
			//dd($input['transactionRefs']);
			if(isset($input['reason']))
				$reason = $input['reason'];
			if(isset($input['merchantId']))
				$merchantId = $input['merchantId'];
			if(isset($input['deviceCode']))
				$deviceCode = $input['deviceCode'];
			if(isset($input['rpin']))
				$rpin = $input['rpin'];
			$transactionRef = "";
			if(isset($input['transactionRef']))
				$transactionRef = $input['transactionRef'];
			if(isset($input['transactionRefs']))
				$transactionRef = join(',', $transRefs);
			if(isset($input['transactionDate']))
				$transactionDate = $input['transactionDate'];
			if(isset($input['orderId']))
				$orderId = $input['orderId'];
			else if(isset($input['paymentreference']))
				$orderId = $input['paymentreference'];


			//dd($input);
			//dd($orderId);
			//$orderId = join('-', str_split($merchantId, 4));
			$transaction = \App\Models\Transaction::where('reference_no', '=', $orderId);
			//dd([$input, $transaction->first()]);
			//->where('status', '=', 'Pending')
			if($transaction->count()>0) {

				
				$transaction = $transaction->first();
				
				$transaction->status = "Success";
				$transaction->transaction_ref = $transactionRef;
				$transaction->save();
				if($transaction->payment_type == 'Wallet Fund')
				{
					$request_data = $transaction->request_data;
					if($request_data!=null)
					{
						$request_data = json_decode($request_data, TRUE);
					}
						
					//dd($request_data);
					if(isset($request_data['scope']) && $request_data['scope']=='FUND-WALLET')
					{
						$amount_to_pay = 0;
						$amount = 0;
						foreach($request_data['amount'] as $item_to_pay)
						{
							$amount = $amount + $item_to_pay;
						}
						$amount_to_pay = $amount;
						
						$details = "WALLETCREDIT|".$amount."|".$transaction->ref_no;
						$walletTransaction = new \App\Models\WalletTransaction();
						$walletTransaction->payment_history_id = $transaction->id;
						$walletTransaction->details = $details;
						$walletTransaction->user_id = \Auth::user()->id;
						$walletTransaction->amount = $amount;
						$walletTransaction->status = 'Success';
						$walletTransaction->transaction_type = 'CREDIT';
						$walletTransaction->save();
						
						$user = \App\Models\User::where('id', '=', \Auth::user()->id)->first();
						$user->current_wallet_balance = $user->current_wallet_balance + $amount;
						$user->save();

						DB::commit();
						return \Redirect::to('/admin/parent/parent-fund-wallet')->with('message', 'Your wallet has been credited successfully with the sum of '.getDefaultSiteCurrency().''.number_format($amount, 2, '.', ','));
					}
				
				}
				else if($transaction->payment_type == 'NEW PROJECT') {
                    
                    $request_data = $transaction->request_data;
					if($request_data!=null)
						$request_data = json_decode($request_data, TRUE);
						
				    //dd($request_data['scope']);	
				    
					
					if(isset($request_data['scope']) && $request_data['scope']=='NEW PROJECT')
					{
						
						$project_id = $transaction->project_id;
						$project = \App\Models\Project::where('id', '=', $project_id)->first();
						if($project!=null)
						{
							$project->status = 'OPEN';
							$project->save();
							
							$projectSkill_ = [];
							$projectSkills = \App\Models\ProjectSkill::where('project_id', '=', $project->id)->get();
							foreach($projectSkills as $projectSkill)
							{
								array_push($projectSkill_, $projectSkill->skill_id);
							}
							
							$otherProjectsSkills = \App\Models\ProjectSkill::whereIn('skill_id', $projectSkill_)->whereNotIn('project_id', [$project->id])->groupBy('project_id')->select('project_id')->limit(4)->get()->toArray();
							$otherProjects = \App\Models\Project::whereIn('id', $otherProjectsSkills)->get();
							$artisanSkills = \App\Models\ArtisanSkill::whereIn('skill_id', $projectSkill_)->get();
							$artisanSkills_ = [];
							$artisanSkillUsers = [];
							foreach($artisanSkills as $artisanSkill)
							{
								if(!in_array($artisanSkill->user_id, $artisanSkillUsers))
								{
									array_push($artisanSkillUsers, $artisanSkill->user_id);
									array_push($artisanSkills_, $artisanSkill);
								}
							}
							
							//dd($artisanSkills_);
							\DB::commit();
							
							foreach($artisanSkills_ as $artisanSkill)
							{
								$notif_code = strtolower(str_random(8));
								$notification_contents = '<span class="label label-success">NEW</span> A new project matching your skill was posted';
								$notification_url = '/notifications/'.$notif_code;
								$receiver_user_id = $artisanSkill->user_id;
								$type = "NEW_PROJECT_PLACED";
								
								
								addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
								
								$utilities = \App\Models\Utility::where('status', '=', 1)->first();
								$msg = "A new project matching your skill(s) has been posted on HandyMade";
								//send_sms($artisanSkill->artisan->mobile_number, $msg, $utilities, null);
								send_mail('email.new_project_notify_artisan', $artisanSkill->artisan->email_address, $artisanSkill->artisan->last_name . ' ' . $artisanSkill->artisan->first_name,
									'HandyMade - New Project Posted - '.$project->title,
									[
										'last_name' => $artisanSkill->artisan->last_name, 
										'first_name' => $artisanSkill->artisan->first_name,
										'project' => $project,
										'otherProjects' => $otherProjects
									]
								);
							}
							
							//
				
							$msg = "Your new HandyMade project has been posted successfully";
							//send_sms($project->created_by_user->mobile_number, $msg, $utilities, null);
							send_mail('email.new_project_notify_client', $project->created_by_user->email_address, $project->created_by_user->last_name . ' ' . $project->created_by_user->first_name,
								'HandyMade - Your New Project Has Been Posted - '.$project->title,
								[
									'last_name' => $project->created_by_user->last_name, 
									'first_name' => $project->created_by_user->first_name,
									'project' => $project
								]
							);
							
							return \Redirect::to('/project-details/'.$project->project_url)->with('message', 'Payment of the sum of '.$transaction->currency.''.number_format($transaction->total_amount, 2, '.', ',').' for your project was successful');
						}
					}
					
				}
				\DB::rollback();
				return \Redirect::to('/')->with('message', 'Transaction could not be completed. Kindly reach out to our support team in regards to your payment if you have been debited');
			}
			else
			{
				//no payment found
				//dd(gtv('INVALID_PAYMENT_TRANSACTION'));
				if ($this->user!=null && $this->user->role_code == Roles::$ROLE_SCHOOL_STUDENT) {
					return \Redirect::to('/student/payment/pay-school-fees')->with('error', gtv('INVALID_PAYMENT_TRANSACTION'));
				} else if ($this->user!=null && $this->user->role_code == Roles::$ROLE_SCHOOL_PARENT) {
					return \Redirect::to('/admin/payment/pay-school-fees/')->with('error', gtv('INVALID_PAYMENT_TRANSACTION'));
				}
				return \Redirect::to('/school-fees/pay/guest')->with('error', gtv('INVALID_PAYMENT_TRANSACTION'));
			}
				//->where('amount', '>', $amount);
		}else
		{
			if(\Auth::user()->role_code == Roles::$ROLE_SCHOOL_STUDENT) 
			{
				return \Redirect::to('/student/payment/pay-school-fees')->with('error', gtv('PAYMENT_NOT_SUCCESS'));
			} 
			else if ($this->user!=null && $this->user->role_code == Roles::$ROLE_SCHOOL_PARENT)
			{
				return \Redirect::to('/admin/parent/list-wards')->with('error', gtv('PAYMENT_NOT_SUCCESS'));
			}
		}
	}
	
	
	public function getTransactionList()
	{
		$listing = null;
		
		$listing = \App\Models\Transaction::where('transaction_user_id', '=', \Auth::user()->id)->get();
		
		$header=  'My Transactions';
		$title=  'My Transactions';
		$detail = 'List of all my transactions';
		$type = "My Transactions";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All My Transactions', 'url'=>null, 'active'=>1]];
		
		
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	public function getWalletTransactionList()
	{
		$listing = null;
		
		$listing = \App\Models\WalletTransaction::where('wallet_user_id', '=', \Auth::user()->id)->get();
		
		$header=  'My Wallet Transactions';
		$title=  'My Wallet Transactions';
		$detail = 'List of all my wallet transactions';
		$type = "Wallet Transactions";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'My Wallet Transactions', 'url'=>null, 'active'=>1]];
		
		
		//dd($listing);
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	public function getAllTransactionList()
	{
		$listing = null;
		$listing = \App\Models\Transaction::all();
		
		$header=  'All Transactions';
		$title=  'All Transactions';
		$detail = 'List of all transactions';
		$type = "All Transactions";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Transactions', 'url'=>null, 'active'=>1]];
		
		
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	public function getAllWalletTransactionList()
	{
		$listing = null;
		
		$listing = \App\Models\WalletTransaction::get();
		
		$header=  'All Wallet Transactions';
		$title=  'All Wallet Transactions';
		$detail = 'List of all wallet transactions';
		$type = "Wallet Transactions";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Transactions', 'url'=>null, 'active'=>1]];
		
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	
	public function confirmTransactionPayOut($transactionRef)
	{
		$walletTransaction = \App\Models\WalletTransaction::where('transaction_ref', '=', $transactionRef)->where('transaction_type', '=', 'DEBIT')->where('status', '=', 'PENDING')->first();
		if($walletTransaction==null)
		{
			return \Redirect::back()->with('error', 'No transaction could be found matching the selected transaction');
		}
		
		$walletTransaction->status = 'SUCCESS';
		$walletTransaction->save();
		
		$notif_code = strtolower(str_random(8));
		$notification_contents = '<span class="label label-success">PAY</span> Payment request attended to. Pay-out has been made';
		$notification_url = '/notifications/'.$notif_code;
		$receiver_user_id = $walletTransaction->wallet_user_id;
		$type = "PAYMENT_REQUEST_ATTENDED";
		addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, NULL);
		
		return \Redirect::back()->with('success', 'Transaction has been updated. You may pay the wallet owner the amount');
	}
	
	
	public function getUpdateWalletStatus($status, $wallet_number)
	{
		\DB::beginTransaction();
		try
		{
			
			if(strtolower($status)=='disable')
			{
				$wallet = \App\Models\Wallet::where('wallet_number', '=', $wallet_number)->where('status', '=', 'ACTIVE')->first();
				if($wallet==null)
				{
					return \Redirect::back()->with('error', 'Wallet could not be found. Please try again');
				}
				$wallet->status = 'DISABLED';
				$wallet->save();
				
				\DB::commit();
				return \Redirect::back()->with('success', 'Wallet disabled successfully');
			}
			else if(strtolower($status)=='enable')
			{
				$wallet = \App\Models\Wallet::where('wallet_number', '=', $wallet_number)->where('status', '=', 'DISABLED')->first();
				if($wallet==null)
				{
					return \Redirect::back()->with('error', 'Wallet could not be found. Please try again');
				}
				$wallet->status = 'ACTIVE';
				$wallet->save();
				
				\DB::commit();
				return \Redirect::back()->with('success', 'Wallet enabled successfully');
			}
			return \Redirect::back()->with('error', 'Invalid wallet status specified');
		}
		catch(Exception $e)
		{
			\DB::rollback();
			return \Redirect::back()->with('error', 'Your request could not be submitted successfully. Please try again');
		}
	}
	
	
	public function postRequestWalletDebit(\Illuminate\Http\Request $request)
	{
		\DB::beginTransaction();
		try
		{
			$all = $request->all();
			$rules = ['wallet' => 'required', 
				'bank' => 'required', 
				'accountname' => 'required', 
				'accountnumber' => 'required', 
				'amount' => 'required', 
			];
				
			$messages = [
				'wallet.required' => 'Specify the wallet you are withdrawing from',
				'bank.required' => 'Specify the bank account you want to receive payment',
				'accountname.required' => "Specify the destination accounts' account name",
				'accountnumber.required' => "Specify the destination accounts' account number",
				'amount.required' => 'Specify the amount you want to withdraw',
				
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
			
			$wallet = \App\Models\Wallet::where('wallet_user_id', '=', \Auth::user()->id)->where('wallet_number', '=', $all['wallet'])
				->where('current_balance', '>', $all['amount'])->first();
			if($wallet==null)
			{
				return \Redirect::back()->withInput($all)->with('error', 'Insufficient funds in your account. You can only withdraw less than the current amount in your wallet');
			}
			$wallet->current_balance = $wallet->current_balance - $all['amount'];
			$wallet->save();
						
			$wt = new \App\Models\WalletTransaction();
			$wt->wallet_id = $wallet->id;
			$wt->amount = $all['amount'];
			$wt->transaction_type = 'DEBIT';
			$wt->paid_by_user_id = \Auth::user()->id;
			$wt->wallet_user_id = \Auth::user()->id;
			$wt->transaction_ref = strtoupper(strtolower(str_random(16)));
			$wt->status = 'PENDING';
			$wt->bank_id = $all['bank'];
			$wt->account_name = $all['accountname'];
			$wt->account_number = $all['accountnumber'];
			$wt->save();
			//dd($wt);
			\DB::commit();
			return \Redirect::back()->with('success', 'Your request has been submitted successfully');
		}
		catch(Exception $e)
		{
			\DB::rollback();
			return \Redirect::back()->with('error', 'Your request could not be submitted successfully. Please try again');
		}
		
	}
	
	public function getWalletList()
	{
		$listing = null;
		$listing = \App\Models\Wallet::all();
		
		$header=  'All Wallets';
		$title=  'All Wallets';
		$detail = 'List of all wallets';
		$type = "All Wallets";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Wallets', 'url'=>null, 'active'=>1]];
		
		
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
}

?>
<?php

namespace App\Http\Controllers;

use \DateTime;
use \Hash;
use \Milon\Barcode\DNS1D;


class UserController extends Controller
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
	
	
	public function getRegisterArtisan()
	{
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		return view('register_artisan-step-one', compact('skills'));
	}
	
	
	public function getRegisterArtisanStepTwo()
	{
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		return view('register_artisan-step-two', compact('skills'));
	}
	
	
	public function getRegisterArtisanStepThree()
	{
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		return view('register_artisan-step-three', compact('skills'));
	}
	
	public function getTaskDetails()
	{
		return view('task-details');
	}
	
	public function getNewTaskStepOne()
	{
		return view('new-task-step-one');
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
	
	public function getAllUsers()
	{
		$listing = null;
		$listing = \App\User::all();
		
		$header=  'All Users';
		$title=  'All Users';
		$detail = 'List of all users';
		$type = "All Users";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Users', 'url'=>null, 'active'=>1]];
		
		
		return view('admin.listings', compact('listing', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	public function getAllMessages()
	{
		$listing = null;
		$listing = \App\Models\MessageThread::all();
		
		$header=  'All Messages';
		$title=  'All Messages';
		$detail = 'List of all messages';
		$type = "All Messages";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Messages', 'url'=>null, 'active'=>1]];
		
		$messageFirst = \App\Models\MessageThread::orderBy('created_at', 'DESC')->first();
		$messages = [];
		$messageUsers = [];
		if($messageFirst!=null)
		{
			$messages = \App\Models\Message::where('message_thread_id', '=', $messageFirst->id)->orderBy('created_at', 'ASC')->get();
			foreach($messages as $message)
			{
				array_push($messageUsers, $message->created_by_user->first_name." ".$message->created_by_user->last_name);
				array_push($messageUsers, $message->receipient_user->first_name." ".$message->receipient_user->last_name);
			}
		}
		
		//dd($messages);
		return view('admin.listings', compact('messageUsers', 'messages', 'listing', 'messageFirst', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
	
	
	public function getValidateUser($userCode)
	{
		$user = \App\User::where('user_code', '=', $userCode)->whereNotIn('validated', [1])->whereNot('role_type', ['Artisan', 'Private Client'])->first();
		
		if($user)
		{
			if($user->activate_code==null)
			{
				$user->validated = 1;
				$user->save();
				return \Redirect::back()->with('success', 'User validated successfully');
			}
			{
				return \Redirect::back()->with('error', 'You can validate this user. The user has to activate their account before you can validate their account');
			}
		}
		else
		{
			return \Redirect::back()->with('error', 'No user could be found matching your selection');
		}
	}
	
	public function getMyMessages()
	{
		//dd(\Auth::user()->id);
		$listing = null;
		$threadIds = \App\Models\Message::where('sender_user_id', '=', \Auth::user()->id)->orWhere('receipient_user_id', '=', \Auth::user()->id)->get();
		$threadIds_ = [];
		foreach($threadIds as $threadId)
		{
			array_push($threadIds_, $threadId->message_thread_id);
		}
		//dd($threadIds_);
		
		$listing = \App\Models\MessageThread::whereIn('id', $threadIds_)->get();
		//dd($listing);
		$header=  'My Messages';
		$title=  'My Messages';
		$detail = 'List of all my messages';
		$type = "All Messages";
		$breadcrumbs = [];
		$makerCheckerList = [];
		$breadcrumbs = [['name'=>'Dashboard', 'url'=>'/admin/dashboard', 'active'=>0], ['name'=>'All Messages', 'url'=>null, 'active'=>1]];
		
		$messageFirst = \App\Models\MessageThread::orderBy('created_at', 'DESC')->first();
		$messages = [];
		$messageUsers = [];
		if($messageFirst!=null)
		{
			$messages = \App\Models\Message::where('message_thread_id', '=', $messageFirst->id)->orderBy('created_at', 'ASC')->get();
			foreach($messages as $message)
			{
				array_push($messageUsers, $message->created_by_user->first_name." ".$message->created_by_user->last_name);
				array_push($messageUsers, $message->receipient_user->first_name." ".$message->receipient_user->last_name);
			}
		}
		
		//dd($messages);
		return view('admin.listings', compact('messageUsers', 'messages', 'listing', 'messageFirst', 'header', 'title', 'detail', 'type', 'breadcrumbs'));
	}
}

?>
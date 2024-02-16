<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Session;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected $wallets = [];
	protected $messages = [];
	protected $banks;
	protected $notifications = [];
	protected $clientProjects = [];
	protected $skills = [];
	protected $countries = [];
	
	public function __construct()
    {
		
		$this->middleware(function ($request, $next) {
			$this->banks = \App\Models\Banks::all();
			if(\Auth::user())
			{
				$this->messages = \App\Models\Message::where('receipient_read_yes', '=', 0)->where('receipient_user_id', '=', \Auth::user()->id)->orderBy('created_at')->limit(5)->get();
				
				$this->notifications = \App\Models\Notification::where('receiver_user_id', '=', \Auth::user()->id)->orderBy('created_at')->limit(5)->get();
			}
            if(\Auth::user() && \Auth::user()->role_type=='Artisan')
			{
				//$bids = \App\Models\ProjectBid::where('bid_by_user_id', '=', \Auth::user()->id)->get();
				$this->wallets = \App\Models\Wallet::where('wallet_user_id', '=', \Auth::user()->id)->get();
				if($this->wallets->count()==0)
				{
					$this->wallets = [];
				}
			}
			if(\Auth::user() && \Auth::user()->role_type=='Private Client')
			{
				//$bids = \App\Models\ProjectBid::where('bid_by_user_id', '=', \Auth::user()->id)->get();
				$this->clientProjects = \App\Models\Project::where('created_by_user_id', '=', \Auth::user()->id)->groupBy('project_currency')->selectRaw('sum(budget) as sum, project_currency')
					->pluck('sum','project_currency');
				//dd($this->clientProjects->count());
				if($this->clientProjects->count()==0)
				{
					$this->clientProjects = [];
				}
			}
			$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
			$countries = \App\Models\Country::all();
			
			$this->skills = $skills;
			$this->countries = $countries;
			
			
			view()->share([
				'skills' => $this->skills,
				'countries' => $this->countries,
				'wallets' => $this->wallets, 
				'banks' => $this->banks, 
				'notifications' => $this->notifications, 
				'messages_supreme' => $this->messages,
				'clientProjectsSupreme' => $this->clientProjects
			]); 
			return $next($request);
        });
		
		

    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use JWTAuth;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    private $jwtauth;
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\User $user, \App\Models\UserFile $userFile, JWTAuth $jwtauth)
    {
        //parent::__construct();
        //dd($jwtauth);
        //$this->middleware('guest')->except('logout');
        $this->user = $user;
        $this->middleware('jwt.auth', ['except' => ['postLogin', 'logout', 'postLoginApi', 'getLogout']]);
        $this->jwtAuth = $jwtauth;
    }




	public function getLogout()
    {
        \Auth::logout();
		sleep(4);
		\Auth::logout();
        return redirect('/');
    }
    
	public function getLogin($redirectUrl=NULL)
	{
		$red = '/?login=true';
		if($redirectUrl!=null)
		{
			$red = $red.'&redirectUrl='.$redirectUrl;
		}
		return \Redirect::to($red);
	}
	
	public function getLoginView() {

		if(\Auth::user())
			return \Redirect::to('/dashboard');
		else
			return \Redirect::to('/?loginnow=1');
	}
	
	public function getForgotPasswordView() {
	    if(\Auth::user())
			return \Redirect::to('/dashboard');
		else
			return \Redirect::to('/?forgotpassword=1');
	}
	
	public function getDashboard()
	{
		$projects = \App\Models\Project::where('created_by_user_id', '=', \Auth::user()->id)->get();
		$walletTransactions = \App\Models\WalletTransaction::where('paid_by_user_id', '=', \Auth::user()->id)
			->where('transaction_type', '=', 'CREDIT')
			->join('wallets', 'wallet_transactions.wallet_id', '=', 'wallets.id')
			->groupBy('wallets.currency')->selectRaw('sum(amount) as sum, currency')
			->pluck('sum','currency');
		$projectBids = \App\Models\ProjectBid::whereIn('project_bids.status', ['OPEN', 'WON'])
			->join('projects', 'project_bids.project_id', '=', 'projects.id')
			->where('projects.created_by_user_id', '=', \Auth::user()->id)->get();
		$wallet = \App\Models\Wallet::where('wallet_user_id', '=', \Auth::user()->id)->first();
		//dd($wallet);
		return view('admin.dashboard-client', compact('projects', 'walletTransactions', 'projectBids', 'wallet'));
	}
	
    public function postResetPassword(\Illuminate\Http\Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'username' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }
		
		$prfix = $request->get('prefixrecover');
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
		
        $user = \App\User::where('username', '=', $mob)->first();
        //dd($request->all());
        //dd($user);
        if($user==null)
            return back()->with('error', 'Your password could not be reset. Please try again');
        
        $pwd = strtoupper(str_random(8));
        $user->password = \Hash::make($pwd);
		$mobileno = $user->mobile_number;
		$mobileno = '260967307151';
        if ($user->save()) {
            $msg = "Hello\nYour HandyMade password has been updated successfully. Your new password is ".$pwd;
    		try{
    			$getdata = http_build_query(
    				array(
    					'username' => 'rtsa',
    					'password' => 'password@1',
    					'mobiles'=>$mobileno,
    					'message'=>$msg,
    					'sender'=>'RTSA',
    					'type' => 'TEXT'					
    				)
    			);
    			
    			//$url = "http://smsapi.probasesms.com/apis/text/index.php?".$getdata;
				$url = "https://probasesms.com/text/multi/res/trns/sms?".$getdata;
    			//dd($url);
    			$responseSms = file_get_contents($url);
				//dd($responseSms);
    			
    			$smsLog = new \App\SmsLog();
    			$smsLog->receipient_number = $user->mobile_number;
    			$smsLog->msg_contents = $msg;
    			$smsLog->save();
    			
    			log_audit_trail('RESET_PASSWORD', $user->username, $user, json_encode($request->all()), null, $user->id);
    			
    		}catch(\Exception $e)
    		{
    		
    		}
            return redirect('/auth/login')->with('success', 'Your password has been reset successfully.');
        } else {
            return back()->with('error', 'Your password could not be reset. Please try again');
        }
        
        
    }
	
	public function postLogin(\Illuminate\Http\Request $request) {
		$credentials_ = $request->only('prefix', 'username', 'password');
		//$credentials = \Input::all();

        //dd($credentials_);
		
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
		$rules = ['username' => 'required', 
		'password' => 'required'];
		
		$messages = [
				'username.required' => 'Your username is required to login',
				'password.required' => 'Your Password is required to login'
			];
		$validator = \Validator::make($credentials, $rules, $messages);
		if($validator->fails())
		{
			$errMsg = json_decode($validator->messages(), true);
			$str_error = "";
			$i = 1;
			foreach($errMsg as $key => $value)
			{
				foreach($value as $val) {
					$str_error = ($val);
				}
			}
			return \Redirect::back()->with('error', 'Invalid login credentials provided');
		}

		//$active['status'] = 'Active';
		//$credentials = $request->only('username', 'password');
		
		//dd($credentials);
		
		if (\Auth::attempt($credentials, $request->has('remember'))) {
			$user = \Auth::user();
			if($user)
			{
				if($user->activate_code!=null)
				{
					//dd(11);
					\Auth::logout();
					\Auth::logout();
					return \Redirect::to('/?activateaccount=1&mobile-activate='.$credentials['username']);
				}
				else
				{
					
					return \Redirect::to('/');
				}
			}
		}
		//dd(323);
		return \Redirect::back()->with('error', 'Invalid login credentials provided');
	}



	public function postLoginApi(\Illuminate\Http\Request $request)
    {
        $credentials_ = $request->only('prefix', 'username', 'password');
        //$credentials = \Input::all();

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
        $rules = ['username' => 'required',
            'password' => 'required'];

        $messages = [
            'username.required' => 'Your username is required to login',
            'password.required' => 'Your Password is required to login'
        ];
        $validator = \Validator::make($credentials, $rules, $messages);
        if($validator->fails())
        {
            $errMsg = json_decode($validator->messages(), true);
            $str_error = "";
            $i = 1;
            foreach($errMsg as $key => $value)
            {
                foreach($value as $val) {
                    $str_error = ($val);
                }
            }
            return response()->json(['error' => $errMsg,
                'status' => -1
            ], 401);
        }

        //$active['status'] = 'Active';
        //$credentials = $request->only('username', 'password');

        //dd($credentials);
        /*return response()->json(['error' => $credentials,
            'status' => -1
        ], 401);*/

        $token = null;
        try {
            if(!$token = JWTAuth::attempt($credentials))
            {
                return response()->json(['error' => 'Invalid login credentials provided. Provide your valid mobile number and password',
                    'status' => -1
                ], 500);
            }
        }
        catch(JWTAuthException $e)
        {
            return response()->json(['error' => 'Invalid login credentials provided. Provide your valid mobile number and password',
                'status' => -1
            ], 500);
        }

        //dd($token);
        $user = JWTAuth::toUser($token);
        dd($user);
        if($user)
        {
            if($user->activate_code!=null)
            {
                //dd(11);
                return response()->json([
                    'status' => 0,
                    'token' => $token,
                    'user' => \Auth::user(),
                    'expires' => 1*60
                ]);
            }
            else
            {

                return response()->json([
                    'status' => 1,
                    'token' => $token,
                    'user' => \Auth::user(),
                    'expires' => 1*60
                ]);
            }
        }



        //dd(323);
        return response()->json(['error' => 'Invalid login credentials provided',
            'status' => -1
        ], 401);
    }
	
	protected function postActivateAccount(\Illuminate\Http\Request $request)
	{
		$all = $request->all();
		$credentials['username'] = $request->get('mobile_activate');
		$credentials['password'] = $request->get('password');
		$credentials['new_password'] = $request->get('new_password');
		$credentials['confirm_password'] = $request->get('confirm_password');
		$credentials['activate_code'] = join('', $request->get('otp'));
		
		$token = null;
		$acctCount = 0;
		$rules = ['username' => 'required', 
			'password' => 'required', 
			'activate_code' => 'required',
			'new_password' => 'required', 
			'confirm_password' => 'same:new_password', 
			
		];
		
		$messages = [
			'username.required' => 'Invalid action. Please try to login afresh',
			'password.required' => 'Your Password is required',
			'activate_code.required' => 'Provide the activation code sent to your mobile phone',
			'new_password.required' => 'Provide your a password you can remember to update the current password',
			'confirm_password.same' => 'Your new password and the repeated passwords must match'
		];
		$validator = \Validator::make($credentials, $rules, $messages);
		if($validator->fails())
		{
			$errMsg = json_decode($validator->messages(), true);
			$str_error = "";
			$i = 1;
			foreach($errMsg as $key => $value)
			{
				foreach($value as $val) {
					$str_error = ($val);
				}
			}
			
			//dd(333);
			return \Redirect::back()->with('error', 'Invalid login credentials provided');
		}

		//$active['status'] = 'Active';
		//$credentials = $request->only('username', 'password');
		
		//dd($credentials);
		$credentials_['username'] = $request->get('mobile_activate');
		$credentials_['password'] = $request->get('password');
		$credentials_['activate_code'] = join('', $request->get('otp'));
		//dd($credentials_);
		if (\Auth::attempt($credentials_, $request->has('remember'))) {
			$user = \Auth::user();
			//dd($user);
			if($user)
			{
				//dd($user);
				if($user->activate_code==null)
				{
					\Auth::logout();
					\Auth::logout();
					return \Redirect::to('/?login=1')->with('error', 'Invalid activity. Account already activated. Please login with your valid credentials');
				}
				else
				{
					$user->activate_code=null;
					$user->password = \Hash::make($credentials_['password']);
					$user->save();
					return \Redirect::to('/')->with('success', 'Your profile has been activated successfully');
				}
			}
		}
		
		//dd(11);
		return \Redirect::back()->with('error', 'Invalid login credentials provided');
	}
}

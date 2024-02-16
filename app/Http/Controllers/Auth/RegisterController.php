<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
	protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
	}
	
	public function getRegisterArtisanStepOne()
	{
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		$countries = \App\Models\Country::all();
		return view('register_artisan-step-one', compact('skills', 'countries'));
	}
	
	
	public function getRegisterArtisanStepTwo()
	{
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		return view('register_artisan-step-two', compact('skills'));
	}
	
	
	public function getRegisterArtisanStepThree()
	{
		$skills = \App\Models\Skill::orderBy('skill_name', 'ASC')->get();
		$countries = \App\Models\Country::all();
		return view('register_artisan-step-three', compact('skills', 'countries'));
	}
	
	
	public function getRegisterArtisanStepFour()
	{
		$stepOneData = session()->get('step_one_register_data');
		$stepOneData = json_decode($stepOneData);
		$stepTwoData = session()->get('step_two_register_data');
		$stepTwoData = json_decode($stepTwoData);
		$stepThreeData = session()->get('step_three_register_data');
		$stepThreeData = json_decode($stepThreeData);
		//dd([$stepOneData, $stepTwoData, $stepThreeData]);
		
		$skills = \App\Models\Skill::whereIn('id', $stepTwoData->skills)->get();
		$province = \App\Models\States::where('id', '=', $stepOneData->province)->first();
		$district = \App\Models\Lga::where('id', '=', $stepOneData->district)->first();
		$guarantor_province = \App\Models\States::where('id', '=', $stepThreeData->guarantor_state_id)->first();
		$guarantor_district = \App\Models\Lga::where('id', '=', $stepThreeData->guarantor_district)->first();
		$passport_name = session()->get('passport_name');
		return view('register_artisan-step-four', compact('passport_name', 'skills', 'province', 'district', 'guarantor_province', 'guarantor_district', 'stepOneData', 'stepTwoData', 'stepThreeData'));
	}
	
	
    protected function postRegisterArtisanStepOne(\Illuminate\Http\Request $request)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
		
		$all = $request->all();
		//dd($all);
		$rules = ['firstname' => 'required', 'lastname' => 'required', 'homeaddress' => 'required', 
			'city' => 'required', 'country' => 'required', /*'province' => 'required', 'district' => 'required', */
			'mobileNumber' => 'required', 'gender' => 'required', 'nationalid' => 'required', 
			'dateofbirth' => 'required', 'passport' => 'mimes:jpeg,jpg,png,gif|max:3600', 'prefix' => 'required'];
			
		$messages = [
				'firstname.required' => 'You must provide your first name', 'lastname.required' => 'You must provide your last name', 'homeaddress.required' => 'Provide your home address which will be verified', 
				'city.required' => 'You must provide the city you live in', 'country.required' => 'You must provide the country you live in', /*'province.required' => 'You must provide the province you live in', 
				'district.numeric' => 'Provide the district you live in', */'mobileNumber.required' => 'Provide your mobile number',
				'gender.required' => 'Specify your gender/sex',
				'nationalid.numeric' => 'Provide your valid national Id', 'dateofbirth.required' => 'Specify your date of birth',
				'passport.mimes' => 'Provide your valid passport photo', 'passport.max' => 'Passport photo must be less than 3MB', 'prefix.required' => 'Specify your international calling code',
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
		if ($request->hasFile('passport')) {
			$file = $request->file('passport');
			$file_name = str_random(25) . '.' . $file->getClientOriginalExtension();
			$dest = 'img/clients/';
			$file->move($dest, $file_name);
			session()->remove('passport_name');
			session()->put('passport_name', $file_name);
		}
		unset($all['passport']);
		session()->put('step_one_register_data', json_encode($all));
		return \Redirect::to('/register-artisan-step-two');
	}
	
	
	protected function postRegisterArtisanStepTwo(\Illuminate\Http\Request $request)
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
			dd($str_error);
			return \Redirect::back()->withInput($all)->with('error', $str_error);
		}
		session()->put('step_two_register_data', json_encode($all));
		return \Redirect::to('/register-artisan-step-three');
	}
	
	
	protected function postRegisterArtisanStepThree(\Illuminate\Http\Request $request)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
		
		$all = $request->all();
		//dd($all);
		$rules = ['guarantor_firstname' => 'required', 'guarantor_lastname' => 'required', 'guarantor_address' => 'required', 
			'guarantor_city' => 'required', 'guarantor_country' => 'required', 'guarantor_state_id' => 'required', 'guarantor_district' => 'required', 
			'guarantor_mobileNumber' => 'required', 'guarantor_gender'=> 'required', 'profile' => 'required', 'guarantor_prefix' => 'required'];
			
		$messages = [
				'guarantor_firstname.required' => 'You must provide your guarantors first name', 'guarantor_lastname.required' => 'You must provide your guarantors last name', 'guarantor_address.required' => 'Provide your guarantors home address which will be verified', 
				'guarantor_city.required' => 'You must provide the city your guarantor lives in', 'guarantor_country.required' => 'You must provide the country your guarantor lives in', 'guarantor_state_id.required' => 'You must provide the province your guarantor lives in', 
				'guarantor_district.numeric' => 'Provide the district your guarantor lives in', 'guarantor_mobileNumber.required' => 'Provide your guarantors mobile number',
				'guarantor_gender.required' => 'Specify your guarantors gender/sex',
				'profile.required' => 'Provide your profile', 'guarantor_prefix.required' => 'Specify your guarantors phone international code'
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
		session()->put('step_three_register_data', json_encode($all));
		return \Redirect::to('/register-artisan-step-four');
	}
	
	
	protected function postRegisterArtisanStepFour(\Illuminate\Http\Request $request)
	{
		\DB::beginTransaction();
		try
		{
			$password = null;
			$stepOneData = session()->get('step_one_register_data');
			$stepOneData = json_decode($stepOneData, TRUE);
			$stepTwoData = session()->get('step_two_register_data');
			$stepTwoData = json_decode($stepTwoData, TRUE);
			$stepThreeData = session()->get('step_three_register_data');
			$stepThreeData = json_decode($stepThreeData, TRUE);
			//dd([$stepOneData, $stepTwoData, $stepThreeData]);
			
			$firstname = $stepOneData["firstname"];
			$othername = $stepOneData["othername"];
			$lastname = $stepOneData["lastname"];
			$homeaddress = $stepOneData["homeaddress"];
			$city = $stepOneData["city"];
			$country = $stepOneData["country"];
			$province = $stepOneData["province"];
			$district = $stepOneData["district"];
			$prefix = $stepOneData["prefix"];
			$mobileNumber = $stepOneData["mobileNumber"];
			$emailAddress = $stepOneData["emailAddress"];
			$gender = $stepOneData["gender"];
			$nationalid = $stepOneData["nationalid"];
			$dateofbirth = $stepOneData["dateofbirth"];
			$skills = $stepTwoData["skills"];
			$profile = $stepThreeData["profile"];
			$guarantor_firstname = $stepThreeData["guarantor_firstname"];
			$guarantor_othername = $stepThreeData["guarantor_othername"];
			$guarantor_lastname = $stepThreeData["guarantor_lastname"];
			$guarantor_address = $stepThreeData["guarantor_address"];
			$guarantor_city = $stepThreeData["guarantor_city"];
			$guarantor_country = $stepThreeData["guarantor_country"];
			$guarantor_state_id = $stepThreeData["guarantor_state_id"];
			$guarantor_district = $stepThreeData["guarantor_district"];
			$guarantor_prefix = $stepThreeData["guarantor_prefix"];
			$guarantor_mobileNumber = $stepThreeData["guarantor_mobileNumber"];
			$guarantor_gender = $stepThreeData["guarantor_gender"];
			$userId = isset($stepOneData['userId']) ? $stepOneData['userId'] : NULL;
			
			$dateOfBirthTimeStamp = strtotime($dateofbirth);
			$nowTimeStamp = strtotime(date('Y/m/d'));
			
			
			//dd($dateofbirth);
			$age = \Carbon\Carbon::parse($dateofbirth)->age;
			$diff = $nowTimeStamp - $dateOfBirthTimeStamp;
			if($age<18)
			{
				return \Redirect::back()->with('error', 'We can only provide work to people above 18 years');
			}
			
			$user = new \App\User();
			
			if($userId!=null)
			{
				$user = \App\User::where('id', '=', $userId)->first();
				if($user==null)
				{
					return \Redirect::back()->with('error', 'User Account not found. Update failed');
				}
				
				
				$user->username = 		$user->username;
				$user->password = 		$user->password;
				$user->status = 		$user->status;
				
			}
			else
			{
				$userTypeCheck = \App\User::where('username', '=', $prefix."".$mobileNumber)->first();
				
				if($userTypeCheck!=null)
				{
					return \Redirect::back()->with('error', 'Seems you already have an account registered on our platform using your phone number. Try to login now');
				}
					
				$password = strtoupper(str_random(8));
				
				$passport_name = session()->get('passport_name');
				$userFile = new \App\Models\UserFile();
				$userFile->file_name = $passport_name;
				$userFile->image_type = 'PROFILE';
				$userFile->save();
				
				$user->username = 		$prefix."".$mobileNumber;
				$user->password = 		\Hash::make($password);
				$user->status = 		'Active';
				$user->image_id = 		$userFile->id;
			}
			$role_type = 'Artisan';
			$accessCode = rand(1000, 9999);
			
			$user->first_name =	 	$firstname;
			$user->last_name = 		$lastname;
			$user->other_name = 	$othername;
			$user->mobile_number = 	$prefix."".$mobileNumber;
			$user->email_address = 	$emailAddress;
			$user->role_type = 		$role_type;
			$user->country_id = 	explode('|||', $country)[0];
			//$user->district_id = 	$district;
			$user->status =	 		'Inactive';
			$user->gender = 		$gender;
			$user->total_user_rating = 	0;
			$user->rating_count = 	0;
			$user->national_id = 	$nationalid;
			$user->date_of_birth =	$dateofbirth;
			$user->activate_code =	$accessCode;
			$user->validated =	 	0;
			$user->profile = 		$profile;
			$user->user_code = 		rand(100000000, 999999999);
			if($user->save())
			{
				$userFile->user_id = $user->id;
				$userFile->save();
				
				$guarantor = new \App\Models\Guarantor();
				$guarantor->first_name = $guarantor_firstname;
				$guarantor->other_name = $guarantor_othername;
				$guarantor->last_name = $guarantor_lastname;
				$guarantor->address = $guarantor_address;
				$guarantor->city = $guarantor_city;
				$guarantor->country_id = explode('|||', $guarantor_country)[0];
				$guarantor->state_id = $guarantor_state_id;
				$guarantor->district_id = $guarantor_district;
				$guarantor->mobile_number = $guarantor_mobileNumber;
				$guarantor->gender = $guarantor_gender;
				$guarantor->user_id = $user->id;
				if($guarantor->save())
				{
					//dd($skills);
					
					foreach($skills as $skill)
					{
						$artisanSkill = new \App\Models\ArtisanSkill();
						$artisanSkill->user_id = $user->id;
						$artisanSkill->skill_id = $skill;
						$artisanSkill->save();
					}
					
					
					
					\DB::commit();
					session()->remove('passport_name');
					session()->remove('step_one_register_data');
					session()->remove('step_two_register_data');
					session()->remove('step_three_register_data');
					
					$projects = \App\Models\Project::whereIn('status', ['OPEN', 'COMPLETED'])->limit(10)->get();
					//dd($projects);
					$utilities = \App\Models\Utility::where('status', '=', 1)->first();
					$msg = "Your new HandyMade ".$role_type." credentials -\nUsername: " . $prefix."".$mobileNumber . "\nActivation Code:" . $accessCode . "\nPassword: " . $password;
        			send_sms($prefix."".$mobileNumber, $msg, $utilities, null);
    				send_mail('email.signup_artisan', $emailAddress, $lastname . ' ' . $firstname,
						'Welcome To HandyMade - New '.$role_type.' Account Profile',
						[
							'last_name' => $lastname, 
							'first_name' => $firstname,
							'username' => $prefix."".$mobileNumber,
							'accessCode' => $accessCode,
							'user' => $user,
							'password' => $password, 
							'projects' => $projects
						]
    				);
					if($userId!=null)
						return \Redirect::to('/?auth=login')->with('success', 'Your user profile was updated successfully');
					else
						return \Redirect::to('/?auth=login')->with('success', 'A new profile has been created successfully for you');
				}
				else
				{
					\DB::rollback();
					if($userId!=null)
						return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
					else
						return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
				}
			}
			else
			{
				\DB::rollback();
				if($userId!=null)
					return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
				else
					return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
			}		
			
		}
		catch(Exception $e)
		{
			\DB::rollback();
			if($userId!=null)
				return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
			else
				return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
		}
    }

	
	public function getRegisterClientStepOne()
	{
		$countries = \App\Models\Country::all();
		$provinces = \App\Models\States::all();
		return view('register_client-step-one', compact('countries', 'provinces'));
	}
	
	
	public function getRegisterClientStepTwo()
	{
		$countries = \App\Models\Country::all();
		$provinces = \App\Models\States::all();
		return view('register_client-step-two', compact('countries', 'provinces'));
	}
	
	
	public function getRegisterClientStepThree()
	{
		$stepOneData = session()->get('step_one_register_data');
		$stepOneData = json_decode($stepOneData);
		$stepTwoData = session()->get('step_two_register_data');
		$stepTwoData = json_decode($stepTwoData);
		//dd([$stepOneData, $stepTwoData, $stepThreeData]);
		
		$province = \App\Models\States::where('id', '=', $stepOneData->province)->first();
		$district = \App\Models\Lga::where('id', '=', $stepOneData->district)->first();
		$guarantor_province = \App\Models\States::where('id', '=', $stepTwoData->guarantor_state_id)->first();
		$guarantor_district = \App\Models\Lga::where('id', '=', $stepTwoData->guarantor_district)->first();
		$passport_name = session()->get('passport_name');
		return view('register_client-step-three', compact('passport_name', 'province', 'district', 'guarantor_province', 'guarantor_district', 'stepOneData', 'stepTwoData'));
	}
	
	protected function postRegisterClientStepOne(\Illuminate\Http\Request $request)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
		
		$all = $request->all();
		//dd($all);
		$rules = ['firstname' => 'required', 'lastname' => 'required', 'homeaddress' => 'required', 
			'city' => 'required', 'country' => 'required', 'province' => 'required', 'district' => 'required', 
			'mobileNumber' => 'required|size:9', 'gender' => 'required', 'nationalid' => 'required', 
			'passport' => 'mimes:jpeg,jpg,png,gif|max:3600', 'prefix' => 'required'];
			
		$messages = [
				'firstname.required' => 'You must provide your first name', 'lastname.required' => 'You must provide your last name', 'homeaddress.required' => 'Provide your home address which will be verified', 
				'city.required' => 'You must provide the city you live in', 'country.required' => 'You must provide the country you live in', 'province.required' => 'You must provide the province you live in', 
				'district.numeric' => 'Provide the district you live in', 'mobileNumber.required' => 'Provide your mobile number',
				'mobileNumber.size' => 'Invalid mobile number provided', 'gender.required' => 'Specify your gender/sex',
				'nationalid.numeric' => 'Provide your valid national Id', 'passport.mimes' => 'Provide your valid passport photo', 
				'passport.max' => 'Passport photo must be less than 3MB', 'prefix.required' => 'Specify your international calling code',
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
		if ($request->hasFile('passport')) {
			$file = $request->file('passport');
			$file_name = str_random(25) . '.' . $file->getClientOriginalExtension();
			$dest = 'img/clients/';
			$file->move($dest, $file_name);
			session()->remove('passport_name');
			session()->put('passport_name', $file_name);
		}
		unset($all['passport']);
		session()->put('step_one_register_data', json_encode($all));
		return \Redirect::to('/register-client-step-two');
	}
	
	
	protected function postRegisterClientStepTwo(\Illuminate\Http\Request $request)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);*/
		
		$all = $request->all();
		//dd($all);
		$rules = ['guarantor_firstname' => 'required', 'guarantor_lastname' => 'required', 'guarantor_address' => 'required', 
			'guarantor_city' => 'required', 'guarantor_country' => 'required', 'guarantor_state_id' => 'required', 'guarantor_district' => 'required', 
			'guarantor_mobileNumber' => 'required', 'guarantor_gender'=> 'required', 'guarantor_prefix' => 'required'];
			
		$messages = [
				'guarantor_firstname.required' => 'You must provide your guarantors first name', 'guarantor_lastname.required' => 'You must provide your guarantors last name', 'guarantor_address.required' => 'Provide your guarantors home address which will be verified', 
				'guarantor_city.required' => 'You must provide the city your guarantor lives in', 'guarantor_country.required' => 'You must provide the country your guarantor lives in', 'guarantor_state_id.required' => 'You must provide the province your guarantor lives in', 
				'guarantor_district.numeric' => 'Provide the district your guarantor lives in', 'guarantor_mobileNumber.required' => 'Provide your guarantors mobile number',
				'guarantor_gender.required' => 'Specify your guarantors gender/sex', 'guarantor_prefix.required' => 'Specify your guarantors phone international code'
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
		session()->put('step_two_register_data', json_encode($all));
		return \Redirect::to('/register-client-step-three');
	}
	
	
	protected function postRegisterClientStepThree(\Illuminate\Http\Request $request)
	{
		\DB::beginTransaction();
		try
		{
			$password = null;
			$stepOneData = session()->get('step_one_register_data');
			$stepOneData = json_decode($stepOneData, TRUE);
			$stepTwoData = session()->get('step_two_register_data');
			$stepTwoData = json_decode($stepTwoData, TRUE);
			//dd([$stepOneData, $stepTwoData, $stepThreeData]);
			
			$firstname = $stepOneData["firstname"];
			$othername = $stepOneData["othername"];
			$lastname = $stepOneData["lastname"];
			$homeaddress = $stepOneData["homeaddress"];
			$city = $stepOneData["city"];
			$country = $stepOneData["country"];
			$province = $stepOneData["province"];
			$district = $stepOneData["district"];
			$prefix = $stepOneData["prefix"];
			$mobileNumber = $stepOneData["mobileNumber"];
			$emailAddress = $stepOneData["emailAddress"];
			$gender = $stepOneData["gender"];
			$nationalid = $stepOneData["nationalid"];
			$guarantor_firstname = $stepTwoData["guarantor_firstname"];
			$guarantor_othername = $stepTwoData["guarantor_othername"];
			$guarantor_lastname = $stepTwoData["guarantor_lastname"];
			$guarantor_address = $stepTwoData["guarantor_address"];
			$guarantor_city = $stepTwoData["guarantor_city"];
			$guarantor_country = $stepTwoData["guarantor_country"];
			$guarantor_state_id = $stepTwoData["guarantor_state_id"];
			$guarantor_district = $stepTwoData["guarantor_district"];
			$guarantor_prefix = $stepTwoData["guarantor_prefix"];
			$guarantor_mobileNumber = $stepTwoData["guarantor_mobileNumber"];
			$guarantor_gender = $stepTwoData["guarantor_gender"];
			$userId = isset($stepOneData['userId']) ? $stepOneData['userId'] : NULL;
			
			$user = new \App\User();
			
			if($userId!=null)
			{
				$user = \App\User::where('id', '=', $userId)->first();
				if($user==null)
				{
					//dd(20);
					return \Redirect::back()->with('error', 'User Account not found. Update failed');
				}
				
				
				$user->username = 		$user->username;
				$user->password = 		$user->password;
				$user->status = 		$user->status;
				
			}
			else
			{
				$userTypeCheck = \App\User::where('username', '=', $mobileNumber)->first();
				
				if($userTypeCheck!=null)
				{
					//dd(21);
					return \Redirect::back()->with('error', 'Seems you already have an account registered on our platform using your phone number. Try to login now');
				}
					
				$password = strtoupper(str_random(8));
				
				$passport_name = session()->get('passport_name');
				$userFile = new \App\Models\UserFile();
				$userFile->file_name = $passport_name;
				$userFile->image_type = 'PROFILE';
				$userFile->save();
				
				$user->username = 		$prefix."".$mobileNumber;
				$user->password = 		\Hash::make($password);
				$user->status = 		'Active';
				$user->image_id = 		$userFile->id;
			}
			$role_type = 'Private Client';
			$accessCode = rand(1000, 9999);
			
			
			
			$user->first_name =	 	$firstname;
			$user->last_name = 		$lastname;
			$user->other_name = 	$othername;
			$user->mobile_number = 	$prefix."".$mobileNumber;
			$user->email_address = 	$emailAddress;
			$user->role_type = 		$role_type;
			$user->country_id = 	explode('|||', $country)[0];
			$user->district_id = 	$district;
			$user->status =	 		'Inactive';
			$user->gender = 		$gender;
			$user->activate_code =	$accessCode;
			$user->total_user_rating = 	0;
			$user->rating_count = 	0;
			$user->national_id = 		$nationalid;
			$user->activate_code =	 	rand(1000, 9999);
			$user->validated =	 	0;
			$user->user_code = 		rand(100000000, 999999999);
			if($user->save())
			{
				$userFile->user_id = $user->id;
				$userFile->save();
				
				$guarantor = new \App\Models\Guarantor();
				$guarantor->first_name = $guarantor_firstname;
				$guarantor->other_name = $guarantor_othername;
				$guarantor->last_name = $guarantor_lastname;
				$guarantor->address = $guarantor_address;
				$guarantor->city = $guarantor_city;
				$guarantor->country_id = explode('|||', $guarantor_country)[0];
				$guarantor->state_id = explode('|||', $guarantor_state_id)[0];
				$guarantor->district_id = $guarantor_district;
				$guarantor->mobile_number = $guarantor_mobileNumber;
				$guarantor->gender = $guarantor_gender;
				$guarantor->user_id = $user->id;
				if($guarantor->save())
				{
					//dd($skills);
					//\DB::commit();
					
					//session()->remove('passport_name');
					//session()->remove('step_one_register_data');
					//session()->remove('step_two_register_data');
					//dd($password);
					$projects = \App\Models\Project::whereIn('status', ['OPEN', 'COMPLETED'])->limit(10)->get();
					$artisans = \App\User::where('role_type', '=', 'Artisan')->get();
					$artisans = $artisans->random($artisans->count()<8 ? $artisans->count() : 8);
					//dd($artisans);
					$skills = [];
					foreach($artisans as $artisan)
						foreach($artisan->artisanSkills as $skill)
							//dd($skill->skill->skill_name);
							//array_push($skills, ucwords(strtolower($skill->skill_name)));
							
					//dd($skills);
					
					$utilities = \App\Models\Utility::where('status', '=', 1)->first();
					$msg = "Your new HandyMade ".$role_type." credentials -\nUsername: " . $prefix."".$mobileNumber . "\nActivation Code:" . $accessCode . "\nPassword: " . $password;
        			send_sms($prefix."".$mobileNumber, $msg, $utilities, null);
    				send_mail('email.signup_client', $emailAddress, $lastname . ' ' . $firstname,
						'Welcome To HandyMade - New '.$role_type.' Account Profile',
						[
							'last_name' => $lastname, 
							'first_name' => $firstname,
							'username' => $prefix."".$mobileNumber,
							'accessCode' => $accessCode,
							'user' => $user,
							'password' => $password, 
							'projects' => $projects,
							'artisans' => $artisans
						]
    				);
					
					//dd(33);
					\DB::commit();
					if($userId!=null)
						return \Redirect::to('/?auth=login')->with('success', 'Your user profile was updated successfully');
					else
						return \Redirect::to('/?auth=login')->with('success', 'A new profile has been created successfully for you');
				}
				else
				{
					//dd(22);
					\DB::rollback();
					if($userId!=null)
						return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
					else
						return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
				}
			}
			else
			{
				//dd(23);
				\DB::rollback();
				if($userId!=null)
					return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
				else
					return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
			}		
			
		}
		catch(Exception $e)
		{
			//dd(25);
			\DB::rollback();
			if($userId!=null)
				return \Redirect::back()->with('error', 'Your user profile was not updated successfully. Ensure you provide your valid details');
			else
				return \Redirect::back()->with('error', 'New profile was not created successfully. Ensure you provide your valid details');
		}
    }

	
}

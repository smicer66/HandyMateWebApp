<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\UserAccount;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterOTPRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use JWTAuth;

class AuthController extends Controller
{
    private $user;
    private $userAccount;
    private $jwtauth;
    private $fnames = ['Emma', 'Olivia', 'Sophia', 'Isabella', 'Ava', 'Mia', 'Emily', 'Abigail', 'Madison', 'Charlotte',
        'Noah', 'Liam', 'Mason', 'Jacob', 'William', 'Ethan', 'Michael', 'Alexander', 'James', 'Daniel'];
    private $snames = ['Cesar', 'Aaron', 'Muyelu', 'Muleyu', 'Somili', 'Milaho', 'Ganiu', 'Benjamin', 'Koggu', 'Shaguy'];
    private $mailsuffix = ['@yahoo.com', '@yahoo.co.uk', '@gmail.com', '@hotmail.com', '@aol.com', '@stanleaf.com',
        '@silverslide.com', '@zescomail.com', '@phillips.com', '@swizz.co.zm'];


    public function __construct(User $user, UserAccount $userAccount, JWTAuth $jwtauth)
    {
        $this->user = $user;
        $this->userAccount = $userAccount;
        $this->jwtauth = $jwtauth;
    }

    public function getName()
    {
        return $this->fnames[rand(0, 19)]." ".$this->snames[rand(0, 9)];
    }

    public function getEmail($name)
    {
        $name = strtolower(str_replace(' ', '_', $name));
        return $name."".$this->mailsuffix[rand(0, 9)];
    }

    public function getMobileNumber()
    {
        return substr(("080".date('mdHs')), 0, 11);
    }



    public function test()
    {
        $str["acctNumber"] = ["Account Numbers must be a 10-digit number"];

        $str_error = "";
        foreach($str as $key => $value)
        {
            foreach($value as $val) {
                $str_error = $str_error . "" . ($val);
            }
        }
        dd(("080".date('mdHs')));
    }
	
	
	public function logoutUser()
	{
		return ['status'=>1];
	}


    public function register(RegisterRequest $request)
    {
		$type = $request->get('type');
		if($type=='Driver')
		{
			$rules = ['mobilenumber' => 'required|numeric', 
			'password' => 'required', 'fname' => 'required',
			'vehicleType' => 'required', 'vehicleManufacturer' => 'required', 
			'manufactureYear' => 'required', 'passengerCount' => 'required', 
			'doors' => 'required', 'vehicleMake' => 'required', 
			'vehicleRegNo' => 'required', 'insuranceExpiryDate' => 'required', 
			'shareARide' => 'required', 'streetAddress'=>'required', 'city'=>'required', 'district'=>'required'];
			
			$messages = [
					'mobilenumber.required' => 'Your Mobile Number must be provided',
					'mobilenumber.numeric' => 'Provide a valid mobile number',
					'password.required' => 'You must provide a valid password',
					'fname.required' => 'Provide your full names',
					'vehicleType.required' => 'Select your vehicle type', 'vehicleManufacturer.required' => 'Select your vehicle manufacturer', 
					'manufactureYear.required' => 'Select your vehicle manufacture year', 'passengerCount.required' => 'Select your vehicles passenger count', 
					'doors.required' => 'Select your vehicles door count', 'vehicleMake.required' => 'Select your vehicles make', 
					'vehicleRegNo.required' => 'Provide the registration number of your vehicle', 'insuranceExpiryDate.required' => 'Provide your expiry date', 'shareARide.required' => 'Specify if you would like to be part of our ShareARide program'
					, 'streetAddress.required' => 'Specify your house address'
					, 'city.required' => 'Specify the city where you live/operate'
					, 'district.required' => 'Specify your district'
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
						$str_error = ($val);
					}
				}
				return response()->json(['status'=>500, 'message'=>($str_error)]);
			}
			
			$user = new User();
			$user->mobileNumber = $request->get('mobilenumber');
			$user->password = \Hash::make($request->get('password'));
			$user->email = $request->has('email') ? $request->get('email') : null;
			$user->name = $request->get('fname');
			$user->pin = str_random(4);
			$user->instance_id = "1.0";
			$user->status = 'Active';
			$user->role_code = $type;
			$user->passport_photo = null;
			$user->refCode = strtoupper(str_random(8));
			$user->streetAddress = $request->get('streetAddress');
			$user->city = $request->get('city');
			$user->district = $request->get('district');
			$user->outstanding_balance = 0.00;
			
			if($user->save())
			{
				$vehicle = new \App\Vehicle();
				$vehicle->vehicle_plate_number = $request->get('vehicleRegNo');
				$vehicle->vehicle_type = $request->get('vehicleRegNo');
				$vehicle->vehicle_maker = $request->get('vehicleRegNo');
				$vehicle->doors = $request->get('vehicleRegNo');
				$vehicle->year = $request->get('vehicleRegNo');
				$vehicle->insurance_expiry = $request->get('vehicleRegNo');
				$vehicle->vehicle_make = $request->get('vehicleRegNo');
				$vehicle->passenger_count = $request->get('vehicleRegNo');
				$vehicle->share_ride = $request->get('vehicleRegNo');
				$vehicle->driver_user_id = $user->id;
				$vehicle->user_full_name = $request->get('fname');
				$vehicle->avg_system_rating = 0.0;
				$vehicle->status = 'Valid';
				$vehicle->outstanding_balance = 0.0;
				$vehicle->rating_count = 0;
				$vehicle->trips_completed_count = 0;
				$vehicle->admin_validated = 0;
				/*$credentials = $request->only('mobilenumber', 'password');
				$token = null;
				try {
					if (!$token = JWTAuth::attempt($credentials)) {
						return response()->json(['invalid_email_or_password'], 422);
					}
				} catch (JWTAuthException $e) {
					return response()->json(['failed_to_create_token'], 500);
				}
				return response()->json(['token'=>$token, 'id'=>$user->id]);*/
				return response()->json(['status'=>1, 'New Driver Account Created Successfully']);
			}
			else
			{
				return response()->json(['status'=>0, 'New Driver Account Creation was not Successful. Please try again']);
			}
		}
		else if($type=='Passenger')
		{
			$rules = ['mobilenumber' => 'required|numeric', 
			'password' => 'required', 
			'fname' => 'required', 'streetAddress'=>'required', 'city'=>'required', 'district'=>'required'];
			
			$messages = [
					'mobilenumber.required' => 'Your Mobile Number must be provided',
					'mobilenumber.numeric' => 'Provide a valid mobile number',
					'password.required' => 'You must provide a valid password',
					'fname.required' => 'Provide your full names', 'streetAddress.required' => 'Specify your house address'
					, 'city.required' => 'Specify the city where you live/operate'
					, 'district.required' => 'Specify your district'
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
						$str_error = ($val);
					}
				}
				return response()->json(['status'=>500, 'message'=>($str_error)]);
			}
			
			$user = new User();
			$user->mobileNumber = $request->get('mobilenumber');
			$user->password = \Hash::make($request->get('password'));
			$user->email = $request->get('email');
			$user->name = $request->get('fname');
			$user->pin = str_random(4);
			$user->instance_id = "1.0";
			$user->status = 'Active';
			$user->role_code = $type;
			$user->passport_photo = null;
			$user->refCode = strtoupper(str_random(8));
			$user->streetAddress = $request->get('streetAddress');
			$user->city = $request->get('city');
			$user->district = $request->get('district');
			$user->outstanding_balance = 0.00;
			
			if($user->save())
			{
				/*$credentials = $request->only('mobilenumber', 'password');
				$token = null;
				try {
					if (!$token = JWTAuth::attempt($credentials)) {
						return response()->json(['invalid_email_or_password'], 422);
					}
				} catch (JWTAuthException $e) {
					return response()->json(['failed_to_create_token'], 500);
				}
				return response()->json(['token'=>$token, 'id'=>$user->id]);
			}
			else
			{
				return response()->json(['invalid_email_or_password'], 422);*/
				return response()->json(['status'=>1, 'New Driver Account Created Successfully']);
			}
			else
			{
				return response()->json(['status'=>0, 'New Driver Account Creation was not Successful. Please try again']);
			}
			
			//TODO: implement JWT
		}
    }


    public function registerOTP(RegisterOTPRequest $request)
    {

        $rules=[
            //
            'otpAcctNumber'=>'required|size:10',
            'otpMobileNumber' => 'required|size:11',
            'otpNumber'=>'required',
        ];

        $messages=[
            //
            'otpAcctNumber.required'=>'Account Number must be provided',
            'otpAcctNumber.size'=>'Account Number must be a 10-digit number',
            'otpMobileNumber.required' => 'Your registered mobile number must be provided',
            'otpMobileNumber.size'=>'Mobile number must be a 11-digits',
            'otpNumber.required' => 'Authentication Code/OTP must be provided',
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
                    $str_error = ($val);
                }
            }
            return response()->json(($str_error), 500);
        }
        $otpAcctNumber = $request->get('otpAcctNumber');
        $otpMobileNumber = $request->get('otpMobileNumber');
        $otpNumber = $request->get('otpNumber');


        $credentials = $request->only('username', 'password');
        if (\Auth::attempt(['mobileNumber' => $request->otpMobileNumber, 'password' => $request->otpNumber])) {

            $dbUser = NULL;

            if($otpNumber!=NULL) {
                $dbUser = \DB::table('useraccounts')
                    ->join('users', 'useraccounts.userId', '=', 'users.id')
                    ->where('useraccounts.accountNumber', '=', $otpAcctNumber)
                    ->where('users.mobileNumber', '=', $request->otpMobileNumber);
            }
            if ($dbUser!=NULL && $dbUser->count()>0) {
                User::whereId($dbUser->first()->userId)->update(
                    [
                        'status' => 'Active'
                    ]
                );
                return response()->json([
                    'status' => true
                ]);
            }else{
                return response()->json(['failed_to_validate_otp'], 500);
            }
        }


        //TODO: implement JWT

    }


    public function login(LoginRequest $request)
    {
        //TODO: authenticate JWT
		$loginRoleType = $request->get('roleCode');
		$credentials = $request->only('mobileNumber', 'password');
		$vehicleIcons = ['Sedan'=>'sedan', 'SUV'=>'suv', 'Sports'=>'sports', 'Luxury'=>'luxury', 'Taxi'=>'taxi'];
		$vehicleTypeKeys = array_keys($vehicleIcons);
        $token = null;
        $acctCount = 0;
        $rules = ['mobileNumber' => 'required|numeric', 
		'password' => 'required'];
		
        $messages = [
                'mobileNumber.required' => 'Your ProbasePay Mobile Account mobile number is required to login',
				'mobileNumber.numeric' => 'Your ProbasePay Mobile Account mobile number must consist of numbers',
				'password.required' => 'Your ProbasePay Mobile Account Password is required to login'
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
                    $str_error = ($val);
                }
            }
            return response()->json([status=>500, 'message'=>($str_error)]);
        }


        $credentials = $request->only('mobileNumber', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([status=>500, 'message'=>'Invalid username/password combination provided. Provide your valid username and password']);
            }
        } catch (JWTAuthException $e) {
            return response()->json([status=>500, 'message'=>'Invalid username/password combination provided. Provide your valid username and password']);
        }
		$user = JWTAuth::toUser($token);
		$vehicleDB = \DB::table('vehicles')->where('driver_user_id', '=', $user->id)->first();
		$driver = [];
		$activePassengerTripId = 0;
		$passengerDeal = null;
		
		if($user->role_code=='DRIVER' && $loginRoleType=='DRIVER')
		{
			if($vehicleDB!=null)
			{
				$earnings = \DB::table('transactions')->where('driverUserId', '=', $user->id)->where('status', '=', 'Success')->get();
				$totalEarning = 0;
				foreach($earnings as $earning)
				{
					$totalEarning = $totalEarning + $earning->amount;
				}
				$driver = ['id'=>$user->id, 'plate'=>$vehicleDB->vehicle_plate_number, 'type'=>$vehicleDB->vehicle_type, 'name'=>$user->name, 
					'refCode'=>$user->refCode, 'rating'=>$vehicleDB->avg_system_rating, 'balance'=>number_format($totalEarning, 2, '.', ','),  
					'profile_pix'=>"http://taxizambia.probasepay.com/users/".$user->passport_photo, 'earning'=>$totalEarning, 'outstanding_balance'=>$user->outstanding_balance];
			}
		}
		else if($user->role_code=='PASSENGER' && $loginRoleType=='PASSENGER')
		{
			$activePassengerTrip = \DB::table('trips')->where('passenger_user_id', '=', $user->id)->whereIn('status', ['Pending', 'Going'])->orderBy('id', 'DESC')->first();
			if($activePassengerTrip!=null)
			{
				$activePassengerTripId = $activePassengerTrip->id;
			}
			else
			{
				$activePassengerDeal = \DB::table('driver_deals')->where('passenger_user_id', '=', $user->id)
					->whereIn('status', ['Pending'])->orderBy('id', 'DESC')->first();
					
				$sql = 'SELECT * FROM `driver_deals` WHERE 
					passenger_user_id = '.$user->id.' AND status IN ("Pending") AND 
					DATE_ADD(created_at, INTERVAL '.DEAL_MAKING_INTERVAL.' MINUTE) > NOW() ORDER by created_at DESC';
					//Created AT = 10:00 + 15 = 10:15	> Now = 10:30 (False) go to home page for new deals
					//Created AT = 10:00 + 15 = 10:15	> Now = 10:14 (true) repeat old deals
				$activePassengerDeal = \DB::select($sql);
				//dd($activePassengerDeal);
				
				$completedCheck = false;
				
				if($activePassengerDeal!=null && sizeof($activePassengerDeal)>0)
				{
					$activePassengerDeal = $activePassengerDeal[0];
					$activePassengerDealVehicle = \DB::table('vehicles')->where('id', '=', $activePassengerDeal->vehicle_id)->first();
					$vehicleTypeIcon = in_array($activePassengerDealVehicle->vehicle_type, $vehicleTypeKeys) ? $vehicleIcons[$activePassengerDealVehicle->vehicle_type] : $vehicleIcons['Taxi'];
					$currentVehicle = ['vehicleType'=>$activePassengerDealVehicle->vehicle_type, 'icon'=>$vehicleTypeIcon];
					$origin = ['location'=>['lat'=>$activePassengerDeal->origin_latitude, 'lng'=>$activePassengerDeal->origin_longitude, 'vicinity'=>$activePassengerDeal->origin_locality]];
					$dest = ['location'=>['lat'=>$activePassengerDeal->destination_longitude, 'lng'=>$activePassengerDeal->destination_longitude, 'vicinity'=>$activePassengerDeal->destination_locality]];
					$passengerDeal = ['locality'=>$activePassengerDeal->origin_locality, 'currentVehicle'=>$currentVehicle, 
					'originLat'=>$activePassengerDeal->origin_latitude, 'originLng'=>$activePassengerDeal->origin_longitude, 
					'origin'=>$origin, 'destination'=>$dest, 'distance'=>$activePassengerDeal->distance, 'fee'=>$activePassengerDeal->fee, 
					'currency'=>"ZMW", 'note'=>$activePassengerDeal->note, 'paymentMethod'=>$activePassengerDeal->payment_method];
				}
			}
			
		}
		else
		{
			return response()->json(['status'=>422, 'message'=>'Invalid User Account']);
		}
        return response()->json(['status'=>1, 'token'=>$token, 'user'=>['id'=>$user->id, 'photoURL'=>"http://taxizambia.probasepay.com/users/".$user->passport_photo, 'displayName'=>$user->name, 
			'name'=>$user->name, 'phoneNumber'=>$user->mobileNumber, 'email'=>$user->email], 'driver'=>$driver, 'activePassengerTripId'=>$activePassengerTripId, 'passengerDeal'=>$passengerDeal]);

    }
	
	
	
	
	/*public function login(LoginRequest $request)
    {
        //TODO: authenticate JWT
		$loginRoleType = $request->get('roleCode');
		$credentials = $request->only('mobileNumber', 'password');
		$vehicleIcons = ['Sedan'=>'sedan', 'SUV'=>'suv', 'Sports'=>'sports', 'Luxury'=>'luxury', 'Taxi'=>'taxi'];
		$vehicleTypeKeys = array_keys($vehicleIcons);
        $token = null;
        $acctCount = 0;
        $rules = ['mobileNumber' => 'required|numeric', 
		'password' => 'required'];
		
        $messages = [
                'mobileNumber.required' => 'Your ProbasePay Mobile Account mobile number is required to login',
				'mobileNumber.numeric' => 'Your ProbasePay Mobile Account mobile number must consist of numbers',
				'password.required' => 'Your ProbasePay Mobile Account Password is required to login'
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
                    $str_error = ($val);
                }
            }
            return response()->json(($str_error), 500);
        }


        $credentials = $request->only('mobileNumber', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
		$user = JWTAuth::toUser($token);
		$vehicleDB = \DB::table('vehicles')->where('driver_user_id', '=', $user->id)->first();
		$driver = [];
		$activePassengerTripId = 0;
		$passengerDeal = null;
		
		if($user->role_code=='DRIVER' && $loginRoleType=='DRIVER')
		{
			if($vehicleDB!=null)
			{
				$earnings = \DB::table('transactions')->where('driverUserId', '=', $user->id)->get();
				$totalEarning = 0;
				foreach($earnings as $earning)
				{
					$totalEarning = $totalEarning + $earning->amount;
				}
				$driver = ['id'=>$user->id, 'plate'=>$vehicleDB->vehicle_plate_number, 'type'=>$vehicleDB->vehicle_type, 'name'=>$user->name, 
					'refCode'=>$user->refCode, 'rating'=>$vehicleDB->avg_system_rating, 'balance'=>number_format($vehicleDB->outstanding_balance, 2, '.', ','),  
					'profile_pix'=>"http://taxizambia.probasepay.com/users/".$user->passport_photo, 'earning'=>$totalEarning];
			}
		}
		else if($user->role_code=='PASSENGER' && $loginRoleType=='PASSENGER')
		{
			$activePassengerTrip = \DB::table('trips')->where('passenger_user_id', '=', $user->id)->whereIn('status', ['Pending', 'Going'])->orderBy('id', 'DESC')->first();
			if($activePassengerTrip!=null)
			{
				$activePassengerTripId = $activePassengerTrip->id;
			}
			else
			{
				$activePassengerDeal = \DB::table('driver_deals')->where('passenger_user_id', '=', $user->id)
					->whereIn('status', ['Pending'])->orderBy('id', 'DESC')->first();
					
				$sql = 'SELECT * FROM `driver_deals` WHERE 
					passenger_user_id = '.$user->id.' AND status IN ("Pending") AND 
					DATE_ADD(created_at, INTERVAL '.DEAL_MAKING_INTERVAL.' MINUTE) > NOW() ORDER by created_at DESC';
					//Created AT = 10:00 + 15 = 10:15	> Now = 10:30 (False) go to home page for new deals
					//Created AT = 10:00 + 15 = 10:15	> Now = 10:14 (true) repeat old deals
				$activePassengerDeal = \DB::select($sql);
				//dd($activePassengerDeal);
				
				$completedCheck = false;
				
				if($activePassengerDeal!=null && sizeof($activePassengerDeal)>0)
				{
					$activePassengerDeal = $activePassengerDeal[0];
					$activePassengerDealVehicle = \DB::table('vehicles')->where('id', '=', $activePassengerDeal->vehicle_id)->first();
					$vehicleTypeIcon = in_array($activePassengerDealVehicle->vehicle_type, $vehicleTypeKeys) ? $vehicleIcons[$activePassengerDealVehicle->vehicle_type] : $vehicleIcons['Taxi'];
					$currentVehicle = ['vehicleType'=>$activePassengerDealVehicle->vehicle_type, 'icon'=>$vehicleTypeIcon];
					$origin = ['location'=>['lat'=>$activePassengerDeal->origin_latitude, 'lng'=>$activePassengerDeal->origin_longitude, 'vicinity'=>$activePassengerDeal->origin_locality]];
					$dest = ['location'=>['lat'=>$activePassengerDeal->destination_longitude, 'lng'=>$activePassengerDeal->destination_longitude, 'vicinity'=>$activePassengerDeal->destination_locality]];
					$passengerDeal = ['locality'=>$activePassengerDeal->origin_locality, 'currentVehicle'=>$currentVehicle, 
					'originLat'=>$activePassengerDeal->origin_latitude, 'originLng'=>$activePassengerDeal->origin_longitude, 
					'origin'=>$origin, 'destination'=>$dest, 'distance'=>$activePassengerDeal->distance, 'fee'=>$activePassengerDeal->fee, 
					'currency'=>"ZMW", 'note'=>$activePassengerDeal->note, 'paymentMethod'=>$activePassengerDeal->payment_method];
				}
			}
			
		}
		else
		{
			return response()->json(['invalid_email_or_password'], 422);
		}
        return response()->json(['token'=>$token, 'user'=>['id'=>$user->id, 'photoURL'=>"http://taxizambia.probasepay.com/users/".$user->passport_photo, 'displayName'=>$user->name, 
			'name'=>$user->name, 'phoneNumber'=>$user->mobileNumber, 'email'=>$user->email], 'driver'=>$driver, 'activePassengerTripId'=>$activePassengerTripId, 'passengerDeal'=>$passengerDeal]);

    }*/
	
	
	
	public function recoverPassword()
	{
		$input = \Input::all();
		$mobileNumber = $input['mobileNumber'];
		$user = User::where('mobileNumber', '=', $input['mobileNumber'])->first();
		if($user!=null)
		{
			$password = str_random(8);
			$user->password = \Hash::make($password);
			if($user->save())
			{
				$mobile = strpos($mobile, "260")==0 ? $mobile : ("26".$mobile);
				send_sms($mobile, $msg, $sender=NULL);
				return response()->json(['status'=>1]);
			}
		}
		return response()->json(['status'=>0]);
	}
	
	
	public function getUserByToken()
	{
		//$token = JWTAuth::getToken();
		//$tripId 	= $request->has('tripId') ? $request->get('tripId') : null;
		//$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQsImlzcyI6Imh0dHA6XC9cL3RheGl6YW1iaWEuY29tXC9hcGlcL3YxXC9hdXRoXC9sb2dpbiIsImlhdCI6MTUwNzIzMzAwOCwiZXhwIjoxNTA3MjM2NjA4LCJuYmYiOjE1MDcyMzMwMDgsImp0aSI6IjRmMWU0MDVlNDc0YmY2YTI2NTg3ZjQ2MDRjZTQ4ZDE0In0.8B66_SgOqHG9zhYvPjUKkDy1PqpDbCst6XjVs88IWPI';
		//$user = JWTAuth::toUser($token);
		$user = \App\User::where('id', '=', 4)->first();
		
        try {
            
			if($user!=null)
			{
				$user_ = ['id'=>$user->id, 'name'=>$user->name,
					'email' => $user->email, 'role_code'=>$user->role_code, 'passport_photo'=>"http://taxizambia.probasepay.com/users/".$user->passport_photo];
				return response()->json(['status'=>1, 'user'=>$user_]);
			}
			else
			{
				return response()->json(['status'=>0]);
			}
			

        }catch(TokenExpiredException $e)
        {
            return response()->json(['TokenExpired'], 422);
        }
	}
}

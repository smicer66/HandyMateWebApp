<?php


/**
 * Generate Primary Key for inserting values
 * @return string
 */
 
define("MERCHANT_ID", 'QSP7WB4G3W');
define("DEVICE_CODE", 'USQS03ZA');
define("SERVICE_TYPE", '1981511018900');
define ('DEFAULT_PAYEE_EMAIL', 'smicer66@gmail.com');
define("DEFAULT_DOMAIN", '127.0.0.1:8000');
define("PAYMENT_API_KEY", 'XwLstm5Jdn5QXQqYze0l5pPMrprYfC4t');
define("DEFAULT_CURRENCY", 'ZM');
define('DEFAULT_BANK_CODE', '3452');
define('CANCELATION_FEE', 50.00);



//https://159.8.22.212:8443
function log_audit_trail($action, $actor_detail, $user, $old_data,  $new_data, $object_id)
{
	$auditTrail = new \App\AuditTrail();
	$auditTrail->action = $action;
	$auditTrail->actor_detail = $actor_detail;
	$auditTrail->user_id = $user!=null ? $user->id : null;
	$auditTrail->old_data = $old_data;
	$auditTrail->new_data = $new_data;
	$auditTrail->object_id = $object_id;
	$auditTrail->request_ip = request()->ip();
	$auditTrail->save();
	
}

function get_settings()
{
	$settings = \App\Setting::all();
	$setting_ = [];
	foreach($settings as $setting)
	{
		$setting_[$setting->setting_name] = $setting->setting_value;
	}
	return $setting_;
}

function addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $id)
{
	$notification = new \App\Models\Notification();
	$notification->notification_contents = $notification_contents;
	$notification->notification_url = $notification_url;
	$notification->read_yes = 0;
	$notification->receiver_user_id = $receiver_user_id;
	$notification->type = $type;
	$notification->notif_code = $notif_code;
	$notification->model_id = $id;
	$notification->save();
}

function send_mail($view, $to, $recipientName, $subject, $data = array())
{
	try{
		//dd([$view, $to, $recipientName, $subject, $data]);
		$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class);
		$beautymail->send($view, $data, function($message) use($to, $subject)
		{
			$to = "smicer66@gmail.com";
			$from = 'mailer@shikola.com';
			$message
					->from($from)
					->to($to, $to)
					->subject($subject);
		});
	}catch(\Exception $e)
	{
		//dd($e);
	}
}



function send_sms($mobile, $msg, $utilities, $user=NULL)
{
	//$mobile = "260967307151";
	//dd($msg);
    $mobile = substr(trim($mobile), 0, 3)=='260' ? $mobile : (substr(trim($mobile), 0, 1)=='0' ? '26'.trim($mobile) : $mobile);
	if($utilities->sms_key==null || $utilities->is_sms==0)
    {
        $smsLog = new \App\Models\SmsLog();
		$smsLog->receipient_no = $mobile;
		$smsLog->response = 'SMS Sending Deactivated';
		$smsLog->message = $msg;
		$smsLog->success = 0;
		if($user!=null)
			$smsLog->sender_user_id = $user->id;
		$smsLog->save();
		//dd(22);
		return false;
    }
	
	
	$cred = explode('|||', $utilities->sms_key);
	if(sizeof($cred)!=2)
	{
	    $smsLog = new \App\Models\SmsLog();
		$smsLog->receipient_no = $mobile;
		$smsLog->response = 'Invalid SMS key';
		$smsLog->message = $msg;
		$smsLog->success = 0;
		if($user!=null)
			$smsLog->sender_user_id = $user->id;
		$smsLog->save();
		//dd(11);
		return false;
	}
	
	//$url = "http://smsapi.probasesms.com/apis/text/index.php?username=".$cred[0]."&password=".$cred[1]."&mobiles=".$mobile."&message=".$msg."&sender=".($utilities->sms_sender==null ? "Shikola" : $utilities->sms_sender)."&type=TEXT";
	$responseBool = false;
	
	
	if($mobile!=null)
	{
    	try{
    		$getdata = http_build_query(
    			array(
    				'username' => $cred[0],
    				'password' => $cred[1],
    				'mobiles'=> $mobile,
    				'message'=>$msg,
    				'sender'=>($utilities->sms_sender==null ? "Shikola" : $utilities->sms_sender),
    				'type' => 'TEXT',
    				//'source' =>($utilities->sms_sender==null ? "Shikola" : $utilities->sms_sender)
    			)
    		);
    		
    		//$url = "http://smsapi.probasesms.com/apis/text/index.php?".$getdata;
    		$url = "https://www.probasesms.com/text/multi/res/trns/sms?".$getdata;
    		//?username=mpelembe&password=password@1&sender=Mpelembe&mobiles=260967307151&source=Mpelembe&message=testing
    		//dd($url);
			//https://www.probasesms.com/text/multi/res/trns/sms?username=rtsa&password=password@1&mobiles=260967307151&message=123&sender=RTSA&type=TEXT
    		
    		$responseSms = file_get_contents($url);
    		//dd($responseSms);
    		$body = (trim(preg_replace('/\s+/', ' ', $responseSms)));
    		
    		$xml = new \SimpleXMLElement($body);
    		//print_r($xml);
    		$str = ($xml->response[0]->messagestatus);
    		$str_=($str);
    		
    		$smsLog = new \App\Models\SmsLog();
    		$smsLog->receipient_no = $mobile;
    		$smsLog->response = $body;
    		$smsLog->message = $msg;
    		if($str_=='SUCCESS')
    		{
    			$smsLog->success = 1;
    			$responseBool = true;
    		}else
    		{
    			$smsLog->success = 0;
    		}
			if($user!=null)
				$smsLog->sender_user_id = $user->id;
    		$smsLog->save();
    		//dd($url);
    	}catch(\Exception $e)
    	{
			$message = $e->getMessage();
    		$smsLog = new \App\Models\SmsLog();
    		$smsLog->receipient_no = $mobile;
    		$smsLog->response = $message;
    		$smsLog->message = $msg;
    		$smsLog->success = 0;
			if($user!=null)
				$smsLog->sender_user_id = $user->id;
    		$smsLog->save();
    	}
	}
	return $responseBool;
	
}


?>
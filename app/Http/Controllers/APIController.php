<?php

namespace App\Http\Controllers;

use \DateTime;
use \Hash;
use \Milon\Barcode\DNS1D;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\ApiRequest;


class APIController extends Controller
{
    private $jwtAuth;
    public function __construct(JWTAuth $jwtauth)
    {
        //parent::__construct();
        //dd($jwtauth);
        //$this->middleware('guest')->except('logout');
        //$this->user = $user;
        $this->middleware('jwt.auth', ['except' => ['postLogin', 'logout', 'postLoginApi', 'getLogout']]);
        $this->jwtAuth = $jwtauth;
    }


    public function postLoginApi(\Illuminate\Http\Request $request)
    {

        $credentials_ = $request->only('prefix', 'username', 'password');
        //$credentials = \Input::all();

        $prfix = $request->get('prefix');
        $usname = $request->get('username');
        $mob = "";
        //dd(strpos($usname, '0'));
        if(strpos($usname, '0')===0)
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

        //dd($credentials);
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

            return response()->json([
                'success' => false,
                'message' => 'Invalid login credentials provided',
            ], 401);
        }


        //dd($credentials);
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        //dd($this->jwt->User());
        $user = JWTAuth::toUser($jwt_token);
        //dd($user);
        $countries = \App\Models\Country::all();
        $provinces = \App\Models\States::all();
        $districts = \App\Models\Lga::all();
        $skills = \App\Models\Skill::all();
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'user'=>$user,
            'countries'=>$countries,
            'provinces'=>$provinces,
            'districts'=>$districts,
            'skills'=>$skills
        ]);
    }


    public function postGetUserImage(\Illuminate\Http\Request $request)
    {
        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);
        $userCurrent = \App\User::where('id', '=', $user->id)->first();
        if($userCurrent->image_id !=null)
        {
            $userImage = \App\Models\UserFile::where('id', '=', $userCurrent->image_id)
                ->first();
            if($userImage!=null)
            {
                return response()->json([
                    'success' => true,
                    'pix_path'=>'http://handymateservices.com/img/clients/'.$userImage->file_name,
                    'user'=> $userCurrent
                ]);
            }
        }
        return response()->json([
            'success' => false
        ]);
    }


    public function getAllProjects(\Illuminate\Http\Request $request)
    {

        $status = $request->get('status');
        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);


            $projects = \App\Models\Project::orderBy('created_at', 'DESC');
            if($status!=null)
            {
                $projects = $projects->where('status', '=', $status);
            }
            $projects = $projects->with('bids.bid_by_user')->with('created_by_user')
                ->with('skills.skill')
                ->with('district')
                ->with('state')->get();
            if($projects->count()>0) {
                return response()->json([
                    'success' => true,
                    'projects' => $projects
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'There are no projects currently available'
                ]);
            }


    }



    public function getMyProjects(\Illuminate\Http\Request $request)
    {

        $status = $request->get('status');
        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);

        if($user->role_type=='Private Client' || $user->role_type=='Corporate Client')
        {
            $projects = \App\Models\Project::where('created_by_user_id', '=', $user->id)
                ->orderBy('created_at', 'DESC');
            if($status!=null)
            {
                $projects = $projects->where('status', '=', $status);
            }
            $projects = $projects->with('bids.bid_by_user')->with('created_by_user')
                ->with('skills.skill')
                ->with('district')
                ->with('state')->get();
            if($projects->count()>0) {
                return response()->json([
                    'success' => true,
                    'projects' => $projects
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'There are no projects currently available'
                ]);
            }
        }
        else if($user->role_type=='Artisan')
        {
            $projectList = [];
            $projectBids = \App\Models\ProjectBid::where('bid_by_user_id', '=', $user->id)
                ->get();
            foreach($projectBids as $projectBid)
            {
                array_push($projectList, $projectBid->project_id);
            }
            $projects = \App\Models\Project::whereIn('id', $projectList)
                ->orderBy('created_at', 'DESC');
            if($status!=null)
            {
                $projects = $projects->where('status', '=', $status);
            }
            $projects = $projects->with('bids.bid_by_user')->with('created_by_user')
                ->with('skills.skill')
                ->with('district')
                ->with('state')->get();
            if($projects->count()>0) {
                return response()->json([
                    'success' => true,
                    'projects' => $projects
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'There are no projects currently available'
                ]);
            }
        }
        else
        {

            return response()->json([
                'success' => true,
                'projects' => []
            ]);
        }



    }



    public function postComposeMessage(\Illuminate\Http\Request $request)
    {

        \DB::beginTransaction();
        try {
            $jwt_token = JWTAuth::getToken();
            //return response()->json(['token' => $jwt_token]);
            $user = JWTAuth::toUser($jwt_token);
            $all = $request->all();
            $rules = ['message' => 'required',
                'receiver' => 'required'];

            $messages = [
                'message.required' => 'You must provide the contents of your message',
                'receiver.required' => 'We could not find the receipient of this message'
            ];
            $validator = \Validator::make($all, $rules, $messages);
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

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid login credentials provided',
                ], 401);
            }

            $projectId = $all['projectId'];
            $project = \App\Models\Project::where('id', '=', $projectId)->first();
            if($project!=null)
            {
                if($project->status=='OPEN' || $project->status=='ASSIGNED' ||  $project->status=='IN PROGRESS')
                {
                    if($project->status=='ASSIGNED' && $project->assigned_bidder_id!=$user->id && $user->role_type=='Artisan')
                    {
                        return \Redirect::back()->with('error', 'You can not send a message on this project');
                    }
                    if(($user->role_type=='Private Client' || $user->role_type=='Corporate Client') && $user->id!=$project->created_by_user_id)
                    {
                        return \Redirect::back()->with('error', 'You can not send a message on this project');
                    }
                    $all = $request->all();


                    $receiver = null;
                    if(isset($all['receiver']) && ($user->role_type=='Private Client' || $user->role_type=='Corporate Client'))
                    {
                        $receiver = $all['receiver'];
                        $receiver = \App\User::where('id', '=', $receiver)->first();
                    }

                    //dd($receiver);

                    $messageThreadCode1 = "";
                    $messageThreadCode2 = "";
                    if($project->status=='ASSIGNED')
                    {
                        if($user->role_type=='Artisan')
                        {
                            $messageThreadCode1 = $project->id."".$user->user_code."".$project->created_by_user->user_code;
                            $messageThreadCode2 = $project->id."".$project->created_by_user->user_code."".$user->user_code;
                        }
                        else if($user->role_type=='Private Client' || $user->role_type=='Corporate Client')
                        {
                            $messageThreadCode1 = $project->id."".$user->user_code."".$project->assigned_bidder->user_code;
                            $messageThreadCode2 = $project->id."".$project->assigned_bidder->user_code."".$user->user_code;
                        }
                    }
                    else if($project->status=='OPEN')
                    {
                        if($user->role_type=='Artisan')
                        {
                            $messageThreadCode1 = $project->id."".$user->user_code."".$project->created_by_user->user_code;
                            $messageThreadCode2 = $project->id."".$project->created_by_user->user_code."".$user->user_code;
                        }
                        else if($user->role_type=='Private Client' || $user->role_type=='Corporate Client')
                        {
                            $messageThreadCode1 = $project->id."".
                                $user->user_code."".
                                $receiver->user_code;
                            $messageThreadCode2 = $project->id."".
                                $receiver->user_code."".
                                $user->user_code;
                        }
                    }
                    else if($project->status=='IN PROGRESS')
                    {
                        if($user->role_type=='Artisan')
                        {
                            $messageThreadCode1 = $project->id."".$user->user_code."".$project->created_by_user->user_code;
                            $messageThreadCode2 = $project->id."".$project->created_by_user->user_code."".$user->user_code;
                        }
                        else if($user->role_type=='Private Client' || $user->role_type=='Corporate Client')
                        {
                            $messageThreadCode1 = $project->id."".$user->user_code."".$project->assigned_bidder->user_code;
                            $messageThreadCode2 = $project->id."".$project->assigned_bidder->user_code."".$user->user_code;
                        }
                    }
                    $messageThread = \App\Models\MessageThread::where('project_id', '=', $project->id)
                        ->whereIn('threadCode', [$messageThreadCode1, $messageThreadCode2])->first();

                    if($messageThread==null)
                    {
                        $messageThread = new \App\Models\MessageThread();
                        if($project->status=='ASSIGNED')
                        {
                            if($user->role_type=='Artisan')
                            {
                                $messageThread->threadCode = $project->id."".$user->user_code."".$project->created_by_user->user_code;
                            }
                            else if($user->role_type=='Private Client' || $user->role_type=='Corporate Client')
                            {
                                $messageThread->threadCode = $project->id."".$user->user_code."".$project->assigned_bidder->user_code;
                            }
                        }
                        else if($project->status=='OPEN')
                        {
                            if($user->role_type=='Artisan')
                            {
                                $messageThread->threadCode = $project->id."".$user->user_code."".$project->created_by_user->user_code;
                            }
                            else if($user->role_type=='Private Client' || $user->role_type=='Corporate Client')
                            {
                                $messageThread->threadCode = $project->id."".$user->user_code."".$receiver->user_code;
                            }
                        }
                        else if($project->status=='IN PROGRESS')
                        {
                            if($user->role_type=='Artisan')
                            {
                                $messageThread->threadCode = $project->id."".$user->user_code."".$project->created_by_user->user_code;
                            }
                            else if($user->role_type=='Private Client' || $user->role_type=='Corporate Client')
                            {
                                $messageThread->threadCode = $project->id."".$user->user_code."".$project->assigned_bidder->user_code;
                            }
                        }
                        $messageThread->project_id = $project->id;
                        $messageThread->last_message = '';
                        $messageThread->save();

                    }

                    $message = new \App\Models\Message();
                    $message->sender_user_id = $user->id;

                    if($user->role_type=='Private Client' || $user->role_type=='Corporate Client')
                    {
                        if($project->status=='ASSIGNED')
                            $message->receipient_user_id = $user->id;
                        else if($project->status=='OPEN')
                            $message->receipient_user_id = $receiver->id;
                        if($project->status=='IN PROGRESS')
                            $message->receipient_user_id = $user->id;
                    }
                    else if($user->role_type=='Artisan')
                    {
                        if($project->status=='ASSIGNED')
                            $message->receipient_user_id = $project->created_by_user->id;
                        else if($project->status=='OPEN')
                            $message->receipient_user_id = $project->created_by_user->id;
                        if($project->status=='IN PROGRESS')
                            $message->receipient_user_id = $user->id;
                    }

                    $message->message_body = $all['message'];
                    $message->project_id = $project->id;
                    $message->receipient_read_yes = 0;
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


                    $project = \App\Models\Project::where('id', '=', $project->id);
                    $project = $project->with('bids.bid_by_user')->with('created_by_user')
                        ->with('skills.skill')
                        ->with('district')
                        ->with('state')->first();
                    return response()->json([
                        'success' => true,
                        'project' => $project,
                        'message' => 'Your message has been sent successfully',
                    ]);
                }
                else
                {
                    \DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'The current status of the project does not allow you to send a message',
                    ], 401);
                }
            }
            else
            {
                \DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Project could not be found',
                ], 401);
            }
        }
        catch(\Exception $e)
        {
            dd($e);
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'We experienced issues sending your message',
            ], 401);
        }
    }


    public function postGetAllMessageThreads(\Illuminate\Http\Request $request)
    {
        $all = $request->all();
        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);
        $msgThreadIds = [];
        $msgThreadIds_ = [];
        //$projectId = $request->get('projectId');
        $projectId = $request->get('projectId');
        //dd($projectId);
        //dd($request);

        $hql = "Select * from messages where (sender_user_id = ".$user->id." OR receipient_user_id = ".$user->id.") AND ".
            "deleted_at IS NULL";
        if($projectId!=null)
        {
            $hql = $hql." AND project_id = ".$projectId;
        }
        $messages = \DB::select($hql);
        /*$messages = \App\Models\Message::where('sender_user_id', '=', $user->id)
            ->orWhere('receipient_user_id', '=', $user->id)
            ->orderBy('created_at', 'DESC');
        if($projectId==null)
        {
            $messages = $messages->where('project_id', '=', $projectId);
        }
        $messages = $messages->get();*/



        foreach($messages as $msg)
        {
            if(!isset($msgThreadIds[$msg->message_thread_id])) {
                array_push($msgThreadIds_, $msg->message_thread_id);
                $msgThreadIds[$msg->message_thread_id] = [];
                $msgThreadIds[$msg->message_thread_id]['all'] = 1;
                $msgThreadIds[$msg->message_thread_id]['unread'] = 0;
                if($msg->receipient_read_yes==0 && $user->id==$msg->receipient_user_id)
                    $msgThreadIds[$msg->message_thread_id]['unread'] = 1;

            }
            else{
                $msgThreadIds[$msg->message_thread_id]['all'] = $msgThreadIds[$msg->message_thread_id]['all'] + 1;
                if($msg->receipient_read_yes==0 && $user->id==$msg->receipient_user_id)
                    $msgThreadIds[$msg->message_thread_id]['unread'] = $msgThreadIds[$msg->message_thread_id]['unread'] + 1;
            }
        }
        $messageThreads = \App\Models\MessageThread::whereIn('message_threads.id', ($msgThreadIds_))
            ->leftJoin('messages', 'message_threads.last_message_id', '=', 'messages.id')
            ->leftJoin('users', 'messages.sender_user_id', '=', 'users.id')
            ->leftJoin('projects', 'messages.project_id', '=', 'projects.id');
        //dd($messageThreads->get());
        if($projectId!=null)
        {
            $messageThreads = $messageThreads->where('projects.id', '=', $projectId);
        }
        $messageThreads = $messageThreads->orderBy('message_threads.created_at', 'DESC');
        $messageThreads = $messageThreads->select('message_threads.*', 'messages.*', 'users.*', 'projects.*',
            'message_threads.id as threadId', 'messages.created_at as message_date_sent', 'projects.status as projectStatus');
        $messageThreads = $messageThreads->get();
        //dd([$messageThreads, $msgThreadIds, $msgThreadIds_]);
        if($messageThreads!=null && $messageThreads->count()>0) {
            return response()->json([
                'success' => true,
                'messageThreads' => $messageThreads,
                'messageThreadDetails' => $msgThreadIds
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'You do not currently have any messages',
            ]);
        }
    }


    public function postGetProjectPaymentDetails(\Illuminate\Http\Request $request)
    {
        $all = $request->all();
        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);
        $projectId = $request->get('projectId');
        $transaction = \App\Models\Transaction::where('project_id', '=', $projectId)
            ->where('status', '=', 'PENDING')
            ->where('transaction_user_id', '=', $user->id)
            ->orderBy('created_at', 'DESC')
            ->first();
        if($transaction!=null)
        {
            $project = \App\Models\Project::where('id', '=', $projectId)
                ->where('status', '=', 'PENDING')
                ->where('created_by_user_id', '=', $user->id)
                ->first();
            return response()->json([
                'success' => true,
                'project' => $project,
                'transaction' => $transaction,
                'project' => $project
            ]);
        }
        else
        {
            return response()->json([
                'success' => true,
                'messages' => 'We could not find a pending transaction matching this project. You can not pay for this project. Contact our support staff',
            ]);
        }
    }

    public function postGetThreadMessages(\Illuminate\Http\Request $request)
    {
        $all = $request->all();
        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);
        $msgThreadIds = [];
        $msgThreadIds_ = [];
        //$projectId = $request->get('projectId');
        $messageThreadId = $request->get('messageThreadId');
        //dd($projectId);
        //dd($request);

        $hql = "Select m.message_body, m.id, sender.first_name as from_first_name, sender.last_name as from_last_name, ".
            " m.created_at as message_date_sent, receiver.first_name as to_first_name, receiver.last_name as to_last_name, ".
            " p.project_ref, p.status as projectStatus, p.title as title, m.project_id, m.sender_user_id, m.receipient_user_id ".
            " from messages m, users sender, users receiver, projects p where m.message_thread_id =  ".$messageThreadId.
            " AND m.sender_user_id = sender.id AND m.receipient_user_id = receiver.id AND ".
            " m.project_id = p.id AND m.deleted_at IS NULL ORDER BY m.created_at DESC";
        $messages = \DB::select($hql);

        $prjId = null;
        foreach($messages as $msg)
        {
            $prjId = $msg->project_id;
            $messg = \App\Models\Message::where('id', '=', $msg->id)->where('receipient_user_id', '=', $user->id)
                ->first();
            if($messg!=null)
            {
                $messg->receipient_read_yes = 1;
                $messg->save();
            }
        }

        /*$messages = \App\Models\Message::where('message_thread_id', '=', ($messageThreadId))
            ->leftJoin('users', 'messages.sender_user_id', '=', 'users.id')
            ->leftJoin('projects', 'messages.project_id', '=', 'projects.id')
            ->orderBy('messages.created_at', 'DESC')
            ->get();*/

        if($messages!=null && sizeof($messages)>0) {
            $project = \App\Models\Project::where('id', '=', $prjId)->first();
            return response()->json([
                'success' => true,
                'messages' => $messages,
                'project' => $project
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'We could not find any messages under this thread',
            ]);
        }
    }



    public function postGetUserDetailsByUserCode(\Illuminate\Http\Request $request)
    {
        $userCode = $request->get('userCode');
        $userDetails = \App\User::whereNull('deleted_at');
        if($userCode!=null)
        {
            $userDetails = $userDetails->where('user_code', '=', $userCode)->first();
            if($userDetails!=null && $userDetails->status!='Deactivated') {
                return response()->json([
                    'success' => true,
                    'userDetails' => $userDetails,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated. You can not update your profile until it has been reactivated',
            ]);
        }
        else
        {
            $jwt_token = JWTAuth::getToken();
            //return response()->json(['token' => $jwt_token]);
            $user = JWTAuth::toUser($jwt_token);
            $userDetails = $userDetails->where('id', '=', $user->id)->first();
            if($userDetails!=null && $userDetails->status!='Deactivated') {
                return response()->json([
                    'success' => true,
                    'userDetails' => $userDetails,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated. You can not update your profile until it has been reactivated',
            ]);
        }
    }



    public function postUpdateUserDetails(\Illuminate\Http\Request $request)
    {
        $all = $request->all();
        $userId = $request->get('userId');
        $rules = [
            'district_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            //'national_id' => 'required',
            'mobile_number' => 'required',
            'email_address' => 'required',
            'city' => 'required',
            'home_address' => 'required',
            'gender' => 'required'
        ];
        $messages = [
            'district_id.required' => 'Specify the district you are located',
            'first_name.required' => 'Provide your first name',
            'last_name.required' => 'Provide your last name',
            //'national_id.required' => 'Provide your National ID number',
            'mobile_number.required' => 'Provide your mobile number',
            'email_address.required' => 'Provide your email address',
            'city.required' => 'Specify the city you are located',
            'home_address.required' => 'Provide your permanent home address',
            'gender.required' => 'Specify your gender',
        ];

        if($userId==null) {
            $rules = $rules + [
                'password' => 'required',
                'confirm_password' => 'required|same:password'
            ];
            $messages = $messages + [
                'password.required' => 'A password must be provided',
                'confirm_password.required' => 'Your password provided and the confirmation password provided must match',
                'confirm_password.same' => 'Your password provided and the confirmation password provided must match'
            ];
        }
        $validator = \Validator::make($all, $rules, $messages);
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

            return response()->json([
                'success' => false,
                'message' => $str_error,
            ], 401);
        }
        $password = $request->get('password');
        $role_type = $request->get('role_type');



        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);

        $userDet = new \App\User();
        if($userId!=null) {
            $userDet = \App\User::where('id', '=', $user->id)->first();

            $userCheck = \App\User::where('mobile_number', '=', $all['mobile_number'])
                ->whereNotIn('id', [$userDet->id])->get();
            //dd($userCheck);
            if($userCheck!=null && $userCheck->count()>0)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'The mobile number you provided belongs to another person. Please provide a valid mobile number',
                ], 401);
            }
        }
        else{
            $userCheck = \App\User::where('mobile_number', '=', $all['mobile_number'])->get();
            if($userCheck!=null && $userCheck->count()>0)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'The mobile number you provided belongs to another person. Please provide a valid mobile number',
                ], 401);
            }

            $userDet->total_user_rating = 	0;
            $userDet->rating_count = 	0;
            $userDet->user_code = 		rand(100000000, 999999999);
            $userDet->password = 		\Hash::make($password);
            $userDet->status = 		'Active';
        }

        $userDet->username = $all['mobile_number'];
        $userDet->first_name = $all['first_name'];
        $userDet->last_name = $all['last_name'];
        $userDet->other_name = $all['other_name'];
        $userDet->mobile_number = $all['mobile_number'];
        $userDet->email_address = $all['email_address'];
        $userDet->gender = $all['gender'];
        $userDet->national_id = $all['national_id'];
        $userDet->district_id = $all['district_id'];
        $userDet->country_id = $all['country_id'];
        $userDet->profile = $all['profile'];
        $userDet->city = $all['city'];
        $userDet->home_address = $all['home_address'];

        $userDet->save();

        if($userId!=null) {
            return response()->json([
                'success' => true,
                'message' => 'Your profile has been updated successfully'
            ]);
        }
        else
        {
            if($userDet->save())
            {
                $projects = \App\Models\Project::whereIn('status', ['OPEN', 'COMPLETED'])->limit(10)->get();
                //dd($projects);
                $utilities = \App\Models\Utility::where('status', '=', 1)->first();
                $msg = "Your new HandyMade ".$role_type." credentials -\nUsername: " . $all['mobile_number'] . "\nActivation Code:" . $userDet->user_code . "\nPassword: " . $password;
                send_sms($all['mobile_number'], $msg, $utilities, null);
                send_mail('email.signup_artisan', $all['email_address'], $all['last_name'] . ' ' . $all['first_name'],
                    'Welcome To HandyMade - New '.$role_type.' Account Profile',
                    [
                        'last_name' => $all['last_name'],
                        'first_name' => $all['first_name'],
                        'username' => $all['mobile_number'],
                        'accessCode' => $$userDet->user_code,
                        'user' => $userDet,
                        'password' => $password,
                        'projects' => $projects
                    ]
                );
                return response()->json([
                    'success' => true,
                    'message' => 'Awesome, your new HandyMate account has been setup. Please log in to start enjoying our services'
                ]);
            }
        }
    }




    public function postBidProject(\Illuminate\Http\Request $request)
    {
        $all = $request->all();
        $rules = ['projectId' => 'required',
            'bidDetails' => 'required',
            'bidAmount' => 'required',
            'bidPeriod' => 'required',
            'bidPeriodType' => 'required'];

        $messages = [
            'projectId.required' => 'Select one project to bid on',
            'bidDetails.required' => 'Provide your bid details',
            'bidAmount.required' => 'Provide how much you are bidding for this project',
            'bidPeriod.required' => 'Specify how long it will take to complete this work',
            'bidPeriodType.required' => 'Specify how long in days or hours'
        ];
        $validator = \Validator::make($all, $rules, $messages);
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

            return response()->json([
                'success' => false,
                'message' => $str_error,
            ], 401);
        }

        $projectId = $request->get('projectId');
        $bidDetails = $request->get('bidDetails');
        $bidAmount = $request->get('bidAmount');
        $bidPeriod = $request->get('bidPeriod');
        $bidPeriodType = $request->get('bidPeriodType');
        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);

        if($user->role_type=='Artisan') {
            $project = \App\Models\Project::where('id', '=', $projectId)->first();
            if ($project == null)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Ensure you are bidding on a project'
                ]);
            }
            if($all['bidAmount'] <=
                $project->budget)
            {
                $projectBid = \App\Models\ProjectBid::where('bid_by_user_id', '=', $user->id)
                    ->where('status', '=', 'Valid')->first();
                $notification_contents = '<span class="label label-success">BID</span> New Bid for Project #'.strtoupper($project->project_ref).' updated';
                $message = "Your bid has been updated successfully.";
                if($projectBid==null)
                {
                    $projectBid = new \App\Models\ProjectBid();
                    $projectBid->bid_by_user_id = $user->id;
                    $projectBid->status = 'Valid';
                    $projectBid->project_id = $project->id;
                    $notification_contents = '<span class="label label-success">BID</span> Bid for Project #'.strtoupper($project->project_ref).' received';
                    $message = "Your bid has been submitted successfully.";
                    $bid_vat = 0.05*$all['bidAmount'];
                    $bid_service_charge = 0.05*$all['bidAmount'];
                    $projectBid->bid_details = $all['bidDetails'];
                    $projectBid->bid_amount = $all['bidAmount'];
                    $projectBid->bid_period = $all['bidPeriod'];
                    $projectBid->bid_period_type = $all['bidPeriodType'];
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


                        //$project = \App\Models\Project::where('id', '=', $projectId);
                        $project = $project->with('bids.bid_by_user')->with('created_by_user')
                            ->with('skills.skill')
                            ->with('district')
                            ->with('state')->first();
                        return response()->json([
                            'success' => true,
                            'project' => $project,
                            'message' => $message
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'We could not submit your bid. Review your bid and submit again'
                        ]);
                    }
                }
                else
                {
                    $notification_contents = '<span class="label label-success">BID</span> Bid for Project #'.strtoupper($project->project_ref).' received';
                    $message = "Your bid has been updated successfully.";
                    $bid_vat = 0.05*$all['bidAmount'];
                    $bid_service_charge = 0.05*$all['bidAmount'];
                    $projectBid->bid_details = $all['bidDetails'];
                    $projectBid->bid_amount = $all['bidAmount'];
                    $projectBid->bid_period = $all['bidPeriod'];
                    $projectBid->bid_period_type = $all['bidPeriodType'];
                    $projectBid->vat = $bid_vat;
                    $projectBid->service_charge = $bid_service_charge;
                    $projectBid->bid_code = rand(1000000000, 9999999999);
                    $projectBid->save();

                    $notif_code = strtolower(str_random(24));

                    $notification_url = '/notifications/'.$notif_code;
                    $receiver_user_id = $project->created_by_user_id;
                    $type = "BID_PLACED";
                    addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);


                    $project = \App\Models\Project::where('id', '=', $projectId);
                    $project = $project->with('bids.bid_by_user')->with('created_by_user')
                        ->with('skills.skill')
                        ->with('district')
                        ->with('state')->first();
                    return response()->json([
                        'success' => true,
                        'project' => $project,
                        'message' => $message
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Your bid must not exceed the budget for this project'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'You are not in Artisan mode. Switch to artisan mode to bid on a project'
            ]);
        }
    }


    public function postGetProject(\Illuminate\Http\Request $request)
    {
        $id = $request->get('id');
        $edit = $request->get('editTrue');
        $jwt_token = JWTAuth::getToken();
        $user = JWTAuth::toUser($jwt_token);
        $project = \App\Models\Project::where('id', '=', $id)
            ->with('skills')->first();
        if($project!=null)
        {
            if($edit!=null && $edit==1)
            {
                if($project->created_by_user_id!=$user->id)
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'You can only edit a project you created'
                    ]);
                }
            }
            return response()->json([
                'success' => true,
                'project' => $project
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Project not found. Please ensure your project still exists'
        ]);
    }



    public function postDeleteProject(\Illuminate\Http\Request $request)
    {
        $id = $request->get('bidId');
        $edit = $request->get('editTrue');
        $jwt_token = JWTAuth::getToken();
        $user = JWTAuth::toUser($jwt_token);
        $projectBid = \App\Models\ProjectBid::where('id', '=', $id)
            ->where('bid_by_user_id', '=', $user->id)->first();
        $projectId = null;
        if($projectBid!=null)
        {
            $projectId = $projectBid->project_id;
            $projectBid->delete();


            $project_ = \App\Models\Project::where('id', '=', $projectId)
                ->with('bids.bid_by_user')->with('created_by_user')
                ->with('skills.skill')
                ->with('district')
                ->with('state')->first();

            return response()->json([
                'success' => true,
                'project' => $project_,
                'message' => 'Your project bid has been canceled. You can still bid on this project later'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Project bid not found. Please ensure your project bid still exists'
        ]);
    }

    public function postCancelProject(\Illuminate\Http\Request $request)
    {
        $id = $request->get('projectId');
        $jwt_token = JWTAuth::getToken();
        $user = JWTAuth::toUser($jwt_token);
        $project = \App\Models\Project::where('id', '=', $id)
            ->where('created_by_user_id', '=', $user->id)->first();

        if($project!=null)
        {
            $project->status = 'CANCELED';
            $project->save();

            $projectBids = \App\Models\ProjectBid::where('project_id', '=', $project->id)->get();
            foreach($projectBids as $bid) {
                $notif_code = strtolower(str_random(8));
                $notification_contents = '<span class="label label-success">TKT</span> Project cancelation by support team';
                $notification_url = '/notifications/'.$notif_code;
                $receiver_user_id = $bid->bid_by_user_id;
                $type = "PROJECT_CANCELATION";
                addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
            }


            $project_ = \App\Models\Project::where('id', '=', $id)
                ->with('bids.bid_by_user')->with('created_by_user')
                ->with('skills.skill')
                ->with('district')
                ->with('state')->first();


            return response()->json([
                'success' => true,
                'project' => $project_,
                'message' => 'Your project has been canceled successfully. Please patronize us again'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Project bid not found. Please ensure your project bid still exists'
        ]);
    }


    public function postAssignProjectBinWin(\Illuminate\Http\Request $request)
    {
        try {

            $id = $request->get('bidId');
            $jwt_token = JWTAuth::getToken();
            $user = JWTAuth::toUser($jwt_token);
            $projectBid = \App\Models\ProjectBid::where('id', '=', $id)
                ->where('status', '=', 'VALID')->first();
            if ($projectBid != null) {
                $project = \App\Models\Project::where('id', '=', $projectBid->project_id)->first();
                if ($project->created_by_user_id == $user->id) {
                    $project->assigned_bidder_id = $projectBid->bid_by_user_id;
                    $project->status = 'ASSIGNED';
                    if ($project->save()) {
                        $projectBid->status = 'WON';
                        $projectBid->save();
                        \DB::commit();

                        $notif_code = strtolower(str_random(8));
                        $notification_contents = '<span class="label label-success">WON</span> Bid for project #' . strtoupper($project->project_ref) . ' Won! Please confirm acceptance';
                        $notification_url = '/notifications/' . $notif_code;
                        $receiver_user_id = $project->assigned_bidder_id;
                        $type = "BID_WON";
                        addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);


                        $project_ = \App\Models\Project::where('id', '=', $projectBid->project_id)
                            ->with('bids.bid_by_user')->with('created_by_user')
                            ->with('skills.skill')
                            ->with('district')
                            ->with('state')->first();


                        return response()->json([
                            'success' => true,
                            'project' => $project_,
                            'message' => 'Your project has been assigned to the artisan who owns the bid you selected'
                        ]);
                    }
                    else
                    {
                        \DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'Project not found. Please ensure your project still exists'
                        ]);
                    }
                }
                \DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'This project does not belong to you. You can only manage projects you posted by yourself'
                ]);
            }
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Project bid not found. Please ensure the project bid still exists'
            ]);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'We experienced issues assigning your project to your specified artisan'
            ]);
        }
    }


    public function postReAssignProjectBinWin(\Illuminate\Http\Request $request)
    {
        try {

            $id = $request->get('projectId');
            $jwt_token = JWTAuth::getToken();
            $user = JWTAuth::toUser($jwt_token);
            $projectBid = \App\Models\ProjectBid::where('project_id', '=', $id)
                ->where('status', '=', 'WON')->first();
            if ($projectBid != null) {
                $project = \App\Models\Project::where('id', '=', $id)->first();
                if ($project->created_by_user_id == $user->id) {

                    $receiver_user_id = $project->assigned_bidder_id;

                    $project->assigned_bidder_id = null;
                    $project->status = 'OPEN';
                    if ($project->save()) {
                        $projectBid->status = 'VALID';
                        $projectBid->save();
                        \DB::commit();

                        $notif_code = strtolower(str_random(8));
                        $notification_contents = '<span class="label label-success">CANCELED</span> Project #' . strtoupper($project->project_ref) . ' has been reopened by the project owner';
                        $notification_url = '/notifications/' . $notif_code;
                        $type = "REOPEN_PROJECT";
                        addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);


                        $project_ = \App\Models\Project::where('id', '=', $projectBid->project_id)
                            ->with('bids.bid_by_user')->with('created_by_user')
                            ->with('skills.skill')
                            ->with('district')
                            ->with('state')->first();


                        return response()->json([
                            'success' => true,
                            'project' => $project_,
                            'message' => 'Your project has been reopened to all artisans. You can assign your project when you are ready'
                        ]);
                    }
                    else
                    {
                        \DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'Project not found. Please ensure your project still exists'
                        ]);
                    }
                }
                \DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'This project does not belong to you. You can only manage projects you posted by yourself'
                ]);
            }
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Project bid not found. Please ensure the project bid still exists'
            ]);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'We experienced issues reassigning your project to your specified artisan'
            ]);
        }
    }



    public function postAcceptProjectBinWin(\Illuminate\Http\Request $request)
    {
        try {

            $id = $request->get('projectId');
            $jwt_token = JWTAuth::getToken();
            $user = JWTAuth::toUser($jwt_token);
            $projectBid = \App\Models\ProjectBid::where('project_id', '=', $id)
                ->where('status', '=', 'WON')
                ->where('bid_by_user_id', '=', $user->id)->first();
            if ($projectBid != null) {
                $project = \App\Models\Project::where('id', '=', $id)->first();
                if ($project!=null) {


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

                        $project_ = \App\Models\Project::where('id', '=', $projectBid->project_id)
                            ->with('bids.bid_by_user')->with('created_by_user')
                            ->with('skills.skill')
                            ->with('district')
                            ->with('state')->first();


                        return response()->json([
                            'success' => true,
                            'project' => $project_,
                            'message' => 'Your assigned project has officially started. Remember to regularly update your client on the progress of your project. On completion of your project, 
						visit the project page to indicate you have completed the project'
                        ]);
                    }
                    else
                    {
                        \DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'We experienced an issue confirming your acceptance'
                        ]);
                    }
                }
                \DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found. Please ensure your project still exists'
                ]);
            }
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Your project bid not found. Please ensure the project bid still exists'
            ]);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'We experienced issues confirming your acceptance to handle this project'
            ]);
        }
    }


    public function postMarkProjectCompleted(\Illuminate\Http\Request $request)
    {
        \DB::beginTransaction();
        try {

            $project = null;
            $id = $request->get('projectId');
            $jwt_token = JWTAuth::getToken();
            $user = JWTAuth::toUser($jwt_token);
            $projectBid = null;
            if ($user!=null && ($user->role_type == 'Private Client' || $user && $user->role_type == 'Corporate Client')) {
                $project = \App\Models\Project::where('id', '=', $id)
                    ->where('created_by_user_id', '=', $user->id)->first();
                $projectBid = \App\Models\ProjectBid::where('project_id', '=', $id)
                    ->where('status', '=', 'WON')
                    ->first();
            }
            else if ($user!=null && $user->role_type == 'Artisan')
            {
                $projectBid = \App\Models\ProjectBid::where('project_id', '=', $id)
                    ->where('bid_by_user_id', '=', $user->id)
                    ->where('status', '=', 'WON')
                    ->first();
                if($projectBid==null)
                {
                    \DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'We could not find your active bid on this project'
                    ]);
                }
                $project = \App\Models\Project::where('id', '=', $id)->first();
            }

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
                    \DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => $str_error
                    ]);
                }
                //dd(11);
                if($project->status=='IN PROGRESS')
                {
                    //dd(\Auth::user()->role_type);
                    if($user!=null && ($user->role_type=='Private Client' || $user->role_type=='Corporate Client') && $project->created_by_user_id==$user->id)
                    {
                        $project->worker_rating = $all['rating'];
                        $project->worker_review = utf8_encode($all['reviewClient']);
                        $project->status = 'COMPLETED';
                        $project->completed_by_worker = 1;
                        $project->paid_out_yes = 0;
                        if($project->save())
                        {
                            $user_ = \App\User::where('id', '=', $project->assigned_bidder_id)->first();
                            $userRating = $user_->total_user_rating==null ? 0 : $user_->total_user_rating;
                            $totalRatingCount = $user_->rating_count==null ? 0 : $user_->rating_count;
                            $userRating = $userRating * 5;
                            $userRating = $userRating + $all['rating'];
                            $totalRatingCount = $totalRatingCount + 1;
                            $userRating = $userRating/$totalRatingCount;
                            $user_->total_user_rating = $userRating;
                            $user_->rating_count = $totalRatingCount;
                            $user_->save();



                            $project->paid_out_yes = 1;
                            $project->save();


                            \DB::commit();
                            $project = \App\Models\Project::where('id', '=', $id)
                                ->with('bids.bid_by_user')->with('created_by_user')
                                ->with('skills.skill')
                                ->with('district')
                                ->with('assigned_bidder')
                                ->with('state')->first();

                            $receiver = null;

                            $trans_ref = strtoupper(str_random(16));
                            $params1 = [];
                            $params1['project_id'] = $project->id;
                            $currency = $project->project_currency;

                            $transaction = new \App\Models\Transaction();
                            $transaction->transaction_user_id = $user->id;
                            $transaction->reference_no = $trans_ref;
                            $transaction->total_amount = $projectBid->bid_amount;
                            $transaction->project_id = $project->id;
                            $transaction->payment_channel = 'MOBILE';
                            $transaction->status = 'SUCCESS';
                            $transaction->payment_type = 'BID PAYMENT';
                            $transaction->currency = $currency;
                            $transaction->request_data = json_encode($params1);
                            if($transaction->save())
                            {
                                $serviceAccountAmount = $projectBid->bid_amount * 0.05;
                                $creditAccountAmount = $projectBid->bid_amount - $serviceAccountAmount;
                                $wallet = \App\Models\Wallet::where('wallet_user_id', '=', $project->assigned_bidder_id)
                                    ->where('currency', '=', $currency)->first();
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

                                $otherProjects = \App\Models\Project::whereNotIn('id', [$project->id])
                                    ->where('status', '=', 'OPEN')
                                    ->with('state')->get();
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

                                return response()->json([
                                    'success' => true,
                                    'project' => $project,
                                    'message' => 'Your project has been marked as complete. The sum of '.$currency.''.number_format($projectBid->bid_amount, 2, '.', ',').' has been released to '.$projectBid->bid_by_user->first_name.'. Thank you for using HandyMade'
                                ]);
                            }
                            else
                            {
                                return response()->json([
                                    'success' => true,
                                    'project' => $project,
                                    'message' => 'Your project has been marked as complete. We could however not release the sum of '.$currency.''.number_format($projectBid->bid_amount, 2, '.', ',').' to '.$projectBid->bid_by_user->first_name
                                ]);
                            }



                        }
                        else
                        {
                            \DB::rollback();
                            return response()->json([
                                'success' => false,
                                'message' => 'Your project could not be marked as completed. Please try to mark the project as completed again'
                            ]);
                        }
                    }
                    else if($user!=null && $user->role_type=='Artisan' && $project->assigned_bidder_id==$user->id)
                    {

                        $project->client_rating = $all['rating'];
                        $project->client_review = utf8_encode($all['reviewClient']);
                        $project->completed_by_worker = 1;
                        if($project->save())
                        {
                            $user_ = \App\User::where('id', '=', $project->created_by_user_id)->first();
                            $userRating = $user_->total_user_rating==null ? 0 : $user_->total_user_rating;
                            $totalRatingCount = $user_->rating_count==null ? 0 : $user_->rating_count;
                            $userRating = $userRating * 5;
                            $userRating = $userRating + $all['rating'];
                            $totalRatingCount = $totalRatingCount + 1;
                            $userRating = $userRating/$totalRatingCount;
                            $user_->total_user_rating = $userRating;
                            $user_->rating_count = $totalRatingCount;
                            $user_->save();

                            $notif_code = strtolower(str_random(8));
                            $notification_contents = '<span class="label label-success">PRJ</span> Project #'.strtoupper($project->project_ref).' Completed! Please confirm completion';
                            $notification_url = '/notifications/'.$notif_code;
                            $receiver_user_id = $project->created_by_user_id;
                            $type = "WORKER_COMPLETION_CONFIRMATION";
                            addNewNotification($notification_contents, $notification_url, $receiver_user_id, $notif_code, $type, $project->id);
                            \DB::commit();
                            $project_ = \App\Models\Project::where('id', '=', $id)
                                ->with('bids.bid_by_user')->with('created_by_user')
                                ->with('skills.skill')
                                ->with('district')
                                ->with('state')->first();


                            return response()->json([
                                'success' => true,
                                'project' => $project_,
                                'datastr' => $all,
                                'message' => 'The project has been marked as completed. A notification has been sent to the client to release your payment. Thank you for patronizing out service'
                            ]);

                        }
                        else
                        {
                            \DB::rollback();
                            return response()->json([
                                'success' => false,
                                'message' => 'The project has been marked as completed. Please try to mark the project as completed again'
                            ]);
                        }
                    }
                    else
                    {
                        \DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'You can not mark this project as completed as you are not the project owner or you did not work on this project'
                        ]);
                    }
                }
                else
                {
                    \DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'You can not mark this project as completed until it has been assigned to a worker'
                    ]);
                }
            }
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'We could not find this project on our platform'
            ]);
        }
        catch(\Exception $e)
        {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'We experienced issues confirming your acceptance to handle this project'
            ]);
        }
    }





    public function postCreateNewProject(\Illuminate\Http\Request $request)
    {
        $all = $request->all();
        $rules = ['title' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'deliveryPeriod' => 'required',
            'biddingPeriodType' => 'required',
            'description' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'province' => 'required',
            'district' => 'required',
            'budget' => 'required',
            'currency' => 'required',
            'skill' => 'required'];

        $messages = [
            'title.required' => 'Specify the title of your project',
            'startDate.required' => 'Specify the start date of your project',
            'endDate.required' => 'Specify the end date of your project',
            'deliveryPeriod.required' => 'Specify the number of days/hours your project is open to bids',
            'biddingPeriodType.required' => 'Specify the project bid period type in days or hours',
            'description.required' => 'Provide a description of your project',
            'address.required' => 'Specify the address where this project is located',
            'city.required' => 'Specify the city this project is located',
            'country.required' => 'Specify the country where this project is located',
            'province.required' => 'Specify the province this project is located',
            'district.required' => 'Specify the district this project is located',
            'budget.required' => 'Specify your budget for this project',
            'currency.required' => 'Specify your budget currency for this project',
            'skill.required' => 'Specify a minimum of 1 and maximum of 12 skills for your project'
        ];
        $validator = \Validator::make($all, $rules, $messages);
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

            return response()->json([
                'success' => false,
                'message' => 'Invalid login credentials provided',
            ], 401);
        }

        $projectId = $request->get('projectId');
        $title = $request->get('title');
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $deliveryPeriod = $request->get('deliveryPeriod');
        $biddingPeriodType = $request->get('biddingPeriodType');
        $description = $request->get('description');
        $address = $request->get('address');
        $city = $request->get('city');
        $country = $request->get('country');
        $province = $request->get('province');
        $district = $request->get('district');
        $budget = $request->get('budget');
        $currency = $request->get('currency');
        $skills = $request->get('skill');
        $jwt_token = JWTAuth::getToken();
        //return response()->json(['token' => $jwt_token]);
        $user = JWTAuth::toUser($jwt_token);

        if($user->role_type=='Private Client' || $user->role_type=='Corporate Client') {

            \DB::beginTransaction();
            try {

                $project = new \App\Models\Project();
                $updatedAmountDiff = null;
                $oldBudget = null;
                $oldVat = null;
                $oldServiceCharge = null;
                $vat = null;
                $service_charge = null;
                $payExtra = true;

                if ($projectId != null) {
                    $project = \App\Models\Project::where('id', '=', $projectId)->first();
                    if ($project == null) {
                        return response()->json([
                            'success' => false,
                            'message' => 'We could not find your project which you wish to update'
                        ]);
                    }

                    if ($project->created_by_user_id != $user->id) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You can not update this project as you do not own this project'
                        ]);
                    }
                    $oldBudget = $project->budget;
                    $oldVat = $project->vat;
                    $oldServiceCharge = $project->service_charge;

                    if ($oldBudget > $budget) {
                        $vat = (5 * ($budget)) / 100;
                        $service_charge = (5 * ($budget)) / 100;
                        $vatDiff = $project->vat - $vat;
                        $serviceChargeDiff = $project->service_charge - $service_charge;
                        $budgetDiff = $project->budget - $budget;
                        $project->budget = $budget;
                        $project->vat = $vat;
                        $project->service_charge = $service_charge;

                        //FUND WALLET ON EXTRA
                        $payExtra = false;
                        $wallet = \App\Models\Wallet::where('wallet_user_id', '=', $user->id)->where('currency', '=', $currency)->first();
                        if ($wallet == null) {
                            $wallet = new \App\Models\Wallet();
                            $wallet->wallet_user_id = $user->id;
                            $wallet->wallet_number = strtoupper(str_random(8));
                            $wallet->currency = $currency;
                            $wallet->current_balance = 0.0;
                            $wallet->save();
                        }

                        $wt = new \App\Models\WalletTransaction();
                        $wt->wallet_id = $wallet->id;
                        $wt->amount = ($budgetDiff + $vatDiff + $serviceChargeDiff);
                        $wt->transaction_type = 'CREDIT';
                        $wt->transaction_ref = strtoupper(strtolower(str_random(16)));
                        $wt->paid_by_user_id = $user->id;
                        $wt->status = 'SUCCESS';
                        $wt->wallet_user_id = $user->id;
                        $wt->save();

                        $wallet->current_balance = $wallet->current_balance + ($budgetDiff + $vatDiff + $serviceChargeDiff);
                        $wallet->save();
                    } else if ($oldBudget < $budget) {
                        $vat = (5 * ($budget)) / 100;
                        $service_charge = (5 * ($budget)) / 100;
                        $project->budget = $budget;
                        $project->vat = $vat;
                        $project->service_charge = $service_charge;

                        //PAY EXTRA
                        $payExtra = true;
                        $budget = $budget - $oldBudget;
                        $vat = $vat - $oldVat;
                        $service_charge = $service_charge - $oldServiceCharge;
                    } else {

                        $project->budget = $budget;
                        $project->vat = $vat;
                        $project->service_charge = $service_charge;

                        //DONT PAY EXTRA
                        $payExtra = false;
                    }

                } else {
                    $project_ref = strtoupper(str_random(8));

                    $project->project_ref = $project_ref;
                    $vat = (5 * $budget) / 100;
                    $service_charge = (5 * $budget) / 100;


                    $project->budget = $budget;
                    $project->vat = $vat;
                    $project->service_charge = $service_charge;

                    //PAY BUDGET
                    $payExtra = true;
                }


                $project->title = $title;
                $project->status = 'PENDING';
                $project->limit_bidders = 0;
                $project->expected_start_date = $startDate;
                $project->expected_completion_date = $endDate;
                $project->bidding_period = $deliveryPeriod;
                $project->bidding_period_type = $biddingPeriodType;
                $project->project_location = $address;
                $project->city = $city;
                $project->country_located_id = explode('|||', $country)[0];
                $project->province_located_id = explode('|||', $province)[0];
                $project->district_located_id = explode('|||', $district)[0];
                $project->project_currency = $currency;
                $project->project_url = strtolower(str_slug($title, '-'));
                $project->description = utf8_encode(strip_tags($description));
                $project->created_by_user_id = $user->id;
                $project->open_to_discussion = 1;
                //dd($project);

                if ($projectId == null) {
                    if ($project->save()) {
                        $skills = json_decode($skills);


                        foreach ($skills as $skill) {
                            $projectSkill = new \App\Models\ProjectSkill();
                            $projectSkill->project_id = $project->id;
                            $projectSkill->skill_id = $skill->id;
                            $projectSkill->save();
                        }


                        if ($payExtra == true) {
                            $trans_ref = strtoupper(str_random(16));
                            $params = array();
                            $params['merchantId'] = MERCHANT_ID;
                            $params['deviceCode'] = DEVICE_CODE;
                            $params['serviceTypeId'] = '1981511018900';
                            $params['orderId'] = $trans_ref;
                            $params['payerName'] = $user->last_name . " " . $user->first_name . (isset($user->other_name) && $user->other_name != null ? $user->other_name : "");
                            $params['payerEmail'] = (isset($user->email_address) && $user->email_address != null ? $user->email_address : "");
                            $params['payerPhone'] = (isset($user->mobile_number) && $user->mobile_number != null ? $user->mobile_number : "");
                            $params['payerId'] = $user->mobile_number;
                            $params['nationalId'] = $user->national_id;

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
                            if ($projectId != null)
                                array_push($scope, 'UPGRADE PROJECT');
                            else
                                array_push($scope, 'NEW PROJECT');

                            $params['scope'] = join('|', $scope);
                            $params['description'] = $project->title;
                            $params['merchant_defined_data1'] = 'NEW_PROJECT_FEE';
                            $toHash = $params['merchantId'] . $params['deviceCode'] . $params['serviceTypeId'] .
                                $params['orderId'] . (number_format($totalAmount, 2, '.', '')) . $params['responseurl'] . PAYMENT_API_KEY;


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
                            $k = 1;
                            $params['merchant_defined_data'] = [];

                            foreach ($bankAccounts as $bankAccount) {
                                $arr_1['name'] = 'bank_code_' . $k++;
                                $arr_1['value'] = $bankAccount->bank->code;
                                array_push($params['merchant_defined_data'], $arr_1);
                            }
                            array_push($params['merchant_defined_data'], ['name' => 'bank_count', 'value' => $bankAccounts->count()]);
                            //dd($params);

                            $params1 = $params;
                            $transaction = new \App\Models\Transaction();
                            $transaction->transaction_user_id = $user->id;
                            $transaction->reference_no = $trans_ref;
                            $transaction->total_amount = $totalAmount;
                            $transaction->project_id = $project->id;
                            $transaction->payment_channel = 'WEB';
                            $transaction->status = 'PENDING';
                            $transaction->payment_type = 'NEW PROJECT';;
                            $transaction->currency = $currency;
                            $transaction->request_data = json_encode($params1);
                            if ($transaction->save()) {
                                \DB::commit();

                                //session()->remove('step_one_project_data');
                                //session()->remove('step_two_project_data');
                                //session()->remove('step_three_project_data');
                                //dd($password);

                                $project_ = \App\Models\Project::where('id', '=', $project->id)
                                    ->with('bids.bid_by_user')->with('created_by_user')
                                    ->with('skills.skill')
                                    ->with('district')
                                    ->with('state')->first();

                                return response()->json([
                                    'success' => true,
                                    'project' => $project_,
                                    'message' => 'Your project has been saved. Deposit the sum of ' .
                                        number_format($totalAmount, 2, '.', ',') . ' to activate your project. 
                                    We have sent you further instructions in an SMS'
                                ]);
                            } else {
                                //dd(12);
                                \DB::rollback();
                                return response()->json([
                                    'success' => false,
                                    'message' => 'We could not create your new project. Please review your project details and try again'
                                ]);
                            }
                        } else {
                            \DB::commit();

                            $project_ = \App\Models\Project::where('id', '=', $project->id)
                                ->with('bids.bid_by_user')->with('created_by_user')
                                ->with('skills.skill')
                                ->with('district')
                                ->with('state')->first();

                            return response()->json([
                                'success' => true,
                                'project' => $project_,
                                'message' => 'Your project has been saved.'
                            ]);
                        }
                    } else {
                        //dd(13);
                        \DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'We could not create your new project. Please review your project details and try again'
                        ]);
                    }

                } else {
                    $projectSkills = \App\Models\ProjectSkill::where('project_id', '=', $project->id)->get();
                    foreach ($projectSkills as $projectSkill) {
                        $projectSkill->delete();
                    }

                    $skills = json_decode($skills);
                    foreach ($skills as $skill) {
                        $projectSkill = new \App\Models\ProjectSkill();
                        $projectSkill->project_id = $project->id;
                        $projectSkill->skill_id = $skill->id;
                        $projectSkill->save();
                    }
                    $trans_ref = strtoupper(str_random(16));
                    $params = array();
                    $params['merchantId'] = MERCHANT_ID;
                    $params['deviceCode'] = DEVICE_CODE;
                    $params['serviceTypeId'] = '1981511018900';
                    $params['orderId'] = $trans_ref;
                    $params['payerName'] = $user->last_name . " " . $user->first_name . (isset($user->other_name) && $user->other_name != null ? $user->other_name : "");
                    $params['payerEmail'] = (isset($user->email_address) && $user->email_address != null ? $user->email_address : "");
                    $params['payerPhone'] = (isset($user->mobile_number) && $user->mobile_number != null ? $user->mobile_number : "");
                    $params['payerId'] = $user->mobile_number;
                    $params['nationalId'] = $user->national_id;

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
                    if ($projectId != null)
                        array_push($scope, 'UPGRADE PROJECT');
                    else
                        array_push($scope, 'NEW PROJECT');

                    $params['scope'] = join('|', $scope);
                    $params['description'] = $project->title;
                    $params['merchant_defined_data1'] = 'NEW_PROJECT_FEE';
                    $toHash = $params['merchantId'] . $params['deviceCode'] . $params['serviceTypeId'] .
                        $params['orderId'] . (number_format($totalAmount, 2, '.', '')) . $params['responseurl'] . PAYMENT_API_KEY;


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
                    $k = 1;
                    $params['merchant_defined_data'] = [];

                    foreach ($bankAccounts as $bankAccount) {
                        $arr_1['name'] = 'bank_code_' . $k++;
                        $arr_1['value'] = $bankAccount->bank->code;
                        array_push($params['merchant_defined_data'], $arr_1);
                    }
                    array_push($params['merchant_defined_data'], ['name' => 'bank_count', 'value' => $bankAccounts->count()]);
                    //dd($params);

                    $params1 = $params;
                    $transaction = new \App\Models\Transaction();
                    $transaction->transaction_user_id = $user->id;
                    $transaction->reference_no = $trans_ref;
                    $transaction->total_amount = $totalAmount;
                    $transaction->project_id = $project->id;
                    $transaction->payment_channel = 'WEB';
                    $transaction->status = 'PENDING';
                    $transaction->payment_type = 'NEW PROJECT';;
                    $transaction->currency = $currency;
                    $transaction->request_data = json_encode($params1);
                    if ($transaction->save()) {
                        \DB::commit();

                        //session()->remove('step_one_project_data');
                        //session()->remove('step_two_project_data');
                        //session()->remove('step_three_project_data');
                        //dd($password);
                        $project_ = \App\Models\Project::where('id', '=', $project->id)
                            ->with('bids.bid_by_user')->with('created_by_user')
                            ->with('skills.skill')
                            ->with('district')
                            ->with('state')->first();

                        return response()->json([
                            'success' => true,
                            'project' => $project_,
                            'message' => 'Your project has been saved. Deposit the sum of ' .
                                number_format($totalAmount, 2, '.', ',') . ' to activate your project. 
                            We have sent you further instructions in an SMS'
                        ]);
                    } else {
                        //dd(12);
                        \DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'We could not create your new project. Please review your project details and try again'
                        ]);
                    }

                }
            }
            catch(\Exception $e)
            {
                \DB::rollback();
                dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'We experienced a technical issue creating or updating your project. Please review your project details and try again'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'You are not in Client mode. Switch to client mode to create a new project or update an existing project'
            ]);
        }
    }
}

?>
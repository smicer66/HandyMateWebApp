<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>HOMER | WebApp admin theme</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="/vendor/fooTable/css/footable.core.min.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="/styles/style.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"/>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

</head>
<body class="fixed-navbar sidebar-scroll">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Header -->
@include('admin.header')

<!-- Navigation -->
@include('admin.side-menu')


<!-- Main Wrapper -->
<div id="wrapper">

    <div class="normalheader ">
        <div class="hpanel">
            <div class="panel-body">
                <a class="small-header-action" href="#">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>

                <div id="hbreadcrumb" class="pull-right m-t-lg">
                    <ol class="hbreadcrumb breadcrumb">
						@foreach($breadcrumbs as $breadcrumb)
					
							@if($breadcrumb['active']==1)
								<li class="active">
									<span class="breadcrumb-item active"><a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a></span>
								</li>
							@else
								<li>
									<span><a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a></span>
								</li>
							@endif
						@endforeach
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    {{$header}}
                </h2>
                <small>{!! $detail !!}</small>
            </div>
        </div>
    </div>


<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body">
                    <table id="example1" class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-filter=#filter>
                        <thead>
						@if($type=='My Projects')
                        <tr>
							<th>S/N</th>
                            <th data-toggle="true">Project</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th data-hide="all">Assigned To</th>
                            <th data-hide="all">Status</th>
                            <th data-hide="all">Budget</th>
                            <th data-hide="all">Action</th>
                        </tr>
						@elseif($type=='All Projects')
                        <tr>
							<th>S/N</th>
                            <th data-toggle="true">Project</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th data-hide="all">Assigned To</th>
                            <th data-hide="all">Status</th>
                            <th data-hide="all">Budget</th>
                            <th data-hide="all">Action</th>
                        </tr>
						@elseif($type=='My Transactions')
                        <tr>
							<th>S/N</th>
							<th>Date Paid</th>
                            <th data-toggle="true">Reference No</th>
                            <th>Transaction Ref</th>
                            <th>Payment Type</th>
                            <th data-hide="all">Paid By</th>
                            <th data-hide="all">Status</th>
                            <th data-hide="all">Amount</th>
                        </tr>
						@elseif($type=='Wallet Transactions')
                        <tr>
							<th>S/N</th>
							<th>Date Paid</th>
							@if(\Auth::user()->role_type=='Administrator')
								<th>Wallet Owner</th>
							@endif
                            <th>Transaction Ref</th>
                            <th data-hide="all">Paid/Deducted By</th>
                            <th>Transaction Type</th>
                            <th data-hide="all">Status</th>
                            <th data-hide="all" style="text-align: right !important;">Amount</th>
							@if(\Auth::user()->role_type=='Administrator')
								<th data-hide="all">Action</th>
							@endif
                        </tr>
						@elseif($type=='All Transactions')
                        <tr>
							<th>S/N</th>
							<th>Date Paid</th>
                            <th data-toggle="true">Reference No</th>
                            <th>Transaction Ref</th>
                            <th>Payment Type</th>
                            <th data-hide="all">Paid By</th>
                            <th data-hide="all">Status</th>
                            <th data-hide="all">Amount</th>
                        </tr>
						@elseif($type=='All Wallets')
                        <tr>
							<th>S/N</th>
							<th>Wallet Number</th>
                            <th data-toggle="true">Wallet Currency</th>
                            <th data-hide="all">Owner</th>
                            <th data-hide="all">Status</th>
							<th data-hide="all">Amount</th>
							@if(\Auth::user()->role_type=='Administrator')
								<th data-hide="all">Action</th>
							@endif
                        </tr>
						@elseif($type=='All Skills')
                        <tr>
							<th>S/N</th>
							<th>Skill Name</th>
                            <th data-toggle="true">Inspection Required</th>
                            <th data-hide="all">Projects URL</th>
                            <th data-hide="all">Action</th>
                        </tr>
						@elseif($type=='All Users')
                        <tr>
							<th>S/N</th>
							<th></th>
							<th>Full Name</th>
                            <th data-toggle="true">Role</th>
                            <th data-hide="all">Mobile Number</th>
                            <th data-hide="all">Email Address</th>
                            <th data-hide="all">Rating</th>
                            <th data-hide="all">Validated</th>
                            <th data-hide="all">Action</th>
                        </tr>
						@elseif($type=='All Messages')
                        <tr>
							<th>Project</th>
							<th>Message</th>
							<th>Action</th>
                        </tr>
						@elseif($type=='All Support Tickets')
                        <tr>
							<th>Ticket Code</th>
							<th>Ticket Subject</th>
							<th>Priority Level</th>
							<th>Status</th>
                            <th data-hide="all">Action</th>
                        </tr>
						@endif
                        </thead>
                        <tbody>
						<?php $x=1; $total_sum=0; ?>
						@foreach($listing as $listEntry)
							@if($type=='My Projects')
							<tr>
								<td>{{$x++}}.</td>
								<td><a href="/project-details/{{$listEntry->project_url}}">{{$listEntry->title}}</a><br>By {{$listEntry->created_by_user->first_name}} {{$listEntry->created_by_user->last_name}}</td>
								<td>{{$listEntry->city}}</td>
								<td>{{date('Y-m-d', strtotime($listEntry->expected_start_date))}}</td>
								<td>{{$listEntry->assigned_bidder!=null ? $listEntry->assigned_bidder->first_name." ".$listEntry->assigned_bidder->last_name : "N/A"}}</td>
								<td>{{ucwords(strtolower($listEntry->status))}}</td>
								<td>{{$listEntry->project_currency}}{{number_format($listEntry->budget, 2, '.', ',')}}</td>
								<td>
									<div class="btn-group">
										<button class="btn btn-sm btn-primary" type="button">Actions</button>
										<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul role="menu" class="dropdown-menu" style="padding-bottom: 0px !important; left: auto !important; right: 0 !important">
											<!--<li><a href="/taxes/generate-certificate-step-one/{{$listEntry->transaction_ref}}">Generate Certificates</a></li>-->
											@if(in_array($listEntry->status, ['PENDING', 'OPEN']))
												<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/project-manage/cancel/{{$listEntry->project_ref}}">Cancel Project</a></li>
											@endif
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/support-tickets/{{$listEntry->project_ref}}" >Support Ticket(s)</a></li>
											@if($listEntry->status=='PENDING')
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/support-tickets/{{$listEntry->project_ref}}">Complete Payment</a></li>
											@endif
										</ul>
									</div>
								</td>
							</tr>
							@elseif($type=='All Projects')
							<tr>
								<td>{{$x++}}.</td>
								<td><a href="/project-details/{{$listEntry->project_url}}">{{$listEntry->title}}</a><br>By {{$listEntry->created_by_user->first_name}} {{$listEntry->created_by_user->last_name}}</td>
								<td>{{$listEntry->city}}</td>
								<td>{{date('Y-m-d', strtotime($listEntry->expected_start_date))}}</td>
								<td>{{$listEntry->assigned_bidder!=null ? $listEntry->assigned_bidder->first_name." ".$listEntry->assigned_bidder->last_name : "N/A"}}</td>
								<td>{{ucwords(strtolower($listEntry->status))}}</td>
								<td>{{$listEntry->project_currency}}{{number_format($listEntry->budget, 2, '.', ',')}}</td>
								<td>
									<div class="btn-group">
										<button class="btn btn-sm btn-primary" type="button">Actions</button>
										<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul role="menu" class="dropdown-menu" style="padding-bottom: 0px !important; left: auto !important; right: 0 !important">
											<!--<li><a href="/taxes/generate-certificate-step-one/{{$listEntry->transaction_ref}}">Generate Certificates</a></li>-->
										@if(\Auth::user()->role_type=='Administrator')
											@if(!in_array($listEntry->status, ['CANCELED', 'ASSIGNED', 'COMPLETED', 'IN PROGRESS']))
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/project-manage/cancel/{{$listEntry->project_ref}}">Cancel Project</a></li>
											@endif
										@elseif(\Auth::user()->role_type=='Private Client')
											@if(!in_array($listEntry->status, ['CANCELED', 'ASSIGNED', 'COMPLETED', 'IN PROGRESS']))
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/project-manage/cancel/{{$listEntry->project_ref}}">Cancel Project</a></li>
											@endif
										@endif
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/support-tickets/{{$listEntry->project_ref}}">Support Ticket(s)</a></li>
											
										</ul>
									</div>
								</td>
							</tr>
							@elseif($type=='My Transactions')
							<tr>
								<td>{{$x++}}.</td>
								<td>{{date('Y-m-d', strtotime($listEntry->created_at))}}</td>
								<td>{{join('-', str_split($listEntry->reference_no, 4))}}</td>
								<td>{{$listEntry->transaction_ref==null ? 'N/A' : $listEntry->transaction_ref}}</td>
								<td>{{ucwords(strtolower($listEntry->payment_type))}}</td>
								<td>{{ucwords(strtolower($listEntry->paid_by_user->first_name))}} {{ucwords(strtolower($listEntry->paid_by_user->last_name))}}</td>
								<td>{{ucwords(strtolower($listEntry->status))}}</td>
								<td>{{$listEntry->project_currency}}{{number_format($listEntry->total_amount, 2, '.', ',')}}</td>
							</tr>
							@elseif($type=='Wallet Transactions')
							<tr>
								<td>{{$x++}}.</td>
								<td>{{date('Y-m-d', strtotime($listEntry->created_at))}}</td>
								@if(\Auth::user()->role_type=='Administrator')
								<td>{{$listEntry->wallet->created_by_user->first_name}} {{$listEntry->wallet->created_by_user->first_name}}</td>
								@endif
								<td>{{join('-', str_split($listEntry->transaction_ref, 4))}}</td>
								<td>{{ucwords(strtolower($listEntry->paid_by_user->first_name))}} {{ucwords(strtolower($listEntry->paid_by_user->last_name))}}</td>
								<td>{{ucwords(strtolower($listEntry->transaction_type))}}</td>
								<td>{{ucwords(strtolower($listEntry->status))}}</td>
								<td style="text-align: right !important;">{{$listEntry->wallet->currency}}{{number_format($listEntry->amount, 2, '.', ',')}}</td>
								@if(\Auth::user()->role_type=='Administrator')
								<td>
									<div class="btn-group">
										<button class="btn btn-sm btn-primary" type="button">Actions</button>
										<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul role="menu" class="dropdown-menu" style="padding-bottom: 0px !important; left: auto !important; right: 0 !important">
											@if($listEntry->transaction_type=='DEBIT' && $listEntry->status=='PENDING')
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/wallet-manage/confirm-payout/{{$listEntry->transaction_ref}}">Confirm Payout</a></li>
											@endif
										</ul>
									</div>
								</td>
								@endif
							</tr>
							@elseif($type=='All Transactions')
							<tr>
								<td>{{$x++}}.</td>
								<td>{{date('Y-m-d', strtotime($listEntry->created_at))}}</td>
								<td>{{join('-', str_split($listEntry->reference_no, 4))}}</td>
								<td>{{$listEntry->transaction_ref==null ? 'N/A' : $listEntry->transaction_ref}}</td>
								<td>{{ucwords(strtolower($listEntry->payment_type))}}</td>
								<td>{{ucwords(strtolower($listEntry->paid_by_user->first_name))}} {{ucwords(strtolower($listEntry->paid_by_user->last_name))}}</td>
								<td>{{ucwords(strtolower($listEntry->status))}}</td>
								<td>{{$listEntry->project_currency}}{{number_format($listEntry->total_amount, 2, '.', ',')}}</td>
							</tr>
							@elseif($type=='All Wallets')
							<tr>
								<td>{{$x++}}.</td>
								<td>{{$listEntry->wallet_number}}</td>
								<td>{{$listEntry->currency}}</td>
								<td>{{$listEntry->created_by_user->first_name}} {{$listEntry->created_by_user->last_name}}</td>
								<td>{{$listEntry->status}}</td>
								<td>{{number_format($listEntry->current_balance, 2, '.', ',')}}</td>
								@if(\Auth::user()->role_type=='Administrator')
									<td>
										<div class="btn-group">
											<button class="btn btn-sm btn-primary" type="button">Actions</button>
											<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul role="menu" class="dropdown-menu" style="padding-bottom: 0px !important; left: auto !important; right: 0 !important">
												@if($listEntry->status=='ACTIVE')
												<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/wallet-manage/disable/{{$listEntry->wallet_number}}">Disable Wallet</a></li>
												@elseif($listEntry->status=='DISABLED')
												<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/wallet-manage/enable/{{$listEntry->wallet_number}}">Enable Wallet</a></li>
												@endif
											</ul>
										</div>
									</td>
								@endif
							</tr>
							@elseif($type=='All Skills')
							<tr>
								<td>{{$x++}}.</td>
								<td>{{$listEntry->skill_name}}</td>
								<td>{{$listEntry->inspection_required==1 ? 'Yes' : 'No'}}</td>
								<td><a target="_project_skill" href="/all-projects/skill/{{$listEntry->skill_slug}}">Click</a></td>
								<td>
									<div class="btn-group">
										<button class="btn btn-sm btn-primary" type="button">Actions</button>
										<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul role="menu" class="dropdown-menu" style="padding-bottom: 0px !important; left: auto !important; right: 0 !important">
											<!--<li><a href="/taxes/generate-certificate-step-one/{{$listEntry->transaction_ref}}">Generate Certificates</a></li>-->
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/new-skill/{{$listEntry->id}}">Edit Skill</a></li>
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/delete-skill/{{$listEntry->id}}">Delete Skill</a></li>
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/all-projects/skill/{{$listEntry->project_ref}}">All Projects</a></li>
											
										</ul>
									</div>
								</td>
							</tr>
							@elseif($type=='All Users')
							<tr>
								<td>{{$x++}}.</td>
								<td><img src="/img/clients/{{$listEntry->default_image==null ? 'default.png' : $listEntry->default_image->file_name}}" height="30px" width="30px"></td>
								<td>{{$listEntry->first_name}} {{$listEntry->last_name}}</td>
								<td>{{$listEntry->role_type}}</td>
								<td>{{$listEntry->mobile_number}}</td>
								<td>{{$listEntry->email_address}}</td>
								<td>{{$listEntry->total_user_rating*$listEntry->rating_count/5}}</td>
								<td>{{in_array($listEntry->role_type, ['Artisan', 'Private Client']) ? ($listEntry->validated==1 ? 'Yes' : 'No') : 'N/A'}}</td>
								<td>
									<div class="btn-group">
										<button class="btn btn-sm btn-primary" type="button">Actions</button>
										<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul role="menu" class="dropdown-menu" style="padding-bottom: 0px !important; left: auto !important; right: 0 !important">
											@if(in_array($listEntry->role_type, ['Administrator']))
											<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/project-manage/cancel/{{$listEntry->project_ref}}">Edit Profile</a></li>
											@endif
											@if(in_array($listEntry->role_type, ['Artisan', 'Private Client']))
												@if($listEntry->validated!=1)
												<li style="padding: 10px; padding-left: 10px; border-bottom: #dedede 1px solid"><a style="color:#000 !important" href="/admin/user-manage/validate/{{$listEntry->user_code}}">Validate User</a></li>
												@endif
											@endif
											
										</ul>
									</div>
								</td>
							</tr>
							@elseif($type=='All Messages')
							<tr>
								<td>{{$listEntry->project->title}}</td>
								<td>{{substr($listEntry->last_message, 0 , 50)}}...</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" onclick="handleViewMessage('{{$listEntry->threadCode}}')"><!--data-toggle="modal" data-target="#messageModal"-->
										View Messages
									</button>
								</td>
							</tr>
							@elseif($type=='All Support Tickets')
							<tr>
								<td>{{join('-', str_split($listEntry->threadCode, 4))}}</td>
								<td>{{$listEntry->subject}}</td>
								<td>{{$listEntry->priority_level}}</td>
								<td>{{$listEntry->status}}</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" onclick="handleViewSupportMessage('{{$listEntry->threadCode}}')"><!--data-toggle="modal" data-target="#messageModal"-->
										View Support Messages
									</button>
								</td>
							</tr>
							@endif
							
						@endforeach
                        </tbody>
                        <tfoot>
                        <tr>
							@if($type=='My Projects')
                            <td colspan="8">
							@elseif($type=='All Projects')
                            <td colspan="9">
							@elseif($type=='My Transactions')
                            <td colspan="8">
							@elseif($type=='All Transactions')
                            <td colspan="8">
							@elseif($type=='All Wallets')
								@if(\Auth::user()->role_type=='Administrator')
								<td colspan="7">
								@else
								<td colspan="6">	
								@endif
							@endif
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
					
                </div>
            </div>

		</div>

    </div>
    </div>

	@if($type=='All Messages')
	<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-primary" style="background-color: #000 !important; color: #fff !important; color: #fff; padding: 10px 10px !important;">
					<h5 class="modal-title col-md-11" id="messageModalLabel" style="color: #fff !important">Messages: {{$messageFirst->project->title}}</h5>
					<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close" style="opacity: 0.9 !important">
					  <span aria-hidden="true" class="pull-right" style="color: #fff !important">&times;</span>
					</button>
		
					<div class="col-md-12">
						<br><label>Conversation between:</label>
						<span id="messageConversers">{{join(', ', $messageUsers)}}</span>
					</div>
				</div>
				<div class="modal-body col-md-12" style="display: inline-block; padding-left: 0px !important; padding-right: 0px !important">
					<div class="row col-md-12" style="margin-left: 0px; padding-bottom: 15px !Important; padding-right: 0px !important; padding-left: 0px !important">

						<div class="col-md-12" style="padding: 0px !important;" id="all_messages">
							
								@foreach($messages  as $message)
								<div class="form-group col-md-12" style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important; border-bottom: 1px #000 solid">
									<div class="form-group col-md-1" style="border-radius: 5px !important; ">
										<img src="/img/clients/{{$message->created_by_user!=null && $message->created_by_user->default_image!=null ? $message->created_by_user->default_image->file_name : 'default.png'}}" style="height: 30px !important; width: 30px !important; "><br>
										
									</div>
									<div class="form-group col-md-10 pull-right" style="background-color: #f4f4f4 !important; padding-top: 5px; padding-bottom: 5px; border-radius: 5px !important; margin-left: 5px !important;">
										{!! $message->message_body !!}<br>
										<small><i><input type="checkbox" name="messages[]" value="{{$message->message_code}}"> By {{$message->created_by_user->first_name}} {{$message->created_by_user->last_name}}</i></small>
									</div>
								</div>
								@endforeach
						</div>
					</div>
				</div>
				
				<div class="modal-footer">
					@if(\Auth::user()->role_type=='Administrator')
					<form action="/project-manage/delete-message" method="post">
						<button type="submit" class="btn btn-success pull-right">Delete Message(s)</button>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endif
	@if($type=='All Support Tickets')
	<div class="modal fade" id="supportMessageModal" tabindex="-1" role="dialog" aria-labelledby="supportMessageModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-primary" style="background-color: #000 !important; color: #fff !important; color: #fff; padding: 10px 10px !important;">
					<h5 class="modal-title col-md-11" id="supportMessageModalLabel" style="color: #fff !important; font-size: 20px !Important; font-weight: bold">Ticket: #{{join('-', str_split($messageFirst->threadCode, 4))}}</h5>
					<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true" class="pull-right">&times;</span>
					</button>
				</div>
				<div class="modal-body col-md-12" style="display: inline-block; padding-left: 0px !important; padding-right: 0px !important">
					<div class="row col-md-12" style="margin-left: 0px; padding-bottom: 15px !Important; padding-right: 0px !important; padding-left: 0px !important">
						<div class="col-md-12" style="">
							<div class="form-group">
								<label>Project:</label>
								<span id="supportConversers">{{$project->title}}</span>
							</div>
						</div>

						<div class="col-md-12" style="padding: 0px !important;" id="all_support_messages">
							
								@foreach($messages  as $message)
								<div class="form-group col-md-12" style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important; border-bottom: 1px #000 solid">
									<div class="form-group col-md-1" style="border-radius: 5px !important; ">
										<img src="/img/clients/{{$message->created_by_user!=null && $message->created_by_user->default_image!=null ? $message->created_by_user->default_image->file_name : 'default.png'}}" style="height: 30px !important; width: 30px !important; "><br>
										
									</div>
									<div class="form-group col-md-10 pull-right" style="background-color: #f4f4f4 !important; padding-top: 5px; padding-bottom: 5px; border-radius: 5px !important; margin-left: 5px !important;">
										{!! $message->message_body !!}<br>
										<div class="col col-md-7" style="padding-left: 0px !important;">
											<small><i>By {{$message->created_by_user->first_name}} {{$message->created_by_user->last_name}}<br>
											Posted on {{date('d M Y', strtotime($message->created_at))}}
											</small>
										</div>
										<div class="col col-md-5">
											<button type="button" onclick="handleDisplayCompose('{{$message->message_code}}', '{{$message->created_by_user->id}}')" class="btn btn-sm btn-primary pull-right">[Reply]</button></i>
										</div>
										<div class="col col-md-12 composemessages" id="compose" style="display:none">
											<form action="/project/support-ticket/reply-message" method="post">
												<textarea class="col-md-12" class="form-control" name="reply"></textarea>
												<button type="submit" class="btn btn-primary pull-right">Send Response</button>
												<input type="hidden" id="selectedThreadCode" value="" name="selectedThreadCode">
												<input type="hidden" id="selectedReceipientId" value="" name="receipient_id">
											</form>
										</div>
									</div>
								</div>
								@endforeach
						</div>
					</div>
				</div>
				<div class="modal-footer">
					
				</div>
			</div>
		</div>
	</div>
	@endif
	
	

    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">

        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
            </button>
            <div>
                <span class="font-bold no-margins"> Analytics </span>
                <br>
                <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            </div>
            <div class="row m-t-sm m-b-sm">
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">300,102</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">280,200</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
            </div>
            <div class="progress m-t-xs full progress-small">
                <div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"
                     class=" progress-bar progress-bar-success">
                    <span class="sr-only">35% Complete (success)</span>
                </div>
            </div>
        </div>
        <div class="p-m bg-light border-bottom border-top">
            <span class="font-bold no-margins"> Social talks </span>
            <br>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            <div class="m-t-md">
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a1.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">John Novak</span>
                            <small class="text-muted">21.03.2015</small>
                            <div class="social-content small">
                                Injected humour, or randomised words which don't look even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a3.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Mark Smith</span>
                            <small class="text-muted">14.04.2015</small>
                            <div class="social-content">
                                Many desktop publishing packages and web page editors.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a4.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Marica Morgan</span>
                            <small class="text-muted">21.03.2015</small>

                            <div class="social-content">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-m">
            <span class="font-bold no-margins"> Sales in last week </span>
            <div class="m-t-xs">
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$170,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$580,90 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$620,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$140,70 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
            </div>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.
                Many desktop publishing packages and web page editors.
            </small>
        </div>

    </div>

    <!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2015-2020
    </footer>

</div>



<!--<script type="text/javascript" src="/js/jquery.min.js"></script>-->
 
<script src="/vendor/jquery/dist/jquery.min.js"></script>
<script src="/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="/vendor/iCheck/icheck.min.js"></script>
<script src="/vendor/sparkline/index.js"></script>
<!--<script src="/vendor/fooTable/dist/footable.all.min.js"></script>-->

<!-- App scripts -->
<script src="/scripts/homer.js"></script>


<script>

    /*$(function () {

        // Initialize Example 1
        $('#example1').footable();


    });*/

</script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="/js/bootstrap-notify.js"></script>

<script>
    $(function () {
        $('#example1').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"dom": '<"top"Bf>rt<"bottom"lip><"clear">',
			"buttons": [
				{
					extend: 'pdfHtml5',
					text: 'Export List To PDF',
					className: 'btn btn-primary',
					@if($type=='Transaction Reports')
                    exportOptions: {
                        columns: [0, 1,2,3,4,5,6,7,9]
                    },
                    @endif
                    orientation: 'landscape',
                    pageSize: 'A4',
                    messageTop: "{{$detail}}"
				},
				{
					extend: 'excelHtml5',
					text: 'Export List To Excel',
					className: 'btn btn-primary',
					@if($type=='Transaction Reports')
                    exportOptions: {
                        columns: [0, 1,2,3,4,5,6,7,9]
                    },
                    @endif
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    messageTop: "{{$detail}}"
				}
			],
			"paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "sort": {},
            "info": true,
            "autoWidth": false,
            language: {
                processing:     "Loading data...",
                search:         "Search:",
                lengthMenu:     "Show _MENU_ entries",
                info:           "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty:      "Showing 0 to 0 of 0 entries",
                infoFiltered:   "(filtered from _MAX_ total entries)",
                infoPostFix:    "",
                loadingRecords: "Loading Records...",
                zeroRecords:    "No matching records found",
                emptyTable:     "No Data In Table",
                paginate: {
                    first:      "First",
                    previous:   "Last",
                    next:       "Next",
                    last:       "Previous"
                },
                aria: {
                    sortAscending:  ": Sorted In Ascending Order",
                    sortDescending: ": Sorted In Descending Order"
                }
            }
        });
    });
	
	@if($type=='All Messages')
	function handleViewMessage(threadCode)
	{
		var allMessages = $("#all_messages");
		var messageConversers = $("#messageConversers");
		
		allMessages.html('--Loading--');
		$.ajax({
			url: '/get_thread_messages_by_code/' + threadCode,
			dataType: 'json',
			success: function (resp) {
				if (resp.status === 1) {
					var allMessages_ = [];
					$.each(resp.data.messages, function (k, v) {
						console.log(k);
						console.log(v);
						var v1 = '<div class="form-group col-md-12" style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important; border-bottom: 1px #000 solid">' +
							'<div class="form-group col-md-1" style="border-radius: 5px !important; ">' +
								'<img src="/img/clients/' +  (v.sender_img) + '" style="height: 30px !important; width: 30px !important; "><br>' +
							'</div>' +
							'<div class="form-group col-md-10 pull-right" style="padding-top: 5px; padding-bottom: 5px; background-color: #f4f4f4 !important; border-radius: 5px !important; margin-left: 5px !important;">' +
								v.message + '<br>' +
								'<small><i>';
						@if(\Auth::user()->role_type=='Administrator')
							v1 = v1 + '<input type="checkbox" name="messages[]" value="'+ v.message_code +'"> ';
						@endif
						v1 = v1 + ' By ' + v.sender_name + 
								'Posted on ' + v.date_sent +
								'</i></small>' +
							'</div>' +
						'</div>';
						messageConversers.html(resp.data.conversers);
						allMessages_.push(v1);
					});
					console.log(allMessages_.join(""));
					allMessages.html(allMessages_.join(""));
				}
			},
			complete: function () {
				//$("#all_messages").removeClass('disabled');
				$('#messageModal').modal('toggle');
			}
		});
	}
	@endif
	
	@if($type=='All Support Tickets')
	function handleDisplayCompose(threadCode, receipient_id)
	{
		document.getElementById('selectedThreadCode').value = threadCode;
		document.getElementById('selectedReceipientId').value = receipient_id;
		document.getElementById('compose').style.display = 'block';
	}
	
	function handleViewSupportMessage(threadCode)
	{
		var allMessages = $("#all_support_messages");
		var supportConversers = $("#supportConversers");
		var supportMessageModalLabel = $("#supportMessageModalLabel");
		allMessages.html('--Loading--');
		$.ajax({
			url: '/get_support_messages_by_code/' + threadCode,
			dataType: 'json',
			success: function (resp) {
				if (resp.status === 1) {
					var allMessages_ = [];
					$.each(resp.data.messages, function (k, v) {
						console.log(k);
						console.log(v);
						var key = "'" + threadCode + "'," + v.sender_id;
						console.log(key);
						var v1 = '<div class="form-group col-md-12" style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important; border-bottom: 1px #000 solid">' +
							'<div class="form-group col-md-1" style="border-radius: 5px !important; ">' +
								'<img src="/img/clients/' +  (v.sender_img) + '" style="height: 30px !important; width: 30px !important; "><br>' +
							'</div>' +
							'<div class="form-group col-md-10 pull-right" style="padding-top: 5px; padding-bottom: 5px; background-color: #f4f4f4 !important; border-radius: 5px !important; margin-left: 5px !important;';
						
						var senderId = <?php echo \Auth::user()->id; ?>;
						if(senderId!=v.sender_id)
						{
							v1 = v1 + 'text-align: right !important;">';
						}
						else
						{
							v1 = v1 + 'text-align: left !important;">';
						}
						v1 = v1 + '<div class="col col-md-12" style="padding-left: 0px !important;">';
						v1 = v1 + v.message + '</div>' +
								'<div class="col col-md-10" style="padding-left: 0px !important;">' +
									'<small><i>By ' + v.sender_name + '<br>' +
									'Posted on ' + v.date_sent +
									'</small>' +
								'</div>';
						if(senderId!=v.sender_id)
						{
								v1 = v1 + '<div class="col col-md-2">' +
									'<button onclick="handleDisplayCompose('+ key +')" class="btn btn-sm btn-primary pull-right" type="button" >[Reply]</button></i>' +
								'</div>';
						}
						v1 = v1 + '</div>' +
						'</div>';
						allMessages_.push(v1);
					});
					v1 =  '<div class="col col-md-12 composemessages" id="compose" style="display:none">' +
							'<form action="/support-ticket/reply-message" method="post">' +
								'<textarea class="col-md-12" class="form-control" name="reply"></textarea>' +
								'<button type="submit" class="btn btn-primary pull-right">Send Response</button>' +
								'<input type="hidden" id="selectedThreadCode" value="" name="selectedThreadCode">' + 
								'<input type="hidden" id="selectedReceipientId" value="" name="receipient_id">' + 
							'</form>' +
						'</div>';
					allMessages_.push(v1);
					console.log(allMessages_.join(""));
					allMessages.html(allMessages_.join(""));
					supportConversers.html(resp.data.project);
					supportMessageModalLabel.html(resp.data.ticketId);
				}
			},
			complete: function () {
				//$("#all_messages").removeClass('disabled');
				$('#supportMessageModal').modal('toggle');
			}
		});
	}
	@endif
</script>
@include('scripts')

</body>
</html>
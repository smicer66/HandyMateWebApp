<!doctype html>

<html class="no-js" lang="zxx">

    
<!-- Mirrored from www.innovationplans.com/idesign/daniels/main.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Sep 2019 13:15:23 GMT -->
<head>


    	<!-- metas -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       	<meta name="description" content="Daniels is a responsive creative template">
		<meta name="keywords" content="portfolio, personal, corporate, business, parallax, creative, agency">

		<!-- title -->
		<title>HandyMade - Your Assured Stop For All Things Artisan</title>

		<!-- favicon -->
        <link href="img/favicon.ico" rel="icon" type="image/png">

        <!-- bootstrap css -->
		<link rel="stylesheet" href="/css/bootstrap.min.css">

		<!-- google fonts -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800" rel="stylesheet">

		<!-- owl carousel CSS -->
		<link rel="stylesheet" href="/css/owl.carousel.min.css">
		<link rel="stylesheet" href="/css/owl.theme.default.min.css">

		<!-- magnific-popup CSS -->
		<link rel="stylesheet" href="/css/magnific-popup.css">

		<!-- animate.min CSS -->
		<link rel="stylesheet" href="/css/animate.min.css">

		<!-- Font Icon Core CSS -->
		<link rel="stylesheet" href="/css/font-awesome.min.css">
		<link rel="stylesheet" href="/css/et-line.css">

		<!-- Core Style Css -->
        <link rel="stylesheet" href="/css/style.css?x=12">

        <!--[if lt IE 9]-->
		<script src="/js/html5shiv.min.js"></script>
		<!--[endif]-->
		<link href="https://fonts.googleapis.com/css2?family=Muli:wght@200;300;600&display=swap" rel="stylesheet">
		<style>
		.dropdown-toggle{
			background-color: transparent;
		}
		
		body{
			font-size: 12px !important;
			color: #000000 !important;
			line-height: 1.8em !important;
		}
		
		.fontsize13{
			font-size: 13px !important;
		}
		
		.btn{
			font-size: 12px !important;
		}
		.modal-dialog{
			overflow-y: initial !important
		}
		.modal-body{
			max-height: calc(100vh - 200px);
			overflow-y: auto;
		}
		</style>
    </head>
    
    <body>

    	<!-- ====== Preloader ======  -->
	    <div class="loading">
			<div class="load-circle">
			</div>
		</div>
		<!-- ======End Preloader ======  -->

		<!-- ====== Navgition ======  -->
		@include('nav')
		<!-- ====== End Navgition ======  -->
		
		<!--====== Contact ======-->
		<section class="contact section-padding" data-scroll-index="6">
			<div class="container">
				<div class="row">
				
					<!-- section heading -->
					<div class="section-head" style="text-align: left !important; margin-bottom:40px">
						<h3>Job #{{join('-', str_split($project->project_ref, 4))}}</h3>
						<h3>{{$project->title}}</h3>
					</div>

					<div class="col-md-12">
						<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
							<u style="float: left !important;"><h5 style="padding-bottom: 15px !important;"><strong style="text-decoration: underline !important">Job Details</strong></h5></u>
							@if(\Auth::user() && \Auth::user()->id == $project->created_by_user_id)
								<a style="float: right !important; margin-left: 3px !important" href="/new-project-step-one" class="btn btn-primary btn-sm pull-right" style=""><i class="fa fa-plus"></i> New Project</a>
								@if(in_array($project->status, ['OPEN', 'COMPLETED']))
								<a style="float: right !important; margin-left: 3px !important" href="/new-project-step-one/{{$project->project_url}}" class="btn btn-primary btn-sm pull-right" style=""><i class="fa fa-life-ring"></i> Edit Project</a>
								@endif
							@endif
						</div>
						<!-- contact info -->
						<!-- contact form -->
						
						
						<div class="messages"></div>

						<div class="controls" style="clear:both">

							<div class="row" style="padding-bottom: 15px !Important">
								<div class="col-md-2" style="overflow:hidden !important; max-height: 220px !important;">
									<div class="form-group" style="text-align:center">
										@if(isset($project->created_by_user->default_image))
											<img src="/img/clients/{{$project->created_by_user->default_image->file_name}}"><br>
										@else
											<img src="/images/default_male.png"><br>
										@endif
										<small><span>Posted By</span> <br>
										<strong>{{$project->created_by_user->first_name}} {{$project->created_by_user->last_name}}</strong></small>
									</div>
								</div>

								<div class="col-md-10" style="padding-top: 0px">
									<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
										<div class="col-md-4">
											<div class="form-group">
												<label>Number of Projects:</label>
												<span style="float:right !important">{{$allProjects}}</span>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label>Rating:</label>
												<span style="float:right !important">{{$project->created_by_user->total_user_rating}}/5</span>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label>Projects Completed:</label>
												<span style="float:right !important">{{$completedProjects}}</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Current Open Projects:</label>
												<span style="float:right !important">{{$openProjects}}</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Projects Being Handled:</label>
												<span style="float:right !important">{{$assignedProjects}}</span>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label>Open Bidding:</label>
												@if($project->limit_bidders==0)
													<span style="float:right !important">No</span>
												@else
													<span style="float:right !important">Yes</span>
												@endif
											</div>
										</div>
										
										
										<div class="col-md-4">
											<div class="form-group">
												<label>Country Located:</label>
												<span style="float:right !important">{{$project->country->name}}</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Province:</label>
												<span style="float:right !important">{{$project->state->name}}</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>District:</label>
												<span style="float:right !important">{{$project->district->lga_name}}</span>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
											
												<label>Project Status:</label>
												<span style="float:right !important">
												@if($project->status=='OPEN')
													Open to Bidding
												@elseif($project->status=='PENDING')
													Not Open
												@elseif($project->status=='ASSIGNED')
													Assigned To A Worker
												@elseif($project->status=='COMPLETED')
													Completed
												@elseif($project->status=='IN PROGRESS')
													@if($project->completed_by_worker==1)
														Completed By Worker
													@else
														In Progress
													@endif
												@elseif($project->status=='CANCELED')
													Canceled By Client
												@endif
												</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Discuss Project:</label>
												<span style="float:right !important">
												@if($project->open_to_discussion==1)
													Yes
												@else
													No
												@endif
												</span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Bid(s):</label>
												<span style="float:right !important">{{$project->bids==null ? 0 : sizeof($project->bids)}}</span>
											</div>
										</div>
										@if(in_array($project->status, ['COMPLETED', 'IN PROGRESS']) && isset($winningBid) && $winningBid!=null)
										<div class="col-md-4">
											<div class="form-group">
												<label>Winning Bid Amount:</label>
												<span style="float:right !important">{{$project->project_currency}}{{number_format($winningBid->bid_amount, 2, '.', ',')}}</span>
											</div>
										</div>
										@endif
									</div>
									<div class="col-md-12"  style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">

										@if($project->status=='COMPLETED' && \Auth::user() &&  \Auth::user()->role_type=='Private Client' && \Auth::user()->id==$project->created_by_user_id && $project->paid_out_yes==0)
										<!--<a href="" class="btn btn-success btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-certificate"></i> Release Funds</a>-->
										<button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#fundsReleaseModal">
											<i class="fa fa-certificate"></i> Release Funds
										</button>
										@endif
										
										@if(!in_array($project->status, ['PENDING']))
										<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#projectBidsModal" style="margin-right: 3px !important; margin-bottom: 3px !important;">
											<i class="fa fa-sticky-note-o"></i> View Bids For This Project ({{$project->bids==null ? 0 : sizeof($project->bids)}})
										</button>
										@endif
										
										@if($project->status=='IN PROGRESS' && \Auth::user() &&  ((\Auth::user()->role_type=='Private Client' && \Auth::user()->id==$project->created_by_user_id && $project->worker_rating==null) || (\Auth::user()->role_type=='Artisan' && \Auth::user()->id==$project->assigned_bidder_id && $project->completed_by_worker==0)))
										<!--<a href="" class="btn btn-success btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-certificate"></i> Mark As Completed</a>-->
										<button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#markAsCompletedModal" style="margin-right: 3px !important; margin-bottom: 3px !important;">
											<i class="fa fa-certificate"></i> Mark As Completed
										</button>
										@endif
										
										
										
										
										
										@if($displayMessaging==true)
										<!--<a href="" class="btn btn-primary btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-envelope"></i> Message Joshua About This Project</a>-->
											@if(\Auth::user() && \Auth::user()->role_type=='Private Client' && \Auth::user()->id==$project->created_by_user_id && $winningBid!=null)
												<button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#messageSenderModal" style="margin-right: 3px !important; margin-bottom: 3px !important;">
													<i class="fa fa-envelope"></i> Message {{$winningBid->bid_by_user->first_name}} About This Project
												</button>
											@else
												@if(\Auth::user() && \Auth::user()->role_type!='Private Client')
												<button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#messageSenderModal" style="margin-right: 3px !important; margin-bottom: 3px !important;">
													<i class="fa fa-envelope"></i> Message {{$project->created_by_user->first_name}} About This Project
												</button>
												@endif
											@endif
										@endif
										
										@if(!in_array($project->id, $userFavs))
											@if(\Auth::user() && \Auth::user()->id!=$project->created_by_user_id)
												@if(in_array($project->created_by_user_id, (\Auth::user()->person_favorites==null ? [] : json_decode(\Auth::user()->person_favorites, TRUE))))
													<a href="/remove-person-from-favorites/{{$project->created_by_user->user_code}}" class="btn btn-danger btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-trash"></i> Remove {{ucwords($project->created_by_user->first_name)}} From Favorites</a>
												@else
													<a href="/add-person-to-favorites/{{$project->created_by_user->user_code}}" class="btn btn-success btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-heart"></i> Add {{ucwords($project->created_by_user->first_name)}} To Favorites</a>
												@endif
											@endif
										@endif
										
										@if($project->status=='ASSIGNED' && ($project->assigned_bidder_id==\Auth::user()->id || $project->created_by_user_id==\Auth::user()->id))
										<!--<a href="" class="btn btn-warning btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-life-ring"></i> Complain About Project</a>-->
										<button type="button" class="btn btn-warning btn-sm pull-right" data-toggle="modal" data-target="#supportMessageSenderModal" style="margin-right: 3px !important; margin-bottom: 3px !important;">
											<i class="fa fa-life-ring"></i> New Support Thread
										</button>
										@endif
										
										@if(in_array($project->status, ['OPEN']) && \Auth::user() && \Auth::user()->role_type=='Private Client' && \Auth::user()->id==$project->created_by_user_id && !in_array($project->status, ['CANCELED', 'ASSIGNED']))
										<!--<a href="" class="btn btn-danger btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-heart"></i> Cancel Project</a>-->
										<button type="button" class="btn btn-danger btn-sm pull-right" data-toggle="modal" data-target="#cancelProjectModal" style="margin-right: 3px !important; margin-bottom: 3px !important;">
											<i class="fa fa-trash"></i> Cancel Project
										</button>
										@endif
									</div>
									
								</div>
							</div>
							
							
							<div class="row" style="padding-bottom: 15px !Important">
								<div class="col-md-8">
									<div class="form-group col-md-12" style="border-bottom: 1px solid #dedede">
										<h5><u><b style="text-decoration: underline !important;">Project Description:</b></u></h5>
										<div class="col-md-12" style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px">
											<p>{!!nl2br($project->description)!!}</p>
										</div>
										<br>
										
										
										@if(\Auth::user() && in_array($project->id, $projectWatchlist))
											<a href="/remove-project-from-watchlist/{{$project->project_url}}" class="btn btn-danger btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-eye-slash"></i> Remove From Watch List</a>
										@else
											@if(\Auth::user())
											<a href="/add-project-to-watchlist/{{$project->project_url}}" class="btn btn-primary btn-sm pull-right" style="margin-right: 3px !important; margin-bottom: 3px !important;"><i class="fa fa-eye"></i> Add to Watch List</a>
											@endif
										@endif

										<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
											&nbsp;
										</div>
										<!--<h5><u><b style="text-decoration: underline !important;">Attached Images:</b></u></h5>
										<div class="col-md-12" style="background-color: #fff !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px">
											<div class="col-md-3">
												<img src="/img/clients/1.jpg"><br>
											</div>
											<div class="col-md-3">
												<img src="/img/clients/1.jpg"><br>
											</div>
											<div class="col-md-3">
												<img src="/img/clients/1.jpg"><br>
											</div>
											<div class="col-md-3">
												<img src="/img/clients/1.jpg"><br>
											</div>
										</div>-->
									</div>
									
									@if($displayOtherProjects==true)
									<div class="col-md-12">
										<a href="/all-projects" class="btn btn-primary btn-sm pull-right" style="background-color: #000 !important; margin-right: 3px !important"><i class="fa fa-link"></i> View All Projects</a>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<h5><u><b style="text-decoration: underline !important;">Other Projects You Can Bid On:</b></u></h5>
											@foreach($otherProjects as $otherProject)
											<div class="col-md-4" style="padding-left: 3px; padding-right: 3px !important;">
												<div style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px" class="col-md-12">
													<a href="/"><label>{{$otherProject->title}}</label></a><br>
													<span style="text-decoration:underline !important">Project Date:</span> <span style="float:right !important">{{date('d, M Y', strtotime($otherProject->expected_start_date))}}</span><br>
													<span style="text-decoration:underline !important">Delivery Period:</span>
													<span style="float:right !important">{{date('d, M Y', strtotime($otherProject->expected_completion_date))}}</span><br>
													<span style="text-decoration:underline !important">Budget:</span>
													<span style="float:right !important">({{$otherProject->project_currency}}){{number_format($otherProject->budget, 2, '.', ',')}}</span><br>
													<span style="text-decoration:underline !important">Bids End:</span>
													
													<span style="float:right !important">{{date('d, M Y', strtotime($otherProject->expected_completion_date))}}</span><br>
													<span style="text-decoration:underline !important">Location:</span>
													<span style="float:right !important">{{$otherProject->state->name}}</span><br>
													<a href="/project-details/{{$otherProject->project_url}}" class="btn btn-primary btn-sm pull-right" style="margin-right: 3px !important"><i class="fa fa-link"></i> View</a>
												</div>
											</div>
											@endforeach
											<!--
											<div class="col-md-4" style="padding-left: 3px; padding-right: 3px !important;">
												<div style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px" class="col-md-12">
													<a href="/"><label>140 Men Needed For Party</label></a><br>
													<span style="text-decoration:underline !important">Project Date:</span> 18 October 2019<br>
													<span style="text-decoration:underline !important">Delivery Period:</span>
													10 Days<br>
													<span style="text-decoration:underline !important">Budget:</span>
													(ZMW)20,000.00<br>
													<span style="text-decoration:underline !important">Bids End:</span>
													31 October 2019<br>
													<span style="text-decoration:underline !important">Project Location:</span><br>
													Abuja<br>
													<a href="" class="btn btn-primary btn-sm pull-right" style="margin-right: 3px !important"><i class="fa fa-link"></i> View</a>
												</div>
											</div>
											
											<div class="col-md-4" style="padding-left: 3px; padding-right: 3px !important;">
												<div style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px" class="col-md-12">
													<a href="/"><label>140 Men Needed For Party</label></a><br>
													<span style="text-decoration:underline !important">Project Date:</span> 18 October 2019<br>
													<span style="text-decoration:underline !important">Delivery Period:</span>
													10 Days<br>
													<span style="text-decoration:underline !important">Budget:</span>
													(ZMW)20,000.00<br>
													<span style="text-decoration:underline !important">Bids End:</span>
													31 October 2019<br>
													<span style="text-decoration:underline !important">Project Location:</span><br>
													Abuja<br>
													<a href="" class="btn btn-primary btn-sm pull-right" style="margin-right: 3px !important"><i class="fa fa-link"></i> View</a>
												</div>
											</div>
											-->
										</div>
									</div>
									@else
									<div class="col-md-12">
										<a href="" class="btn btn-primary btn-sm pull-right" style="background-color: #000 !important; margin-right: 3px !important"><i class="fa fa-link"></i> View All Projects</a>
									</div>
									@endif
								</div>

								 <div class="col-md-4">
									<div class="form-group" style="border-bottom: 1px solid #dedede">
										<h5><u><b style="text-decoration: underline !important;">Other Details:</b></u></h5>
										<div class="col-md-12" style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px">
											<label>Expected Start Date:</label>
											<span style="float:right !important">{{date('d, M Y', strtotime($project->expected_start_date))}}</span>
											<br><br>
											<label>Expected Delivery:</label>
											<span style="float:right !important">{{date('d, M Y', strtotime($project->expected_completion_date))}}</span>
											<br><br>
											<label>Skillset Needed:</label>
											<?php
											$skills = [];
											foreach($project->skills as $skill)
											{
												array_push($skills, $skill->skill->skill_name);
											}
											?>
											@if(sizeof($skills)>0)
												<span style="float:right !important">{{join(', ', $skills)}}</span>
											@endif
											<br><br>
											<label>Budget({{$project->project_currency}}):</label>
											<span style="float:right !important">{{number_format($project->budget, 2, '.', ',')}}</span>
											<br><br>
											<label>Bidding Ends:</label>
											<?php 
											$createdDate = $project->created_at;
											$bidEnds = $createdDate->addDays($project->bidding_period);
											?>
											<span style="float:right !important">{{date('d, M Y', strtotime($bidEnds))}}</span>
											<br><br>
											<label>Project Location:</label>
											<span style="float:right !important">{{$project->project_location}}</span><br>
											<span style="float:right !important">{{$project->city}}</span><br>
											<span style="float:right !important">{{$project->state->name}}</span><br>
											<br>
											<label>Requires Inspection:</label>
											@if($project->inspection_required==1)
												<span style="float:right !important">Yes</span>
											@else
												<span style="float:right !important">No</span>	
											@endif
											<br><br>
											
										</div>
									</div>
									
									@if(!in_array($project->status, ['CANCELED', 'ASSIGNED', 'IN PROGRESS', 'COMPLETED']))
										@if(\Auth::user() && \Auth::user()->role_type=='Artisan' && $allowBidding==true)
										<form action="/place-bid/{{$project->project_url}}" method="post" class="form">
											<div class="form-group">
												<label>
												<br><br>Bid For This Task:</label><br>
												<div class="col-md-12" style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px">
													<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
														<label>How Much Do You Charge ({{$project->project_currency}})?</label>
														<input value="{{isset($projectBid) && $projectBid!=null ? $projectBid->bid_amount : ''}}" id="bidamount" class="col-md-8" style="background-color: #fff" type="number" name="bidamount" placeholder="Your Bid Amount" required="required">
													</div>
													<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
														<label>Task Completion Period</label>
														<div class="col-md-8" style="padding-left: 0px !important; padding-right: 0px !important;">
															<input value="{{isset($projectBid) ? $projectBid->bid_period : ''}}" id="deliveryPeriod" class="col-md-8" style="background-color: #fff" type="number" name="deliveryPeriod" placeholder="Your Delivery Period" required="required">
														</div>
														<div class="col-md-4" style="padding-left: 5px !important; padding-right: 0px !important;">
															<select id="form_name" class="" name="periodType" style="background-color: #fff" required="required">
																<option value="HOURS" {{isset($projectBid) && $projectBid->bid_period_type=='HOURS' ? 'selected' : ''}}>Hour(s)</option>
																<option value="DAYS" {{isset($projectBid) && $projectBid->bid_period_type=='DAYS' ? 'selected' : ''}}>Day(s)</option>
															</select>
														</div>
													</div>
													<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
														<label>Task Completion Period</label>
														<textarea id="bid_details" name="bid_details" placeholder="Your bid details" style="background-color: #fff" rows="4" required="required">{!! isset($projectBid) ? nl2br($projectBid->bid_details) : '' !!}</textarea>
													</div>
													
													<div class="col-md-12"  style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
														@if(isset($projectBid))
															<input type="submit" value="Update Bid" class="btn btn-success pull-right">
														@else
															<input type="submit" value="Submit Bid" class="btn btn-success pull-right">
														@endif
														<input type="submit" value="Cancel" class="btn btn-danger pull-left" style="margin-right: 5px;">
													</div>
												</div>
											</div>
										</form>
										@else
											@if(\Auth::user() && \Auth::user()->role_type=='Artisan')
											<div class="form-group col-md-12" style="text-align: center; padding-top: 5px !important;">
												<!--<a href="/bid-on-project/{{$project->project_url}}" class="btn btn-danger" style="margin-right: 5px;">Bid On Task</a><br>-->
												<div class="form-group col-md-12" style="padding: 0px !important">
													<small style="clear:both !important">You can not bid on this project because you do not have the required skills to handle this project</small>
												</div>
											</div>
											@else
											<div class="form-group col-md-12" style="text-align: center; padding-top: 5px !important;">
												<a href="/bid-on-project/{{$project->project_url}}" class="btn btn-danger" style="margin-right: 5px;">Bid On Task</a><br>
												<div class="form-group col-md-12" style="padding: 0px !important">
													<small style="clear:both !important">Log in with your Artisan account to bid</small>
												</div>
											</div>	
											@endif
										@endif
									@else
										@if($winningBid!=null)
										<div class="form-group">
											<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
												&nbsp;
											</div>
											<h5><u><b style="text-decoration: underline !important;">Winning Bid For This Task:</b></u></h5>
											<div class="col-md-12" style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px">
												<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
													<label>Bid Amount ({{$project->project_currency}}):</label>
													<span style="float:right !important">{{number_format($winningBid->bid_amount, 2, '.', ',')}}</span>
												</div>
												<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
													<label>Task Completion Period:</label>
													<span style="float:right !important">{{$winningBid->bid_period}} {{$winningBid->bid_period_type}}</span>
												</div>
												<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
													<label>Winning Bidder:</label>
													<span style="float:right !important">{{$winningBid->bid_by_user->first_name}} {{$winningBid->bid_by_user->last_name}}</span>
												</div>
											</div>
										</div>
										@endif
									@endif
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
								
								</div>
							</div>
						</div>
					

					</div>
				
				
				</div><!-- /row -->
			</div><!-- /container -->
		</section>
		
		@if($project->status=='COMPLETED' && \Auth::user() &&  \Auth::user()->role_type=='Private Client' && \Auth::user()->id==$project->created_by_user_id && $project->paid_out_yes==0)
		<div class="modal fade" id="fundsReleaseModal" tabindex="-1" role="dialog" aria-labelledby="fundsReleaseModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary" style="color: #fff">
						<h5 class="modal-title col-md-11" id="fundsReleaseModalLabel">Release Funds</h5>
						<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true" class="pull-right">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="display: inline-block;">
						<div class="row col-md-12" style="padding-bottom: 15px !Important">
							<div class="col-md-12">
								<div class="form-group">
									<label>Project Title:</label>
									{{$project->title}}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" style="text-align:center">
									<img src="/img/clients/{{$winningBid->bid_by_user->default_image->file_name}}"><br>
									<small><span>Bidder</span> <br>
									{{$winningBid->bid_by_user->first_name}} {{$winningBid->bid_by_user->last_name}}</small>
								</div>
							</div>

							<div class="col-md-8" style="padding-right: 0px !important;">
								<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
									
									
									<div class="col-md-12">
										<div class="form-group">
											<label>Escrowed Amount({{$project->project_currency}}):</label>
											<span style="float: right !important">{{number_format($project->budget, 2, '.', ',')}}</span>
										</div>
									</div>
									
									
									<div class="col-md-12" style="border-bottom: 2px solid #fff !important; margin-bottom: 0px !important;">
										<div class="form-group">
											<label>Bid Amount ({{$project->project_currency}}):</label>
											<span style="float: right !important">{{number_format($winningBid->bid_amount, 2, '.', ',')}}</span>
										</div>
									</div>
									
									<div class="col-md-12" style="padding-top:10px !important; border-bottom: 2px solid #fff !important; margin-bottom: 0px !important;">
										<div class="form-group">
											<label>Escrowed Balance ({{$project->project_currency}}):</label>
											<span style="float: right !important">{{number_format(($project->budget - $winningBid->bid_amount), 2, '.', ',')}}</span>
										</div>
									</div>
									
									<div class="col-md-12" style="padding-top:10px !important;">
										<div class="form-group">
											<label><strong>Amount to Release ({{$project->project_currency}}):</strong></label>
											<span style="float: right !important"><strong>{{number_format($winningBid->bid_amount, 2, '.', ',')}}</strong></span>
										</div>
									</div>
									
									
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<form action="/project-manage/release-funds/{{$project->project_ref}}/{{$winningBid->bid_code}}" method="post">
							<button type="submit" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-success pull-right">Release Payment</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		@endif
		
		
		
										
										
		@if($displayMessaging==true)
		<div class="modal fade" id="supportMessageSenderModal" tabindex="-1" role="dialog" aria-labelledby="supportMessageSenderModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary" style="color: #fff">
						<h5 class="modal-title col-md-11" id="supportMessageSenderModalLabel">Raise A Support Ticket</h5>
						<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true" class="pull-right">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="display: inline-block;">
						<div class="row col-md-12" style="padding-bottom: 15px !Important">
							<div class="col-md-12">
								<div class="form-group">
									<label>Project Title:</label>
									{{$project->title}}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" id="supportreceipientid" style="text-align:center">
									<img src="/img/clients/{{$project->created_by_user->default_image== null ? 'default_male.png' : $project->created_by_user->default_image->file_name}}"><br>
									<i>Bidder</i> <br>
									Joshua Suazo
								</div>
							</div>

							<div class="col-md-8" style="padding-right: 0px !important;">
								<form class="form" action="/send-support-message/{{$project->project_url}}" method="post" enctype="multipart/form-data">
									<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
										
										<div class="form-group col-md-12">
											<label><strong>Provide Your Complaints:</strong></label>
											<input type="text" name="subject" class="col-md-12" placeholder="Provide A Subject For This Support Ticket" style="margin-bottom:3px">
											<textarea class="col-md-12" style="padding: 10px;" id="form_message" name="message" placeholder="Provide Your profile" rows="4" required="required"></textarea>
											
											<small><label><strong><br><br>Attach Files If Required:</strong></label> <input type="file" name="supportFiles[]" multiple></small>
										</div>
									</div>
									<button type="submit" style="margin-top: 5px" class="btn btn-success pull-right">Post Support Message</button>
								</form>
							</div>
							
						</div>
						
					</div>
				</div>
			</div>
		</div>
		@endif
		
		<div class="modal fade" id="messageSenderModal" tabindex="-1" role="dialog" aria-labelledby="messageSenderModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary" style="color: #fff">
						<h5 class="modal-title col-md-11" id="messageSenderModalLabel">Compose A Message</h5>
						<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true" class="pull-right">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="display: inline-block;">
						<div class="row col-md-12" style="padding-bottom: 15px !Important">
							<form class="form" method="post" action="/send-project-message/{{$project->project_url}}">
								<div class="col-md-12">
									<div class="form-group">
										<label>Project Title:</label>
										{{$project->title}}
									</div>
								</div>
								<div class="col-md-4" style="overflow:hidden !important; max-height: 200px">
									<div class="form-group" id="receipientuserid" style="text-align:center">
										<img src="/img/clients/default.png"><br>
										<i>Bidder</i> <br>
										
									</div>
								</div>

								<div class="col-md-8" style="padding-right: 0px !important;">
									<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
										
										<div class="form-group col-md-12">
											<label><strong>Provide Your Message:</strong></label>
											<textarea class="col-md-12" style="padding: 10px;" id="form_message1" name="message" placeholder="Provide Your profile" rows="4" required="required"></textarea>
											<input name="receiver" id="receiver" type="hidden">
										</div>
									</div>
								</div>
								<button type="submit" style="margin-top: 5px" class="btn btn-success pull-right">Send Message</button>
							</form>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		
		
		<div class="modal fade" id="projectBidsModal" tabindex="-1" role="dialog" aria-labelledby="projectBidsModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary" style="color: #fff">
						<h5 class="modal-title col-md-11" id="projectBidsModalLabel">Bids For This Project</h5>
						<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true" class="pull-right">&times;</span>
						</button>
					</div>
					<div class="modal-body col-md-12" style="display: inline-block;">
						<form class="form">
							<div class="row col-md-12" style="padding-bottom: 15px !Important; padding-right: 0px !important">
								<div class="form-group col-md-12">
									<label>Project Title:</label>
									{{$project->title}}
								</div>
								
								@if(!in_array($project->status, ['PENDING']))
								<div class="form-group col-md-12" style="text-align:left;  padding-right: 0px !important;">
									<u><label><strong style="text-decoration: underline !important">All Bids</strong></label></u><br>
									<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
										<div class="form-group table-responsive" style="padding-bottom: 15px !important;">
											<table class="table col col-md-12" style="padding-bottom: 15px !important;">
												<thead>
													<tr>
														<th scope="col">S/No</th>
														<th scope="col">Worker's Name</th>
														<th scope="col">Delivery Period</th>
														<th scope="col" style="text-align: right !important">Bid Amount ({{$project->project_currency}})</th>
														<th scope="col" style="text-align: right !important">Status</th>
														@if(\Auth::user() && $project->created_by_user_id==\Auth::user()->id && $project->paid_out_yes==0)
															<th scope="col" style="text-align: right !important">Manage Bid</th>
														@endif
														@if(in_array($project->status, ['OPEN', 'ASSIGNED', 'IN PROGRESS']) && \Auth::user() && \Auth::user()->role_type=='Artisan' && $projectBid!=null && $project->paid_out_yes==0)
															<th scope="col" style="text-align: right !important">Manage Bid</th>
														@endif
													</tr>
												</thead>
												<tbody>
													<?php
													$x= 1;
													?>
													@if($projectBids->count()>0)
														@foreach($projectBids as $projectBid)
														<tr>
															<td>{{$x++}}.</td>
															<td>{{$projectBid->bid_by_user->first_name}} {{$projectBid->bid_by_user->last_name}}</td>
															<td>{{$projectBid->bid_period}} {{$projectBid->bid_period_type}}</td>
															<td style="text-align: right !important">{{number_format($projectBid->bid_amount, 2, '.', ',')}}</td>
															<td style="text-align: right !important">{{$projectBid->status}}</td>
															@if(in_array($project->status, ['OPEN', 'ASSIGNED', 'IN PROGRESS']))
																@if(\Auth::user() && $project->created_by_user_id==\Auth::user()->id)
																	<td>
																		<!--<div style="float: right !important; padding-left: 15px; font-size: 20px !important; pointer:cursor !important;"><i class="fa fa-sticky-note-o"></i></div>-->
																		<div class="dropdown dropright" style="float: right !important;">
																			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				Manage Bid
																			</button>
																			<ul class="dropdown-menu" style="right: 0px !important; left: auto !important" aria-labelledby="dropdownMenuButton">
																				@if($projectBid->status=='VALID')
																				<li class="dropdown-item" onclick="javascript:handleAcceptBid('{{$project->project_ref}}', '{{$projectBid->bid_code}}')" style="cursor: pointer; padding:10px !important">Accept Bid</li>
																				@endif
																				
																				<li class="dropdown-item" onclick="javascript:handleMessage('{{$project->project_ref}}', '{{$projectBid->bid_by_user->user_code}}')" style="cursor: pointer !important; padding:10px !important">Message Worker</li>
																				
																			</ul>
																		</div>
																	</td>
																@endif
															@endif
															
															@if(in_array($project->status, ['OPEN', 'ASSIGNED', 'IN PROGRESS']) && \Auth::user() && \Auth::user()->role_type=='Artisan' && $projectBid!=null && \Auth::user()->id==$projectBid->bid_by_user_id)
																<td>
																	<!--<div style="float: right !important; padding-left: 15px; font-size: 20px !important; pointer:cursor !important;"><i class="fa fa-sticky-note-o"></i></div>-->
																	<div class="dropdown dropright" style="float: right !important;">
																		<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																			Manage Bid
																		</button>
																		<ul class="dropdown-menu" style="right: 0px !important; left: auto !important" aria-labelledby="dropdownMenuButton">
																			@if($projectBid->status=='WON' && $projectBid->bid_by_user_id==\Auth::user()->id)
																			<li class="dropdown-item" onclick="javascript:handleAcceptBidHandle('{{$project->project_ref}}', '{{$projectBid->bid_code}}')" style="cursor: pointer; padding:10px !important">Accept Bid</li>
																			@endif
																			<li class="dropdown-item" onclick="javascript:handleEditBid('{{$project->project_ref}}', '{{$projectBid->bid_by_user->user_code}}')" style="cursor: pointer !important; padding:10px !important">Edit Bid</li>
																		</ul>
																	</div>
																</td>
															@endif
														</tr>
														<tr style="background-color:#ededed !important">
															@if(\Auth::user() && $project->created_by_user_id==\Auth::user()->id)
																<td colspan="6">
																	<i>{{$projectBid->bid_details}}</i>
																</td>
															@else
																@if(in_array($project->status, ['OPEN', 'ASSIGNED']) && \Auth::user() && \Auth::user()->role_type=='Artisan' && $projectBid!=null)
																	<td colspan="6">
																		<i>{{$projectBid->bid_details}}</i>
																	</td>
																@else
																	<td colspan="5">
																		<i>{{$projectBid->bid_details}}</i>
																	</td>
																@endif
															@endif
														</tr>
														@endforeach
													@else
														<tr style="background-color:#ededed !important">
															@if(\Auth::user() && $project->created_by_user_id==\Auth::user()->id)
																<td colspan="6" style="text-align: center">
																	<i>No Bids Submitted Yet</i>
																</td>
															@else
																@if($project->status=='OPEN' && \Auth::user() && \Auth::user()->role_type=='Artisan' && $projectBid!=null)
																	<td colspan="6" style="text-align: center">
																		<i>No Bids Submitted Yet</i>
																	</td>
																@else
																	<td colspan="5" style="text-align: center">
																		<i>No Bids Submitted Yet</i>
																	</td>
																@endif
															@endif
														</tr>
													@endif
												</tbody>
											</table>
										</div>
									</div>
								</div>
								@endif
								<!--<button type="submit" style="margin-top: 5px" class="btn btn-success pull-right">Mark As Completed</button>-->
							</div>
						</form>
					</div>
					<div class="modal-footer" style="">
						
					</div>
				</div>
			</div>
		</div>
		
		
		
		@if($project->status=='IN PROGRESS' && \Auth::user() &&  ((\Auth::user()->role_type=='Private Client' && \Auth::user()->id==$project->created_by_user_id && $project->worker_rating==null) || (\Auth::user()->role_type=='Artisan' && \Auth::user()->id==$project->assigned_bidder_id && $project->completed_by_worker==0)))
		<div class="modal fade" id="markAsCompletedModal" tabindex="-1" role="dialog" aria-labelledby="markAsCompletedModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary" style="color: #fff">
						<h5 class="modal-title col-md-11" id="markAsCompletedModalLabel">Mark Project As Completed</h5>
						<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true" class="pull-right">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="display: inline-block;">
						<form action="/mark-project-completed/{{$project->project_url}}" method="post" class="form">
							<div class="row col-md-12" style="padding-bottom: 15px !Important">
								<div class="col-md-12">
									<div class="form-group">
										<label>Project Title:</label>
										{{$project->title}}
									</div>
								</div>
								<div class="col-md-4" style="max-height: 200px !important; overflow: hidden">
									<div class="form-group" style="text-align:center">
										<img src="/img/clients/{{$project->created_by_user->default_image->file_name}}"><br>
										<i>Bidder</i> <br>
										{{$project->created_by_user->first_name}} {{$project->created_by_user->last_name}}<br>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star"></span>
										<span class="fa fa-star"></span>
									</div>
								</div>

								<div class="col-md-8" style="padding-right: 0px !important;">
									<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
										
										<div class="form-group col-md-12">
											<u><label><strong style="text-decoration: underline !important">Marking A Project As Completed</strong></label></u><br>
											<small>When you mark this project as completed you imply that you the artisan assigned to handle this task has completely handled this task to 
											the clients satisfaction.<br><br>
											If you do not receive payment for handling this project within 3 days after marking it as completed, kindly raise a support ticket to our support team.</small>
										</div>
										
									</div>
								</div>
								<div class="form-group col-md-12" style="text-align:left; padding-left: 0px !important; padding-right: 0px !important;">
									@if(\Auth::user() && \Auth::user()->role_type=='Artisan')
									<u><label><strong style="text-decoration: underline !important">Rate This Client</strong></label></u><br>
									@elseif(\Auth::user() && \Auth::user()->role_type=='Private Client')
									<u><label><strong style="text-decoration: underline !important">Rate This Artisan</strong></label></u><br>
									@endif
									<div class="col-md-12">
										<div class="form-group">
											<select id="form_name" class="col-md-12" name="rating" required="required" style="margin-bottom: 5px !important">
												<option value="0">0 - Terribly Poor Performance</option>
												<option value="1">1 - Poor Performance</option>
												<option value="2">2 - Fair Performance</option>
												<option value="3">3 - Average Performance</option>
												<option value="4">4 - Good Performance</option>
												<option value="5">5 - Excellent Performance</option>
											</select>
											<textarea class="col-md-12" style="padding: 10px;" id="reviewClient" name="reviewClient" placeholder="How was your clients performance during the project?" rows="4" required="required"></textarea>
										</div>
									</div>
								</div>
								<button type="submit" style="margin-top: 5px" class="btn btn-success pull-right">Mark Project As Completed</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		@endif
		
		@if(\Auth::user() && \Auth::user()->role_type=='Private Client' && \Auth::user()->id==$project->created_by_user_id && !in_array($project->status, ['CANCELED', 'ASSIGNED']))
		<div class="modal fade" id="cancelProjectModal" tabindex="-1" role="dialog" aria-labelledby="cancelProjectModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary" style="color: #fff">
						<h5 class="modal-title col-md-11" id="cancelProjectModalLabel">Cancel Project</h5>
						<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true" class="pull-right">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="display: inline-block;">
						<form action="/cancel-project/{{$project->project_url}}" method="post" class="form">
							<div class="row col-md-12" style="padding-bottom: 15px !Important">
								<div class="col-md-12">
									<div class="form-group">
										<label>Project Title:</label>
										{{$project->title}}
									</div>
								</div>
								<div class="col-md-12" style="padding-right: 0px !important;">
									<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
										
										<div class="form-group col-md-12">
											<u><label><strong style="text-decoration: underline !important">Canceling Project</strong></label></u><br>
											<small>When you cancel this project, this project will no longer be listed on our site for artisans to bid on this project.<br><br>
											On cancelation, you will be refunded the funds you escrowed for this project. However the service charges for listing the project on our site will not be refunded. This was specified in our terms and conditions</small>
										</div>
										
									</div>
								</div>
								<div class="form-group col-md-12" style="text-align:left; padding-left: 0px !important; padding-top: 10px !important; padding-right: 0px !important;">
									<div class="col-md-12">
										<div class="form-group">
											<label>Reason for Cancelation:</label>
											<textarea class="col-md-12" style="padding: 10px;" id="cancelationReason" name="cancelationReason" placeholder="Provide details for the cancelation" rows="4" required="required"></textarea>
										</div>
									</div>
								</div>
								<button type="submit" style="margin-top: 5px" class="btn btn-danger pull-right">Cancel Project</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		@endif
		<!--====== End Contact ======-->

		<!--====== Footer ======-->
		<footer>
			<div class="container text-center">
				<div class="row">
					<p>Copyright <?php echo date('Y'); ?> &copy; Probase Limited. All Rights Reserved</p>
				</div>
			</div>
		</footer>
		<!--====== End Footer ======-->

		@include('login')
		
		@include('activate')

       
        <!-- jQuery -->
		<script src="/js/jquery-3.0.0.min.js"></script>
		<script src="/js/jquery-migrate-3.0.0.min.js"></script>
		<script src="/js/action.js"></script>

	  	<!-- bootstrap -->
		<script src="/js/bootstrap.min.js"></script>

		<!-- scrollIt -->
		<script src="/js/scrollIt.min.js"></script>

		<!-- magnific-popup -->
		<script src="/js/jquery.magnific-popup.min.js"></script>

		<!-- owl carousel -->
		<script src="/js/owl.carousel.min.js"></script>

		<!-- stellar js -->
		<script src="/js/jquery.stellar.min.js"></script>

		<!-- animated.headline -->
		<script src="/js/animated.headline.js"></script>

      	<!-- jquery.waypoints.min js -->
	  	<script src="/js/jquery.waypoints.min.js"></script>

	  	<!-- jquery.counterup.min js -->
	  	<script src="/js/jquery.counterup.min.js"></script>

      	<!-- isotope.pkgd.min js -->
      	<script src="/js/isotope.pkgd.min.js"></script>

      	<!-- validator js -->
      	<script src="/js/validator.js"></script>

      	<!-- custom script -->
        <script src="/js/custom.js"></script>
		<script src="/js/bootstrap-notify.js"></script>
		<script src="/js/action.js"></script>
		<script>
			function handleAcceptBid(project_code, project_bid_code)
			{
				window.location= '/project-manage/manage-bid/'+project_code+'/'+project_bid_code;
			}
			
			function handleAcceptBidHandle(project_code, project_bid_code)
			{
				window.location= '/project-manage/manage-bid-accept-handle/'+project_code+'/'+project_bid_code;
			}
			
			
			function handleMessage(project_code, project_bidder_user_code)
			{
				//$.notify("Hello World");
				var allMessages = $("#all_support_messages");
				var supportConversers = $("#supportConversers");
				var supportMessageModalLabel = $("#supportMessageModalLabel");
				allMessages.html('--Loading--');
				$.ajax({
					url: '/get-user-by-usercode/' + project_bidder_user_code,
					dataType: 'json',
					success: function (resp) {
						if (resp.status === 1) 
						{
							v1 =  '<img src="/img/clients/' + resp.data.default_image.file_name + '" style="height:50px !important; width: 50px !important"><br>' + 
								'<i>Bidder</i> <br>' + 
								resp.data.first_name + ' ' + resp.data.last_name;
							document.getElementById('receipientuserid').innerHTML = v1;
							document.getElementById('receiver').value = project_bidder_user_code;
							$('#projectBidsModal').modal('toggle');
							$('#messageSenderModal').modal('toggle');
						}
					},
					complete: function () {
						//$("#all_messages").removeClass('disabled');
						$('#supportMessageModal').modal('toggle');
					}
				});
			}
		</script>
		
		@include('scripts')
		
		
    </body>

<!-- Mirrored from www.innovationplans.com/idesign/daniels/main.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Sep 2019 13:16:00 GMT -->
</html>

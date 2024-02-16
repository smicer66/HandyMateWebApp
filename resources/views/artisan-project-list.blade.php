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

    	<!-- ====== Preloader ======  
	    <div class="loading">
			<div class="load-circle">
			</div>
		</div>-->
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
						<h3>My Projects</h3>
					</div>

					<div class="col-md-10">
						<u style="float: left !important;"><h5 style="padding-bottom: 15px !important;"><strong style="text-decoration: underline !important">Projects I Bidded On</strong></h5></u>
						

						<div class="controls" style="clear:both">

							
							<div class="row" style="padding-bottom: 15px !Important">
								<div class="col-md-12">
										<div class="form-group">
											<?php
											$i = 0;
											?>
											@foreach($projects as $project)
												<div class="col-md-6" style="padding-left: 3px; padding-right: 3px !important;">
													<div style="font-size: 13px !important; background-color: #f4f4f4 !important; border-radius: 5px !important; padding-top: 10px; padding-bottom: 10px" class="col-md-12">
														<a href="/project-details/{{$project->project_url}}" style="text-decoration: underline !important; font-weight: bold"><u>{{$project->title}}</u></a><br>
														<span style="text-decoration:underline !important">Project Owner:</span> <span style="float: right !important">{{$project->created_by_user->first_name}} {{$project->created_by_user->last_name}}</span><br>
														<span style="text-decoration:underline !important">Project Date:</span> <span style="float: right !important">{{date('d, F Y', strtotime($project->expected_start_date))}}</span><br>
														<span style="text-decoration:underline !important">Delivery Period:</span>
														<span style="float: right !important">{{date('d, F Y', strtotime($project->expected_completion_date))}}</span><br>
														<span style="text-decoration:underline !important">Budget:</span>
														<span style="float: right !important">(ZMW){{number_format($project->budget, 2, '.', ',')}}</span><br>
														<span style="text-decoration:underline !important">Bids End:</span>
														<span style="float: right !important">{{date('d, F Y', strtotime($project->expected_completion_date))}}</span><br>
														<span style="text-decoration:underline !important">Project Status:</span>
														<span style="float: right !important">{{$project->status}}</span><br>
														<span style="text-decoration:underline !important">My Bid Status:</span>
														<span style="float: right !important">{{$bids[$project->id."-"]->status}}</span><br>
														<span style="text-decoration:underline !important">My Bid:</span>
														<span style="float: right !important">(ZMW){{number_format($bids[$project->id."-"]->bid_amount, 2, '.', ',')}}</span><br>
														<div class="col col-md-12" style="float: right !important; height: 50px !important; overflow-y: scroll; background-color: #d5d5d5">{!!$bids[$project->id."-"]->bid_details!!}</div>
														<a href="/project-details/{{$project->project_url}}" class="btn btn-primary btn-sm pull-right" style="margin-right: 3px !important"><i class="fa fa-link"></i> View</a>
													</div>
												</div>
												@if($i++%2==1)
													<div class="col-md-12" style="">
													&nbsp;
													</div>
												@endif
											@endforeach
											
										</div>
									
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
								
								</div>
							</div>
						</div>
					
					
					</div>
					<div class="col-md-2"  style="padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
						<h5><span style="text-decoration:underline"><u><b style="text-decoration: underline !important;">Projects By Skill</b></u></span></h5>
						@for($x=0; $x<sizeof($filterskills); $x++)
							<a href="/all-projects/skill/{{$filterskills[$x]['skill_slug']}}" class="fontsize13"><i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;{{$filterskills[$x]['skill_name']}}</a><br>
						@endfor
					</div>
				</div><!-- /row -->
			</div><!-- /container -->
		</section>
		
		
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
									Ten Men Needed
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" style="text-align:center">
									<img src="/img/clients/1.jpg"><br>
									<i>Bidder</i> <br>
									Joshua Suazo
								</div>
							</div>

							<div class="col-md-8" style="padding-right: 0px !important;">
								<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
									
									<div class="col-md-12">
										<div class="form-group">
											<label>Bid Amount (ZMW):</label>
											<span style="float: right !important">10,000.00</span>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>VAT (5%) (ZMW):</label>
											<span style="float: right !important">50.00</span>
										</div>
									</div>
									<div class="col-md-12" style="border-bottom: 2px solid #fff !important; padding-bottom:10px !important; margin-bottom: 0px !important;">
										<div class="form-group">
											<label>Service Charge (ZMW):</label>
											<span style="float: right !important">500.00</span>
										</div>
									</div>
									<div class="col-md-12" style="padding-top:10px !important;">
										<div class="form-group">
											<label><strong>Amount to Release (ZMW):</strong></label>
											<span style="float: right !important"><strong>10,550.00</strong></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-success pull-right">Release Payment</button>
					</div>
				</div>
			</div>
		</div>
		
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
									Ten Men Needed
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" style="text-align:center">
									<img src="/img/clients/1.jpg"><br>
									<i>Bidder</i> <br>
									Joshua Suazo
								</div>
							</div>

							<div class="col-md-8" style="padding-right: 0px !important;">
								<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
									
									<div class="form-group col-md-12">
										<label><strong>Provide Your Complaints:</strong></label>
										<textarea class="col-md-12" style="padding: 10px;" id="form_message" name="message" placeholder="Provide Your profile" rows="4" required="required"></textarea>
										
										<small><label><strong><br><br>Attach Files If Required:</strong></label> <input type="file" name="supportFiles" multiple></small>
									</div>
								</div>
							</div>
							<button type="button" style="margin-top: 5px" class="btn btn-success pull-right">Post Support Message</button>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		
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
							<div class="col-md-12">
								<div class="form-group">
									<label>Project Title:</label>
									Ten Men Needed
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" style="text-align:center">
									<img src="/img/clients/1.jpg"><br>
									<i>Bidder</i> <br>
									Joshua Suazo
								</div>
							</div>

							<div class="col-md-8" style="padding-right: 0px !important;">
								<div class="col-md-12"  style="background-color: #f4f4f4 !important; border-radius: 5px !important; padding-left: 0px !important; padding-right: 0px !important; padding-top: 10px !important;">
									
									<div class="form-group col-md-12">
										<label><strong>Provide Your Message:</strong></label>
										<textarea class="col-md-12" style="padding: 10px;" id="form_message" name="message" placeholder="Provide Your profile" rows="4" required="required"></textarea>
										
									</div>
								</div>
							</div>
							<button type="button" style="margin-top: 5px" class="btn btn-success pull-right">Send Message</button>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		
		
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
						<div class="row col-md-12" style="padding-bottom: 15px !Important">
							<div class="col-md-12">
								<div class="form-group">
									<label>Project Title:</label>
									Ten Men Needed
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group" style="text-align:center">
									<img src="/img/clients/1.jpg"><br>
									<i>Bidder</i> <br>
									Joshua Suazo<br>
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
								<u><label><strong style="text-decoration: underline !important">Rate This Client</strong></label></u><br>
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
							<button type="button" style="margin-top: 5px" class="btn btn-success pull-right">Mark As Completed</button>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		
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
						<div class="row col-md-12" style="padding-bottom: 15px !Important">
							<div class="col-md-12">
								<div class="form-group">
									<label>Project Title:</label>
									Ten Men Needed
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
							<button type="button" style="margin-top: 5px" class="btn btn-danger pull-right">Cancel Project</button>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
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

    </body>

<!-- Mirrored from www.innovationplans.com/idesign/daniels/main.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Sep 2019 13:16:00 GMT -->
</html>

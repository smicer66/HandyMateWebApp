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
		<link rel="stylesheet" href="css/bootstrap.min.css">

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
						<h3>Create A New Project</h3>
						<h4><strong style="text-decoration: underline !important">Step Four - Review Your Project</strong></h4>
					</div>

					<div class="col-md-12">
						<!--<u><h5 style="padding-bottom: 15px !important;">Step One - Your Bio-Data</h5></u>
						 contact info -->
						<!-- contact form -->
						<form class="form" method="post" action="/new-project-step-four">
		                    <div class="messages"></div>

		                    <div class="controls">

		                        <div class="row" style="padding-bottom: 15px !Important">
		                            <div class="col-md-12">
		                                <div class="form-group">
											<label>Project Title:</label><br>
		                                    {{$stepOneData->title}}
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Expected Start Date:</label><br>
		                                    {{date('d, M Y', strtotime($stepOneData->startDate))}}
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Expected Completion Period:</label><br>
		                                    {{date('d, M Y', strtotime($stepOneData->endDate))}}
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Bidding Ends In:</label><br>
		                                    {{$stepOneData->deliveryPeriod}}-
		                                    {{$stepOneData->biddingPeriodType}}
		                                </div>
		                            </div>
		                        </div>
								
								
								<div class="row" style="padding-bottom: 15px !Important">
		                            <div class="col-md-8">
		                                <div class="form-group">
											<label>Project Location (Address):</label><br>
		                                    {{$stepOneData->address}}
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>City:</label><br>
		                                    {{$stepOneData->city}}
		                                </div>
		                            </div>
		                        </div>
								
								
								<div class="row" style="padding-bottom: 15px !Important">
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>Country Project Is Located:</label><br>
		                                    {{explode('|||', $stepOneData->country)[1]}}
		                                </div>
		                            </div>
									
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>Province Project Is Located:</label><br>
		                                    {{$province->name}}
		                                </div>
		                            </div>

		                            
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>District Project Is Located:</label><br>
		                                    {{$district->lga_name}}
		                                </div>
		                            </div>
		                        </div>
								
								
								<div class="row" style="padding-bottom: 15px !Important">

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Project Budget ({{$stepOneData->currency}}) <small>(Excludes cost of Materials)</small>:</label><br>
		                                    {{number_format($stepOneData->budget, 2, '.', ',')}}
		                                </div>
		                            </div>

		                        </div>
								
								<div class="row">
									<div class="col-md-12">
										<label>Skillsets Needed For This Project:</label>
									</div>
		                            <div class="col-md-12">
										<?php $i=0; ?>
										@foreach($skills as $skill)
											<div class="form-group col-md-3">
												<i class="fa fa-check"></i>&nbsp;&nbsp;{{$skill->skill_name}}
											</div>
										@endforeach
		                            </div>
		                        </div>
								
								@if(isset($artisans) && $artisans!=null)
								<div class="row">
									<div class="col-md-12">
										<label>Limit this project to a specific set of Artisans? Specify the artisans:</label>
									</div>
		                            <div class="col-md-12">
										<?php $i=0; ?>
										@foreach($artisans as $artisan)
											<div class="form-group col-md-3">
												<i class="fa fa-check"></i>&nbsp;&nbsp;<small>{{ucwords($artisan->first_name)}} {{ucwords($artisan->last_name)}} {{ucwords($artisan->other_name)}}</small>
											</div>
										@endforeach
		                            </div>
		                        </div>
								@endif
								
								
		                        <div class="row">
		                            <div class="col-md-12">
									
		                            </div>
		                        </div>
								
		                        <div class="row">
		                            <div class="col-md-12">
										<input type="submit" value="Pay & Submit Project" class="btn btn-success pull-right">
		                                <input type="submit" value="Cancel" class="btn btn-danger pull-left" style="margin-right: 5px;"><br>
										<div class="col-md-4 pull-right" style="clear: both !important; text-align: right !important">
											<i><small><strong>Why Pay?</strong><br>The budget for this project will be escrowed/held with HandyMate until you are ready to release payment to the artisan</small></i>
										</div>
		                            </div>
		                        </div>
		                    </div>
		                </form>

					</div>
				
				
				</div><!-- /row -->
			</div><!-- /container -->
		</section>
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

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
		
		<link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
						<u><h4><strong style="text-decoration: underline !important">Step One - Project Details</strong></h4></u>
					</div>

					<div class="col-md-12">
						<!--<h5 style="padding-bottom: 15px !important;"><strong style="text-decoration: underline !important">Step One - Your Bio-Data</strong></h5>-->
						<!-- contact info -->
						<!-- contact form -->
						<form class="form" method="post" action="/new-project-step-one" autocomplete="off">
		                    <div class="messages"></div>

		                    <div class="controls">

		                        <div class="row" style="padding-bottom: 15px !Important">
		                            <div class="col-md-12">
		                                <div class="form-group">
											<label>Project Title:<span style="color: red">*</span></label>
		                                    <input id="title" type="text" name="title" placeholder="Provide a descriptive title" required="required">
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Expected Start Date:<span style="color: red">*</span></label>
		                                    <input class="dates" id="startDate" type="text" name="startDate" placeholder="When Does The Project Start" required="required">
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Expected Completion Period:<span style="color: red">*</span></label>
		                                    <input class="dates" id="endDate" type="text" name="endDate" placeholder="Provide Project Completion Date" required="required">
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Bidding Ends In:<span style="color: red">*</span></label><br>
		                                    <div class="col-md-8" style="padding-left: 5px !important; padding-right: 0px !important;">
												<input id="biddingPeriod" class="col-md-8" type="number" name="deliveryPeriod" placeholder="Stop Receiving Bids In" required="required">
											</div>
											<div class="col-md-4" style="padding-left: 5px !important; padding-right: 0px !important;">
												<select id="biddingPeriodType" class="" name="biddingPeriodType" style="" required="required">
													<option value="HOURS">Hour(s)</option>
													<option value="DAYS">Day(s)</option>
												</select>
											</div>
		                                </div>
		                            </div>
		                        </div>
								
								
								<div class="row" style="padding-bottom: 15px !Important">
		                            <div class="col-md-8">
		                                <div class="form-group">
											<label>Project Location (Address):<span style="color: red">*</span></label>
		                                    <input id="address" type="text" name="address" placeholder="Project will be handled where?" required="required">
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>City:<span style="color: red">*</span></label>
		                                    <input id="form_email" type="text" name="city" placeholder="e.g. Lusaka, Capetown" required="required">
		                                </div>
		                            </div>
		                        </div>
								
								
								<div class="row" style="padding-bottom: 15px !Important">
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>Country Project Is Located:<span style="color: red">*</span></label>
		                                    <select id="country_id_new-task" name="country" required="required">
												<option value>-Select One-</option>
												@foreach($countries as $country)
												<option value="{{$country->id}}|||{{$country->name}}">{{$country->name}}</option>
												@endforeach
											</select>
		                                </div>
		                            </div>
									
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>Province Project Is Located:<span style="color: red">*</span></label>
		                                    <select id="state_id_new_task" name="province" required="required">
											</select>
		                                </div>
		                            </div>

		                            
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>District Project Is Located:<span style="color: red">*</span></label>
		                                    <select id="new_project_lga_id" name="district" required="required">
											</select>
		                                </div>
		                            </div>
		                        </div>
								
								
								<div class="row" style="padding-bottom: 15px !Important">

		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>Project Budget <small>(Excludes cost of Materials)</small>:<span style="color: red">*</span></label><br>
		                                    
											
											<div class="col-md-4" style="padding-left: 0px !important; padding-right: 0px !important;">
												<select id="currency" class="" name="currency" required="required">
													@foreach($countries as $country)
													<option value="{{$country->default_currency_cd}}">{{$country->default_currency_cd}}</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-8" style="padding-left: 5px !important; padding-right: 0px !important;">
												<input id="budget" type="number" name="budget" placeholder="Your Maximum Budget" required="required">
											</div>
		                                </div>
		                            </div>
									
									<div class="col-md-4">
		                                <div class="form-group">
											<label>Messaging <small>(Workers can message me about this project)</small>:</label><br>
		                                    
											
											<div class="col-md-4" style="padding-left: 0px !important; padding-right: 0px !important;">
												<input type="checkbox" name="open_to_discussion" id="open_to_discussion">
											</div>
		                                </div>
		                            </div>

		                        </div>
								
								
								
								<div class="row" style="padding-bottom: 15px !Important">

		                             <div class="col-md-12">
		                                <div class="form-group">
											<label>Project Description:<span style="color: red">*</span></label><br>
		                                    <textarea id="description" name="description" placeholder="Provide the description of the project" rows="4" required="required"></textarea>
		                                </div>
		                            </div>

		                        </div>
								
								
								
								
		                        <div class="row">
		                            <div class="col-md-12">
									
		                            </div>
		                        </div>
								
		                        <div class="row">
		                            <div class="col-md-12">
										<input type="submit" value="Next" class="btn btn-success pull-right">
		                                <input type="submit" value="Cancel" class="btn btn-danger pull-left" style="margin-right: 5px;">
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
		<script src="/js/action.js"></script>
		<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="/plugins/timepicker/bootstrap-timepicker.min.js"></script>
		<script>
		
	
		$("#country_id_new-task").on('change', function () {
			var $this = $(this);
            var state = $("#state_id_new_task");
            var country_id = $(this).val();
			country_id = country_id.split('|||');
			
			state.html('--Loading--');
			state.empty();
			var lga = $("#new_project_lga_id");
			lga.empty();
			if(country_id.length>0)
			{
				country_id = country_id[0];
				$.ajax({
					url: '/get_state_by_country/' + country_id,
					dataType: 'json',
					success: function (resp) {

						if (resp.status === 1) {
							$.each(resp.data, function (k, v) {

								state.append($('<option>', {
									value: k==0 ? null : k,
									text: v
								}));

							});
						}
					},
					complete: function () {
						$this.removeClass('disabled');
						$("#state_id_new_task").removeClass('disabled');
					}
				});
			}

            
		});
		
		
		$("#state_id_new_task").change(function () {
			var $this = $(this);
			var lga = $("#new_project_lga_id");
			lga.empty();
			var state_id = $(this).val();
			lga.html('--Loading--');
			$.ajax({
				url: '/get_lga_by_state/' + state_id,
				dataType: 'json',
				success: function (resp) {
					console.log(resp);
					if (resp.status === 1) {
						$.each(resp.data, function (k, v) {
							lga.append($('<option>', {
								value: k,
								text: v
							}));
						});
					}
				},
				complete: function () {
					$this.removeClass('disabled');
					$("#lga_id").removeClass('disabled');
				}
			});
		});
		</script>

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
		<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="/js/action.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    </body>

<!-- Mirrored from www.innovationplans.com/idesign/daniels/main.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Sep 2019 13:16:00 GMT -->
</html>

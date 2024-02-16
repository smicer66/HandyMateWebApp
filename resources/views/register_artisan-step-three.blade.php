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
						<h3>Step Three - Tell Us About Yourself</h3>
					</div>

					
					<div class="col-md-12">
						<div class="col-md-12" style="padding-top: 10px !important;">
						
						</div>
						<u><h5 style="padding-bottom: 15px !important;"><strong style="text-decoration: underline !important">About You</strong></h5></u>
						<!-- contact info -->
						<!-- contact form -->
						<form class="form" method="post" action="/register-artisan-step-three">
		                    <div class="messages"></div>

		                    <div class="controls">

		                        <div class="row">
		                            <div class="col-md-12">
										<div class="form-group col-md-12">
											<label>Who Are You?</label>
											<textarea id="form_message" name="profile" placeholder="Provide Your profile" rows="4" required="required"></textarea>
										</div>
		                            </div>
		                        </div>
								
								<div class="row" style="padding-bottom: 15px !Important">
									<div class="col-md-12">
		                                <div class="form-group">
											<u><h5 style="padding-bottom: 15px !important;"><strong style="text-decoration: underline !important">Guarantor Information</strong></h5></u>
		                                </div>
		                            </div>
									
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label style=""><span style="text-decoration: underline">Guarantors First Name:</span></label>
		                                    <input id="guarantor_firstname" type="text" name="guarantor_firstname" placeholder="Guarantors First Name" required="required">
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Guarantors Other Name:</label>
		                                    <input id="guarantor_othername" type="text" name="guarantor_othername" placeholder="Guarantors Other Name" required="required">
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Guarantors Last Name:</label>
		                                    <input id="guarantor_lastname" type="text" name="guarantor_lastname" placeholder="Guarantors Last Name" required="required">
		                                </div>
		                            </div>
		                        </div>
								
								<div class="row" style="padding-bottom: 15px !Important">
		                            <div class="col-md-8">
		                                <div class="form-group">
											<label>Guarantors Home Address:</label>
		                                    <input id="guarantor_address" type="text" name="guarantor_address" placeholder="Guarantors Home Address" required="required">
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>City:</label>
		                                    <input id="guarantor_city" type="text" name="guarantor_city" placeholder="City" required="required">
		                                </div>
		                            </div>
		                        </div>
								
								<div class="row" style="padding-bottom: 15px !Important">
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>Country Guarantor Is Located:</label>
		                                    <select id="guarantor_country_id" name="guarantor_country" required="required">
												@foreach($countries as $country)
												<option value="{{$country->id}}|||{{$country->name}}">{{$country->name}}</option>
												@endforeach
											</select>
		                                </div>
		                            </div>
									
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>Province:</label>
		                                    <select id="guarantor_state_id" name="guarantor_state_id" required="required">
											</select>
		                                </div>
		                            </div>

		                            
		                            <div class="col-md-4">
		                                <div class="form-group">
											<label>District:</label>
		                                    <select id="guarantor_lga_id" name="guarantor_district" required="required">
											</select>
		                                </div>
		                            </div>
		                        </div>
								
								
								<div class="row" style="padding-bottom: 15px !Important">

		                             <div class="col-md-4">
		                                <div class="form-group">
											<div class="col-md-4" style="padding-left: 0px !important; padding-right: 0px !important;">
												<label>Country Code</label>
												<select id="guarantor_prefix" class="" name="guarantor_prefix" required="required">
													<option value="260">+260</option>
													<option value="234">+234</option>
												</select>
											</div>
											<div class="col-md-8" style="padding-left: 5px !important; padding-right: 0px !important;">
												<label>Guarantors Mobile Number:</label>
												<input id="guarantor_mobileNumber" class="col-md-8" type="number" name="guarantor_mobileNumber" placeholder="Guarantors Mobile Number" required="required">
											</div>
		                                </div>
		                            </div>

		                             <div class="col-md-4">
		                                <div class="form-group">
											<label>Guarantors Gender:</label>
		                                    <select id="guarantor_gender" class="" name="guarantor_gender" required="required">
												<option value="Female">Female</option>
												<option value="Male">Male</option>
											</select>
		                                </div>
		                            </div>
		                        </div>
								
								
								
								
								
		                        <div class="row">
		                            <div class="col-md-12">
		                                <input type="submit" value="Back" class="btn btn-warning">
										<input type="submit" value="Submit" class="btn btn-success pull-right">
		                                <input type="submit" value="Cancel" class="btn btn-danger pull-right" style="margin-right: 5px;">
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
		
		<script>
		$("#guarantor_country_id").on('change', function () {
			var $this = $(this);
            var state = $("#guarantor_state_id");
            var country_id = $(this).val();
			country_id = country_id.split('|||');
			if(country_id.length>0)
			{
				country_id = country_id[0];
				state.html('--Loading--');
				$.ajax({
					url: '/get_state_by_country/' + country_id,
					dataType: 'json',
					success: function (resp) {

						if (resp.status === 1) {
							state.empty();
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
						$("#guarantor_state_id").removeClass('disabled');
					}
				});
			}

            
		});
		
		
		$("#guarantor_state_id").change(function () {
			var $this = $(this);
			var lga = $("#guarantor_lga_id");
			var state_id = $(this).val();
			lga.html('--Loading--');
			$.ajax({
				url: '/get_lga_by_state/' + state_id,
				dataType: 'json',
				success: function (resp) {
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
					$("#guarantor_lga_id").removeClass('disabled');
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

    </body>

<!-- Mirrored from www.innovationplans.com/idesign/daniels/main.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Sep 2019 13:16:00 GMT -->
</html>

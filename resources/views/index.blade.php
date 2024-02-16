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
		<!--<link rel="stylesheet" href="/css/bootstrap-dropdownhover.min.css">-->

		<!-- Font Icon Core CSS -->
		<link rel="stylesheet" href="/css/font-awesome.min.css">
		<link rel="stylesheet" href="/css/et-line.css">

		<!-- Core Style Css -->
        <link rel="stylesheet" href="/css/style.css">
		<link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
		<link href="https://fonts.googleapis.com/css2?family=Muli:wght@200;300;600&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <!--[if lt IE 9]-->
		<script src="/js/html5shiv.min.js"></script>
		<!--[endif]-->

		<style>
		input:focus{
			outline: none !important;
		}
		
		input.middle:focus {
			outline-width: 0 !important;
		}
		
		.dropdown-toggle{
			background-color: transparent;
		}
		
		body{
			font-size: 12px !important;
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

		<!-- ====== Header ======  -->
		<section id="home" class="header" data-scroll-index="0" style="background-image: url(/images/carpenter.jpg);" data-stellar-background-ratio="0.8">

			<div class="v-middle" style="top: 45% !important">
				<div class="container">
					<div class="row">

						<!-- caption -->
						<div class="caption">
							<h5>We Have</h5>
							<h1 class="cd-headline clip" style="padding-bottom: 20px !important">
					            <!--<span class="blc">Looking For </span>--><!--onclick="javascript:handleRedirectToSkill('skill->skill_slug')"-->
					            <span class="cd-words-wrapper">
					            <?php $i=0; ?>
								@foreach($skills as $skill)
									@if($i++==0)
										<b class="is-visible"><span style="padding-top: 0px !important; cursor: pointer !important; color: #49c5b6 !important; text-decoration: none !important; font-weight: bold">{{$skill->skill_name}}</span></b>
									@else
										<b><span style="padding-top: 0px !important; cursor: pointer !important; color: #49c5b6 !important; text-decoration: underline !important; font-weight: bold">{{$skill->skill_name}}</span></b>
									@endif
								@endforeach
									
					            </span>
			          		</h1>
							
							<!----><h1 class="" style="font-size: 40px; padding-top: 20px !important">
					            <span class="blc">I Need A/An </span>
					            <span class="">
									<!--<input type="text" name="search" autocomplete="off" style="color: #ff9900 !important; font-weight: bold !important; background-color: transparent !important; border: 0px; border-bottom: 3px #ff9900 solid !important">-->
									<div class="dropdown">
										<input id="category-search" name="category-search" type="text" style="height: auto !important; font-size: 40px !important; color: #ff9900 !important; font-weight: bold !important; background-color: transparent !important; border: 0px; border-bottom: 3px #ff9900 solid !important" maxlength="30" placeholder="Type What you need" autocomplete="off" class="jAuto i-need">
										<i class="icon-feather-search"></i>
										<input type="hidden" name="inspection-required" id="inspection-required" value="-1">
										<input id="txtNumber" placeholder="Your budget? e.g 3000" type="hidden" name="txtNumber" value="1000" maxlength="10">
										

										<div class="dropdown-menu" style="width: 100% !important; padding: 0px !important;">
											<div class="list-autocomplete">
												
													@foreach($skills as $skill)
													<div type="button" class="dropdown-item" style="font-weight: bold !important; background-color:# fff !important; border-radius: 0 !important; padding: 10px !important; width: 100%; font-size: 20px; color: #000; text-align: left !important; text-decoration: none !important; display: none;" onclick="handleSelectorForSkill('{{$skill->id}}|||1|||{{$skill->skill_name}}')">{{$skill->skill_name}}</div>
													@endforeach
													<!--<div type="button" class="dropdown-item" style="background-color:# fff !important; border-radius: 0 !important; padding: 10px !important; width: 100%; font-size: 20px; color: #000; text-align: left !important; text-decoration: none !important; display: none;" onclick="handleSelectorForSkill('1|||2|||Girls')">Girls</div>
													<div type="button" class="dropdown-item" style="background-color:# fff !important; border-radius: 0 !important; padding: 10px !important; width: 100%; font-size: 20px; color: #000; text-align: left !important; text-decoration: none !important; display: none;" onclick="handleSelectorForSkill('2|||3|||Child')">Child</div>-->
													
												
												<div class="hasNoResults" style="display: block">No matching results found</div>
											</div>
										</div>
									</div>
					            </span>
								
			          		</h1>

			          		<!-- social icons -->
			          		<div class="social-icon col-md-12">
								<div style="clear: both !important" class="col-md-12">
									
									<h5><button class="btn btn-success" style="font-size: 20px !important">Create A Project</button></h5>
								</div>
			          			<a href="#0" style="text-decoration: none !important; font-weight: bold">
			          				<span><i class="fa fa-facebook" aria-hidden="true"></i></span>
			          			</a>
			          			<a href="#0" style="text-decoration: none !important; font-weight: bold">
			          				<span><i class="fa fa-twitter" aria-hidden="true"></i></span>
			          			</a>
			          			<a href="#0" style="text-decoration: none !important; font-weight: bold">
			          				<span><i class="fa fa-youtube" aria-hidden="true"></i></span>
			          			</a>
			          		</div>
						</div>
						<!-- end caption -->
					</div>
				</div><!-- /row -->
			</div><!-- /container -->
		</section>
		<!-- ====== End Header ======  -->

		<!-- ====== Hero ======  -->
		<section class="hero section-padding pb-70" data-scroll-index="1">
			<div class="container">
				<div class="row">

					<!-- hero image -->
					<div class="col-md-5">
						<div class="hero-img mb-30">
							<img src="img/hero.jpg" alt="">
						</div>
					</div>

					<!-- content -->
					<div class="col-md-7">
						<div class="content mb-30">
							<h3>Top Artisan.</h3>
							<span class="sub-title">Tailor | </span>
							<span class="sub-title">Lusaka | 13 Projects</span>
							<p>I am <b>Jerry Daniels</b> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever It has survived not only five centuries, but also the leap into electronic  but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing</p>

							<!-- skills progress -->
							<div class="skills">
								<div class="item">
									<div class="skills-progress">
										<h6>Tailoring</h6>
										<span data-value="95%"></span>
									</div>
								</div>
								<div class="item">
									<div class="skills-progress">
										<h6>Plumbing</h6>
										<span data-value="80%"></span>
									</div>
								</div>
								<div class="item">
									<div class="skills-progress">
										<h6>Carpentary</h6>
										<span data-value="90%"></span>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>

						</div>
					</div>
				</div><!-- /row -->
			</div><!-- /container -->
		</section>
		<!-- ====== End Hero ======  -->

		

		<!--====== Portfolio ======-->
		<section class="portfolio section-padding pb-70" data-scroll-index="3">
			<div class="container">
				<div class="row">

					<!-- section heading -->
					<div class="section-head">
						<h3>Our Services</h3>
					</div>

					<!-- filter links -->
					<!--<div class="filtering text-center mb-50">
						<span data-filter='*' class="active">All</span>
						<span data-filter='.brand'>Brand</span>
						<span data-filter='.web'>Design</span>
						<span data-filter='.graphic'>Graphic</span>
					</div>-->

					<!-- gallery -->
					<div class="gallery text-center">

						<!-- gallery item -->
						<div class="col-md-4 col-sm-6 items graphic">
							<div class="item-img">
								<img src="img/portfolio/1.jpg" alt="image">
								<div class="item-img-overlay">
									<div class="overlay-info v-middle text-center">
										<h6 class="sm-titl">WEB DESIGN</h6>
										<div class="icons">
											<span class="icon">
												<a href="#0">
													<i class="fa fa-chain-broken" aria-hidden="true"></i>
												</a>
											</span>

											<span class="icon link">
												<a href="img/portfolio/1.jpg">
													<i class="fa fa-search-plus" aria-hidden="true"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- gallery item -->
						<div class="col-md-4 col-sm-6 items web">
							<div class="item-img">
								<img src="img/portfolio/2.jpg" alt="image">
								<div class="item-img-overlay">
									<div class="overlay-info v-middle text-center">
										<h6 class="sm-titl">WEB DESIGN</h6>
										<div class="icons">
											<span class="icon">
												<a href="#0">
													<i class="fa fa-chain-broken" aria-hidden="true"></i>
												</a>
											</span>

											<span class="icon link">
												<a href="img/portfolio/2.jpg">
													<i class="fa fa-search-plus" aria-hidden="true"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- gallery item -->
						<div class="col-md-4 col-sm-6 items graphic">
							<div class="item-img">
								<img src="img/portfolio/3.jpg" alt="image">
								<div class="item-img-overlay">
									<div class="overlay-info v-middle text-center">
										<h6 class="sm-titl">WEB DESIGN</h6>
										<div class="icons">
											<span class="icon">
												<a href="#0">
													<i class="fa fa-chain-broken" aria-hidden="true"></i>
												</a>
											</span>

											<span class="icon link">
												<a href="img/portfolio/3.jpg">
													<i class="fa fa-search-plus" aria-hidden="true"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- gallery item -->
						<div class="col-md-4 col-sm-6 items brand">
							<div class="item-img">
								<img src="img/portfolio/4.jpg" alt="image">
								<div class="item-img-overlay">
									<div class="overlay-info v-middle text-center">
										<h6 class="sm-titl">WEB DESIGN</h6>
										<div class="icons">
											<span class="icon">
												<a href="#0">
													<i class="fa fa-chain-broken" aria-hidden="true"></i>
												</a>
											</span>

											<span class="icon link">
												<a href="img/portfolio/4.jpg">
													<i class="fa fa-search-plus" aria-hidden="true"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- gallery item -->
						<div class="col-md-4 col-sm-6 items web graphic">
							<div class="item-img">
								<img src="img/portfolio/5.jpg" alt="image">
								<div class="item-img-overlay">
									<div class="overlay-info v-middle text-center">
										<h6 class="sm-titl">WEB DESIGN</h6>
										<div class="icons">
											<span class="icon">
												<a href="#0">
													<i class="fa fa-chain-broken" aria-hidden="true"></i>
												</a>
											</span>

											<span class="icon link">
												<a href="img/portfolio/5.jpg">
													<i class="fa fa-search-plus" aria-hidden="true"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- gallery item -->
						<div class="col-md-4 col-sm-6 items brand">
							<div class="item-img">
								<img src="img/portfolio/6.jpg" alt="image">
								<div class="item-img-overlay">
									<div class="overlay-info v-middle text-center">
										<h6 class="sm-titl">WEB DESIGN</h6>
										<div class="icons">
											<span class="icon">
												<a href="#0">
													<i class="fa fa-chain-broken" aria-hidden="true"></i>
												</a>
											</span>

											<span class="icon link">
												<a href="img/portfolio/6.jpg">
													<i class="fa fa-search-plus" aria-hidden="true"></i>
												</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div><!-- /row -->
			</div><!-- /container -->
		</section>
		<!--====== End Portfolio ======-->

		<!--====== Clients ======-->
		<section class="clients section-padding bg-gray" data-scroll-index="4">
			<div class="container">
				<div class="row">

					<!-- section heading -->
					<div class="section-head">
						<h3>Testimonials.</h3>
					</div>

					<!-- owl carousel -->
					<div class="col-md-offset-1 col-md-10">
						<div class="owl-carousel owl-theme text-center">

							<!-- citems -->
							<div class="citem">
								<div class="author-img">
									<img src="img/clients/1.jpg" alt="">
								</div>
								<p>Lorem Ipsum has been the industry's standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
								<h6>Alex Smith</h6>
								<span>Envato Customer</span>
							</div>

							<div class="citem">
								<div class="author-img">
									<img src="img/clients/1.jpg" alt="">
								</div>
								<p>Lorem Ipsum has been the industry's standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
								<h6>Alex Smith</h6>
								<span>Envato Customer</span>
							</div>

							<div class="citem">
								<div class="author-img">
									<img src="img/clients/1.jpg" alt="">
								</div>
								<p>Lorem Ipsum has been the industry's standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
								<h6>Alex Smith</h6>
								<span>Envato Customer</span>
							</div>
						</div>
					</div>
				</div><!-- /row -->
			</div><!-- /container -->
		</section>
		<!--====== End clients ======-->

		<!--====== Numbers ======-->
		<div class="numbers section-padding text-center pb-70">
			<div class="container">
				<div class="row">

					<!-- items -->
					<div class="col-md-3">
						<div class="item">
							<span class="icon"><i class="fa fa-users" aria-hidden="true"></i></span>
							<h3 class="counter">850</h3>
							<p>Happy Customers</p>
						</div>
					</div>

					<div class="col-md-3">
						<div class="item">
							<span class="icon"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
							<h3 class="counter">230</h3>
							<p>Complete Projects</p>
						</div>
					</div>

					<div class="col-md-3">
						<div class="item">
							<span class="icon"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
							<h3 class="counter">9450</h3>
							<p>Posted</p>
						</div>
					</div>

					<div class="col-md-3">
						<div class="item">
							<span class="icon"><i class="fa fa-cloud-download" aria-hidden="true"></i></span>
							<h3 class="counter">780</h3>
							<p>Earned</p>
						</div>
					</div>

				</div><!-- /row -->
			</div><!-- /container -->
		</div>
		<!--====== End Numbers ======-->

		

		<!--====== Contact ======-->
		<section class="contact section-padding" data-scroll-index="6">
			<div class="container">
				<div class="row">
					
					<!-- section heading -->
					<div class="section-head">
						<h3>Contact Us.</h3>
					</div>

					<div class="col-md-offset-1 col-md-10">

						<!-- contact info -->
						<div class="info text-center mb-50">

							<div class="col-md-4">
								<div class="item">
									<span class="icon"><i class="fa fa-location-arrow" aria-hidden="true"></i></span>
									<h6>Address</h6>
									<p>6834 Hollywood Blvd - Los Angeles CA</p>
								</div>
							</div>

							
							<div class="col-md-12">
								
							</div>
							
							<div class="col-md-4">
								<div class="item">
									<span class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
									<h6>Email</h6>
									<p>Support@website.com</p>
								</div>
							</div>

							<div class="col-md-4">
								<div class="item">
									<span class="icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
									<h6>Phone</h6>
									<p>+20 010 2517 8918</p>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>

						<!-- contact form -->
						<form class="form" id="contact-form" method="post" action="http://www.innovationplans.com/idesign/daniels/contact.php">
		                    <div class="messages"></div>

		                    <div class="controls">

		                        <div class="row">
		                            <div class="col-md-6">
		                                <div class="form-group">
		                                    <input id="form_name" type="text" name="name" placeholder="Name" required="required">
											<input class="awesomplete"
       data-list="Ada, Java, JavaScript, Brainfuck, LOLCODE, Node.js, Ruby on Rails" />
		                                </div>
		                            </div>

		                             <div class="col-md-6">
		                                <div class="form-group">
		                                    <input id="form_email" type="email" name="email" placeholder="Email" required="required">
		                                </div>
		                            </div>
		                        </div>
		                        <div class="row">
		                            <div class="col-md-12">
		                                <div class="form-group">
		                                    <textarea id="form_message" name="message" placeholder="Message" rows="4" required="required"></textarea>
		                                </div>

		                                <input type="submit" value="Submit" class="buton buton-bg">
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
		<!--<script src="/js/bootstrap-dropdownhover.min.js"></script>-->

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

		
		<!--<script src="/awesomplete-gh-pages/awesomplete.min.js"></script>
		<script src="/awesomplete-gh-pages/index.js"></script>
		<link rel="stylesheet" href="/awesomplete-gh-pages/awesomplete.css">-->
		<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </body>


<script>

function createAuto(i, elem) {

  var input = $(elem);
  var dropdown = input.closest('.dropdown');
  var listContainer = dropdown.find('.list-autocomplete');
  var listItems = listContainer.find('.dropdown-item');
  var hasNoResults = dropdown.find('.hasNoResults');

  listItems.hide();
  listItems.each(function () {
    $(this).data('value', $(this).text());
    //!important, keep this copy of the text outside of keyup/input function
  });

  input.on("input", function (e) {

    if ((e.keyCode ? e.keyCode : e.which) == 13) {
      $(this).closest('.dropdown').removeClass('open').removeClass('in');
      return; //if enter key, close dropdown and stop
    }
    if ((e.keyCode ? e.keyCode : e.which) == 9) {
      return; //if tab key, stop
    }


    var query = input.val().toLowerCase();

    if (query.length > 0) {

      dropdown.addClass('open').addClass('in');

      listItems.each(function () {

        var text = $(this).data('value');
        if (text.toLowerCase().indexOf(query) > -1) {

          var textStart = text.toLowerCase().indexOf(query);
          var textEnd = textStart + query.length;
          var htmlR = text.substring(0, textStart) + '<em>' + text.substring(textStart, textEnd) + '</em>' + text.substring(textEnd);
          $(this).html(htmlR);
          $(this).show();

        } else {

          $(this).hide();

        }
      });

      var count = listItems.filter(':visible').length;
      count > 0 ? hasNoResults.hide() : hasNoResults.show();

    } else {
      listItems.hide();
      dropdown.removeClass('open').removeClass('in');
      hasNoResults.show();
    }
  });

  listItems.on('click', function (e) {
    var txt = $(this).text().replace(/^\s+|\s+$/g, ""); //remove leading and trailing whitespace
    input.val(txt);
    dropdown.removeClass('open').removeClass('in');
  });

}

$('.jAuto').each(createAuto);


$(document).on('focus', '.jAuto', function () {
  $(this).select(); // in case input text already exists
});

@if(isset($_REQUEST['activateaccount']) && $_REQUEST['activateaccount']==1)
	$(window).on("load", function() {
		@if(isset($_REQUEST['mobile-activate']))
			var mobile_activate = "{{$_REQUEST['mobile-activate']}}";
			document.getElementById('mobile_activate').value = mobile_activate;
		@endif
		//$('#activateAccountModal').modal('toggle');
		$('#activateAccountModal').modal('toggle');
		document.getElementById('activateAccountModal').style.display = 'block';
		document.getElementById('activateAccountModal').style.display = 'block';
		document.getElementById('activateAccountModal').classList.add("in")
	});
@endif

@if(isset($_REQUEST['loginnow']) && $_REQUEST['loginnow']==1)
	$(window).on("load", function() {
		displayLogin();
	});
@endif
		


@if(isset($_REQUEST['forgotpassword']) && $_REQUEST['forgotpassword']==1)
	$(window).on("load", function() {
		displayRecoverPassword();
	});
@endif


function handleRedirectToSkill(url)
{
	window.location = url;
}


@if(isset($_REQUEST['update-profile']))
	$(function () {
		$('.domals').modal('hide');
		$('#registerStepOneModal').modal('show');
		toastr.warning('Update your bio-data to start making use of our services. Please provide correct details as your details will be verified');
	});
@endif

</script>


@include('partials.notify')
<!-- Mirrored from www.innovationplans.com/idesign/daniels/main.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 25 Sep 2019 13:16:00 GMT -->
</html>



















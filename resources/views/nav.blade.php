<nav class="navbar navbar-default" style="background-color:#124062; opacity: 0.85 !important; padding: 10px 0 10px; padding-top: 10px !important; min-height: auto !important">
  <div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-icon-collapse" aria-expanded="false">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>

	   <!-- logo -->
		<a class="logo" href="/" style="position: absolute !important; top: 0px">
			<img src="/images/logo.png" style="width: 80px; border: 2px solid #fff;">
		</a>

	</div>

	<!-- Collect the nav links, and other content for toggling -->
	<div class="collapse navbar-collapse" id="nav-icon-collapse">
	  
	  <!-- links -->
	  <ul class="nav navbar-nav navbar-right">
		<li><a href="#" data-scroll-nav="0" class="active" class="navmenu" style="text-decoration: none !important">Home</a></li>
		<!--<li><a href="#" data-scroll-nav="1">About</a></li>-->
		<li><a href="/all-projects" class="navmenu" style="text-decoration: none !important">All Projects</a></li>
		<!--<li><a href="/all-projects">Who's On Our Team</a></li>
		<li><a href="/all-projects">Our Services</a></li>
		
		<li><a href="#" data-scroll-nav="2">Services</a></li>
		<li><a href="#" data-scroll-nav="3">Works</a></li>
		<li><a href="#" data-scroll-nav="4">Clients</a></li>
		<li><a href="#" data-scroll-nav="5">Blog</a></li>-->
		@if(\Auth::user())
			<!--<li><a href="/auth/logout" style="cursor:pointer">Log Out</a></li>
			<li><a href="/all-projects">Notifications({{$notifications->count()}})</a></li>
			<li><a href="/all-projects">Messages({{$messages_supreme->count()}})</a></li>-->
			
			<li class="dropdown">
				<!--<div>-->
				  <!--<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">-->
				  <a href="" class="dropdown-toggle navmenu" data-toggle="dropdown" data-hover="dropdown" style="text-decoration: none !important">
					Notifications({{$notifications->count()}}) <span class="caret"></span>
				  </a>
				  @if($notifications->count() > 0)
				  <ul class="dropdown-menu">
					@foreach($notifications as $notification)
					<li>
						<a href="{{$notification->notification_url}}" c>
							{!! $notification->notification_contents !!}
						</a>
					</li>
					@endforeach
					<li class="summary" style="text-align: center; "><hr style="margin-top: 0px !important; margin-bottom: 0px !important;"><a href="/admin/notifications">See All Notifications</a></li>
				  </ul>
				  @endif
				<!--</div>-->
			</li>
			
			<li class="dropdown" style="text-decoration: none !important">
				<!--<div>-->
				  <!--<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">-->
				  <a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" style="text-decoration: none !important">
				   Messages({{$messages_supreme->count()}}) <span class="caret"></span>
				  </a>
				  @if($messages_supreme->count() > 0)
				  <ul class="dropdown-menu">
					@foreach($messages_supreme as $message)
					<li>
						<a href="/admin/messages?msg={{$message->message_code}}">
						{{substr(strip_tags($message->message_body), 0, 35)}}...
						</a>
					</li>
					@endforeach
					<li class="summary" style="text-align: center"><hr style="margin-top: 0px !important; margin-bottom: 0px !important;"><a href="/admin/messages">See All Messages</a></li>
				  </ul>
				  @endif
				<!--</div>-->
			</li>
			
			
			
			<li class="dropdown" style="text-decoration: none !important">
				<!--<div>-->
				  <!--<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">-->
				  <a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" style="text-decoration: none !important">
				   Welcome  {{\Auth::user()->first_name}}! <span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu">
					<li><a href="/admin/dashboard">My Dashboard</a></li>
					@if(\Auth::user()->role_type=='Artisan')
						<li><a href="/admin/my-projects">My Projects</a></li>
					@elseif(\Auth::user()->role_type=='Private Client')
						<li><a href="/new-project-step-one">New Project</a></li>
						<li><a href="/admin/my-project-list">My Projects</a></li>
					@endif
					<li><a href="/admin/my-transactions">My Transactions</a></li>
					<!--<li><a href="/admin/my-transactions">Update My Profile</a></li>-->
					<li><a data-toggle="modal" data-target="#registerStepOneModal" style="cursor:pointer; text-decoration: none !important">Update My Profile</a></li>
					<!--<li><a href="/admin/my-profile">Update My Profile</a></li>-->
					<li><a href="/auth/logout">Log Out</a></li>
				  </ul>
				<!--</div>-->
			</li>
			
		@else
			<li><a data-toggle="modal" data-target="#loginModal" style="cursor:pointer; text-decoration: none !important">Login/Register</a></li>
		@endif
	  </ul>
	</div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>

@include('login')
@if(\Auth::user())
	<input type="hidden" id="roletype" name="roletype" value="{{\Auth::user()->role_type}}">
	@include('registerstepone')
	@include('registersteptwo')
	@include('registerstepthree')
@else
	@include('register')
	@include('forgotpassword')
	@include('activate')
@endif








<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            Homer Theme
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">HOMER APP</span>
        </div>
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="" href="login.html">Login</a>
                    </li>
                    <li>
                        <a class="" href="login.html">Logout</a>
                    </li>
                    <li>
                        <a class="" href="profile.html">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown">
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                        <i class="pe-7s-speaker"></i>
						<span class="label label-success">{{$notifications->count()}}</span>
                    </a>
                    <ul class="dropdown-menu hdropdown notification animated flipInX">
						@foreach($notifications as $notification)
                        <li>
                            <a href="{{$notification->notification_url}}">
								{!! $notification->notification_contents !!}
                            </a>
                        </li>
						@endforeach
                        <li class="summary"><a href="/notifications/all">See all notifications</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                        <i class="pe-7s-mail"></i>
                        <span class="label label-success">{{$messages_supreme->count()}}</span>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">
                            You have {{$messages_supreme->count()}} new messages
                        </div>
						@foreach($messages_supreme as $message)
                        <li>
                            <a href="/admin/messages?msg={{$message->message_code}}">
							{{substr(strip_tags($message->message_body), 0, 15)}}...
                            </a>
                        </li>
						@endforeach
                        <li class="summary"><a href="/admin/messages">See All Messages</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="/auth/logout">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
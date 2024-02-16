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

    <!-- App styles -->
    <link rel="stylesheet" href="/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="/styles/style.css">

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

<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
					<li><a href="/" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a></li>
					@foreach($breadcrumbs as $breadcrumb)
					
						@if($breadcrumb['active']==1)
							<li><span class="breadcrumb-item active">{{$breadcrumb['name']}}</span></li>
						@else
							<li><span class="breadcrumb-item"><a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a></span></li>
						@endif
					@endforeach
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                {{$header}}
            </h2>
            <small>{{$detail}}</small>
        </div>
    </div>
</div>

<div class="content">

<div>
    <div class="row">
        <div class="col-lg-6">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        <a class="closebox"><i class="fa fa-times"></i></a>
                    </div>
                    Add New Skill(s)
                </div>
                <div class="panel-body">
                <form method="post" action="/admin/new-skill{{isset($listId) && $listId!=null ? '/'.$listId : ''}}" class="form-horizontal">
				@if(isset($skill) && $skill!=null)
					<div class="form-group"><label class="col-sm-3 control-label">Skill:</label>

						<div class="col-sm-5"><input type="text" name="skillname" class="form-control" value="{{$skill->skill_name}}"></div>
						<div class="col-sm-4"><input type="checkbox" name="inspection_required"  value="1" class="" {{$skill->inspection_required!=null && $skill->inspection_required==1 ? 'checked' : ''}}> Requires Inspection?</div>
						
					</div>
					<div class="hr-line-dashed"></div>
				@else
					@for($i=0; $i<10; $i++)
						<div class="form-group"><label class="col-sm-3 control-label">Skill #{{($i+1)}}:</label>

							<div class="col-sm-5"><input type="text" name="skillname[]" class="form-control"></div>
							<div class="col-sm-4"><input type="checkbox" name="inspection_required[]" value="{{($i+1)}}" class=""> Requires Inspection?</div>
							
						</div>
						<div class="hr-line-dashed"></div>
					@endfor
				@endif
					<div class="form-group">
						<div class="col-sm-12">
							<button class="btn btn-danger" type="submit">Cancel</button>
							<button class="btn btn-success pull-right" type="submit">Save changes</button>
						</div>
					</div>
                </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
        <div class="hpanel">
        
        </div>
        </div>
    </div>

</div>

</div>

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

<!-- Vendor scripts -->
<script src="/vendor/jquery/dist/jquery.min.js"></script>
<script src="/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="/vendor/iCheck/icheck.min.js"></script>
<script src="/vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="/scripts/homer.js"></script>
<script src="/js/bootstrap-notify.js"></script>
@include('scripts')

</body>
</html>
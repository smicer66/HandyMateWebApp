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

<!-- Skin option / for demo purpose only -->
<!-- End skin option / for demo purpose only -->

<!-- Header -->
@include('admin.header')

<!-- Navigation -->
@include('admin.side-menu')

<!-- Main Wrapper -->
<div id="wrapper">

    <div class="content">
        <div class="row">
            <div class="col-lg-12 text-center welcome-message">
                <h2>
                    HandyMade
                </h2>

                <p>
                    Hey <strong>{{ucwords(strtolower(\Auth::user()->first_name))}}!</strong> Workers, Artisans and Other Professionals Are Waiting To Work On Your Project
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a class="closebox"><i class="fa fa-times"></i></a>
                        </div>
                        Your Project & Transaction Statistics
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <div class="small">
                                    <i class="fa fa-bolt"></i> Projects
                                </div>
                                <div>
                                    <h1 class="font-extra-bold m-t-xl m-b-xs">
										{{$projects->count()}}
                                    </h1>
                                    <small>All of your projects</small>
                                </div>
                                <div class="small m-t-xl">
                                    <i class="fa fa-clock-o"></i> Data from January
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center small">
                                    <i class="fa fa-laptop"></i> Your projects over the last few months
                                </div>
                                <div class="flot-chart" style="height: 160px">
                                    <div class="flot-chart-content" id="flot-line-chart"></div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="small">
                                    <i class="fa fa-clock-o"></i> Duration
                                </div>
                                <div>
                                    <h1 class="font-extra-bold m-t-xl m-b-xs">
                                        8 Months
                                    </h1>
                                </div>
                                <div class="small m-t-xl">
                                    <i class="fa fa-clock-o"></i> Last Project created on
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                    <span class="pull-right">
                          Our service charges drop with more projects you create
                    </span>
                        Last update: 21.05.2015
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="hpanel">
                    <div class="panel-body text-center h-200">
                        <i class="pe-7s-graph1 fa-4x"></i>

						@foreach($clientProjectsSupreme as $curr => $cps)
							<h1 class="m-xs"><small>{{$curr}}{{number_format($cps, 2, '.', ',')}}</small></h1>
						@endforeach

                        <h3 class="font-extra-bold no-margins text-success">
                            Total Budget
                        </h3>
                        <small>This represents the total amount you have budgeted for your projects.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="hpanel">
                    <div class="panel-body text-center h-200">
                        <i class="pe-7s-graph1 fa-4x"></i>

						@foreach($walletTransactions as $curr => $cps)
							<h1 class="m-xs"><small>{{$curr}}{{number_format($cps, 2, '.', ',')}}</small></h1>
						@endforeach

                        <h3 class="font-extra-bold no-margins text-success">
                            Paid Out
                        </h3>
                        <small>Represents the total amount you have paid to workers for your projects.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="hpanel stats">
                    <div class="panel-body h-200">
                        <div class="stats-title pull-left">
                            <h4>Bids</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="pe-7s-monitor fa-4x"></i>
                        </div>
                        <div class="m-t-xl">
                            <h1 class="text-success">{{$projectBids->count()}}</h1>
                    <span class="font-bold no-margins">
                        All Bids
                    </span>
                            <br/>
                            <small>
                                All Bids placed on my projects.
                                <a href="/admin/projects" class="btn btn-primary">View Projects</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="hpanel stats">
                    <div class="panel-body h-200">
                        <div class="stats-title pull-left">
                            <h4>My Wallet</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="pe-7s-cash fa-4x"></i>
                        </div>
                        <div class="clearfix"></div>
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-income-chart"></div>
                        </div>
                        <div class="m-t-xs">

                            <div class="row">
                                <div class="col-xs-12">
                                    <small class="stat-label">Balance</small>
									@if(isset($wallet) && $wallet!=null)
										<h4>{{$wallet->currency}}{{number_format($wallet->current_balance, 2, '.', ',')}} </h4>
									@else
										<h4>{{number_format(0, 2, '.', ',')}} </h4>
									@endif
                                </div>
								@if(isset($wallet) && $wallet!=null)
                                <div class="col-xs-7">
                                    <small class="stat-label">Wallet Code</small>
                                    <h4>{{strtoupper(join('-', str_split($wallet->wallet_number, 4)))}} <i class="fa fa-level-up text-success"></i></h4>
                                </div>
								@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-lg-12">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                            <a class="closebox"><i class="fa fa-times"></i></a>
                        </div>
                        Recent projects
                    </div>
                    <div class="panel-body list">
                        <div class="table-responsive project-list">
                            <table class="table table-striped">
                                <thead>
                                <tr>

                                    <th colspan="2">Project</th>
                                    <th>Status</th>
                                    <th>Service Date</th>
                                    <th>Action</th>
                                    <th>Budget</th>
                                </tr>
                                </thead>
                                <tbody>
								@foreach($projects as $project)
                                <tr>
                                    <td><input type="checkbox" class="i-checks" checked></td>
                                    <td>{{$project->title}}
                                        <br/>
                                        <small><i class="fa fa-clock-o"></i> Created {{date('d, M Y', strtotime($project->created_at))}}</small>
                                    </td>
                                    <td>
										<span class="">{{$project->status}}</span>
                                    </td>
                                    <td>{{date('d, M Y', strtotime($project->expected_start_date))}}</td>
                                    <td>{{$project->state->name}}</td>
                                    <td><strong>({{$project->project_currency}}){{number_format($project->budget, 2, '.', ',')}}</strong></td>
                                </tr>
								@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Right sidebar -->
    
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
<script src="/vendor/jquery-flot/jquery.flot.js"></script>
<script src="/vendor/jquery-flot/jquery.flot.resize.js"></script>
<script src="/vendor/jquery-flot/jquery.flot.pie.js"></script>
<script src="/vendor/flot.curvedlines/curvedLines.js"></script>
<script src="/vendor/jquery.flot.spline/index.js"></script>
<script src="/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="/vendor/iCheck/icheck.min.js"></script>
<script src="/vendor/peity/jquery.peity.min.js"></script>
<script src="/vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="/scripts/homer.js"></script>
<script src="/scripts/charts.js"></script>
<script src="/js/bootstrap-notify.js"></script>

<script>

    $(function () {

        /**
         * Flot charts data and options
         */
        var data1 = [ [0, 55], [1, 48], [2, 40], [3, 36], [4, 40], [5, 60], [6, 50], [7, 51] ];
        var data2 = [ [0, 56], [1, 49], [2, 41], [3, 38], [4, 46], [5, 67], [6, 57], [7, 59] ];

        var chartUsersOptions = {
            series: {
                splines: {
                    show: true,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
            },
            grid: {
                tickColor: "#f0f0f0",
                borderWidth: 1,
                borderColor: 'f0f0f0',
                color: '#6a6c6f'
            },
            colors: [ "#62cb31", "#efefef"],
        };

        $.plot($("#flot-line-chart"), [data1, data2], chartUsersOptions);

        /**
         * Flot charts 2 data and options
         */
        var chartIncomeData = [
            {
                label: "line",
                data: [ [1, 10], [2, 26], [3, 16], [4, 36], [5, 32], [6, 51] ]
            }
        ];

        var chartIncomeOptions = {
            series: {
                lines: {
                    show: true,
                    lineWidth: 0,
                    fill: true,
                    fillColor: "#64cc34"

                }
            },
            colors: ["#62cb31"],
            grid: {
                show: false
            },
            legend: {
                show: false
            }
        };

        $.plot($("#flot-income-chart"), chartIncomeData, chartIncomeOptions);



    });

</script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-4625583-2', 'webapplayers.com');
        ga('send', 'pageview');

    </script>
	@include('scripts')

</body>
</html>
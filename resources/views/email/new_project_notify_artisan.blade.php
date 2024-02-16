<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Sign Up - HandyMade</title>
    <style>
        /* -------------------------------------
                GLOBAL
        ------------------------------------- */
        * {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            font-size: 100%;
            line-height: 1.6;
        }

        img {
            max-width: 100%;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
        }

        /* -------------------------------------
                ELEMENTS
        ------------------------------------- */
        a {
            color: #348eda;
        }

        .btn-primary {
            text-decoration: none;
            color: #FFF;
            background-color: #348eda;
            border: solid #348eda;
            border-width: 10px 20px;
            line-height: 2;
            font-weight: bold;
            margin-right: 10px;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            border-radius: 25px;
        }

        .btn-secondary {
            text-decoration: none;
            color: #FFF;
            background-color: #aaa;
            border: solid #aaa;
            border-width: 10px 20px;
            line-height: 2;
            font-weight: bold;
            margin-right: 10px;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            border-radius: 25px;
        }

        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .padding {
            padding: 10px 0;
        }

        /* -------------------------------------
                BODY
        ------------------------------------- */
        table.body-wrap {
            width: 100%;
            padding: 20px;
        }

        table.body-wrap .container {
            border: 1px solid #f0f0f0;
        }

        /* -------------------------------------
                FOOTER
        ------------------------------------- */
        table.footer-wrap {
            width: 100%;
            clear: both !important;
        }

        .footer-wrap .container p {
            font-size: 12px;
            color: #666;

        }

        table.footer-wrap a {
            color: #999;
        }

        /* -------------------------------------
                TYPOGRAPHY
        ------------------------------------- */
        h1, h2, h3 {
            font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            color: #000;
            margin: 40px 0 10px;
            line-height: 1.2;
            font-weight: 200;
        }

        h1 {
            font-size: 36px;
        }

        h2 {
            font-size: 28px;
        }

        h3 {
            font-size: 22px;
        }

        p, ul, ol {
            margin-bottom: 10px;
            font-weight: normal;
            font-size: 14px;
        }

        ul li, ol li {
            margin-left: 5px;
            list-style-position: inside;
        }

        /* ---------------------------------------------------
                RESPONSIVENESS
                Nuke it from orbit. It's the only way to be sure.
        ------------------------------------------------------ */

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important; /* makes it centered */
            clear: both !important;
        }

        /* Set the padding on the td rather than the div for Outlook compatibility */
        .body-wrap .container {
            padding: 20px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
        }

        /* Let's make sure tables in the content area are 100% wide */
        .content table {
            width: 100%;
        }

    </style>
</head>

<body bgcolor="#f6f6f6">
<!-- body -->
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td>
                            <div style="text-align: center">
                                <img src="http://handymade.com/img/" height="80px">
                            </div>
                            
								<?php
								$skills = [];
								foreach($project->skills as $skill)
								{
									array_push($skills, $skill->skill->skill_name);
								}
								?>
								<h2 style="font-weight: bold">New Project Posted!</h2><br>
								Dear {{ucwords(strtolower($first_name))}}, <br>
								We have a new project posted on our site. This project matches one of the skills listed on your profile. <br>
								You can place a bid to handle this project. <br>
								Before we tell you how to place a bid on this task, take a look at the project details<br>
								<hr>
								<u>Project Title:</u> <span style="float:right !important">{{$project->title}}</span><br>
								<u>Posted By:</u> <span style="float:right !important">{{$project->created_by_user->last_name . ' ' . $project->created_by_user->first_name}}</span><br>
								<u>Expected Start Date:</u> <span style="float:right !important">{{date('d, M Y', strtotime($project->expected_start_date))}}</span><br>
								<u>Skills Needed:</u> 
											@if(sizeof($skills)>0)
												<span style="float:right !important">{{join(', ', $skills)}}</span>
											@endif
											<br>
								<u>Budget:</u> <span style="float:right !important">({{$project->project_currency}}){{number_format($project->budget, 2, '.', ',')}}</span><br>
								<u>Bidding Ends:</u> 
											<?php 
											$createdDate = $project->created_at;
											$bidEnds = $createdDate->addDays($project->bidding_period);
											?>
											<span style="float:right !important">{{date('d, M Y', strtotime($bidEnds))}}</span><br>
								<u>Project Location:</u> 
											<span style="float:right !important">{{$project->project_location}}</span><br>
											<span style="float:right !important">{{$project->city}}</span><br>
											<span style="float:right !important">{{$project->state->name}}</span><br>
											<br>
								<hr>
								To place a bid, simply click on the link - <u><a href="http://handymade.com/project-details/{{$project->project_url}}">{{$project->title}}</a></u> - scroll down to the bid section to provide your bid details.<br><br>
								
								@if($otherProjects->count() > 0)
								<strong>A Few Projects You May Also Be Interested In ...</strong><br>
								@endif
								<?php 
								$i = 1;
								?>
								@foreach($otherProjects as $project)
									{{$i++}}. <u><a href="http://handymade.com/project-details/{{$project->project_url}}">{{$project->title}}</a></u><br>
									<span style="text-decoration:underline !important">Delivery Period:</span>
									<span style="float:right !important">{{date('d, M Y', strtotime($project->expected_completion_date))}}</span><br>
									<span style="text-decoration:underline !important">Budget:</span>
									<span style="float:right !important">({{$project->project_currency}}){{number_format($project->budget, 2, '.', ',')}}</span><br>
									<span style="text-decoration:underline !important">Bids End:</span>
									
									<span style="float:right !important">{{date('d, M Y', strtotime($project->expected_completion_date))}}</span><br>
									<span style="text-decoration:underline !important">Location:</span>
									<span style="float:right !important">{{$project->state==null ? "N/A" : $project->state->name}}</span><br><br>
									<hr>
								@endforeach
                            
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->

        </td>
        <td></td>
    </tr>
</table>
<!-- /body -->
<!-- footer -->
<table class="footer-wrap">
    <tr>
        <td></td>
        <td class="container">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td align="center">
                            <p>
                                You recieved this email because HandyMade provides a service you signed up for.<br>
                                HandyMade is a Freelancing System. HandyMade is a product of Probase Zambia<br />
                                <small>Do Not Reply To This Email</small>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->
			
        </td>
        <td></td>
    </tr>
</table>
<!-- /footer -->
</body>
</html>

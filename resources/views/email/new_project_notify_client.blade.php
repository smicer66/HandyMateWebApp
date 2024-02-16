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
								<h2 style="font-weight: bold">Your New Project Has Been Posted!</h2><br>
								Dear {{ucwords(strtolower($first_name))}}, <br>
								We have posted your new project on our website. We expect bids from workers who have registered on our website. <br>
								For each bid placed we will notify you on the bid submitted. <br>
								You can at any time before the bidding ends select a winning bid for your project. The worker who places the winning bid will be expected to 
								work with you when you select a winning bid. As a result we will be sharing your contact details with your selected bidder when you select a 
								winning bid.<br><br>
								Kindly note the following:<br>
								1. We can only welcome bids having bid amounts less than your budget for this project.<br>
								2. You can increase your budget at anytime before you select a winning bid for this project.<br>
								3. You can cancel this project if you have not assigned a winning bid to this project.<br>
								4. On cancelation of this project, your budget will be refunded in addition to any taxes paid.<br>
								5. Service charges applicable for this project are non-refundable as stated in our terms and conditions.<br>
								6. You do not have to wait for the completion of this project before you can post other projects.<br><br>
								
								<hr>
								<u>Project Title:</u> <span style="float:right !important">{{$project->title}}</span><br>
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
								To view your projects, simply click on the link - <u><a href="http://handymade.com/admin/projects">My Projects</a></u> - to manage any of your projects.<br><br>
								
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

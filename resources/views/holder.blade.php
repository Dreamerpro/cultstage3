<html ng-app="cultstage">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CultStage</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/holder.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/navbar.css">
	<link rel="stylesheet" type="text/css" href="css/content.css">
	<link rel="stylesheet" type="text/css" href="css/media-control.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<!-- <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'> -->
	
	<script type="text/javascript" src="js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="js/lib/angular.min.js"></script>
	<script type="text/javascript" src="js/lib/angular.route.min.js"></script>
	<script type="text/javascript" src="js/lib/underscore.js"></script>
	<script type="text/javascript" src="js/lib/bootstrap.min.js"></script>
	<script src='/bower_components/angular-cookies/angular-cookies.min.js'></script>
	
	

	<script type="text/javascript" src="js/app/app.js"></script>
	<script type="text/javascript" src="js/controller/controller.js"></script>
	<script type="text/javascript" src="js/controller/editprofile.js"></script>
	<script type="text/javascript" src="js/controller/dashboard.js"></script>
	<script type="text/javascript" src="js/controller/people.js"></script>
	<script type="text/javascript" src="js/controller/aboutcontroller.js"></script>
	<script type="text/javascript" src="js/controller/myevents.js"></script>
	<script type="text/javascript" src="js/controller/postnewevent.js"></script>
	<script type="text/javascript" src="js/controller/newjob.js"></script>
	<script type="text/javascript" src="js/controller/project.js"></script>
	<script type="text/javascript" src="js/controller/jobpostings.js"></script>
	<script type="text/javascript" src="js/controller/appliedjobs.js"></script>
	<script type="text/javascript" src="js/controller/compose.js"></script>
	<script type="text/javascript" src="js/controller/post.js"></script>
	<script type="text/javascript" src="js/controller/searchcontroller.js"></script>
	<!--script type="text/javascript" src="js/controller/sent.js"></script>
	<script type="text/javascript" src="js/controller/inbox.js"></script-->

	<script type="text/javascript" src="js/directive/directive.js"></script>
	<script type="text/javascript" src="js/filters/filters.js"></script>
	<script type="text/javascript" src="js/service/validator.js"></script>

</head>
<body >
	<sign-modal></sign-modal>
	<div ng-class="{'th':islanding}" class="header-bar clearfix">
		<div class="navicon-div @{{!islanding?'visible-xs':'hidden'}} "><i class="fa fa-navicon"></i></div>
		<a href="#/" ><i class="fa fa-modx"></i> CultStage</a>
		<div ng-hide="islanding" class="search-bar-top col-md-4 col-xs-12 col-sm-12 hidden-sm hidden-xs">
			<div class="form-group has-feedback "><i class="fa fa-search form-control-feedback pull-left"></i> 
				<input 
				class="form-control" 
				ng-model="data.query" 
				type="text" 
				placeholder="What are you searching?" 
				ng-change="showcats()"></input> 
				<div class="categories list-group" style="position: fixed;z-index: 10;min-width: 400px;" ng-show="showcat">
					<a style="border-radius: 0;" class="list-group-item" ng-click="search(0)">Job</a>
					<a style="border-radius: 0;" class="list-group-item" ng-click="search(1)">Poeple</a>
					<a style="border-radius: 0;" class="list-group-item" ng-click="search(2)">Event</a>
				</div>
			</div>
		</div>
		<div class="pull-right">
		<!-- <a href="#/jobs/new-job" class="post-header-btn hidden-xs">Post a Job</a> -->
		<ul class="hidden-xs header-menu-bar pull-right">
			<li ng-hide="isLoggedIn"> <a href="" data-toggle="modal" data-target="#sign-modal" ng-click="sign=0" >Sign Up</a></li><li ng-hide="isLoggedIn"><a href="" data-toggle="modal" data-target="#sign-modal" ng-click="sign=1" >Log In</a></li>
			<li ng-show="isLoggedIn" class="top-msg col-md-6" ><a class="dropdown-toggle" data-toggle="dropdown"><span class="col-xs-8">Messages</span> <i class="fa fa-inbox col-xs-4"></i></a>
				<ul class="dropdown-menu">
					<li class="dropdown-menu-item" ng-class="{'nocaret':!islanding}">
						<a class="item-heading " href="#/message/inbox">Inbox (0)</a>
						<!-- <div class="item-content"> <a href="">X y z</a></div> -->
					</li>
					<li class="dropdown-menu-item">
						<a class="item-heading" href="#/dashboard"> Notification</a>
						<!-- <div class="item-content"> You have 1 notification in dashboard<a class="pull-right" href=""></a></div>	 -->			
					</li>
				</ul>
			</li><li class="top-menu col-md-6" ng-show="isLoggedIn"> <!-- href="#/dashboard" -->
			<a class="accountsettings dropdown-toggle" data-toggle="dropdown"  >
				<span class="col-xs-8">@{{userData.name|firstname}}</span>
				<div class="img-holder col-xs-4"><img ng-src="@{{userData.avatar?userData.avatar:'images/avatar-default.jpg'}}"></div>
			</a>
				<ul class="dropdown-menu"><!-- list-group dropdown-list-menu -->
					<li class="dropdown-menu-item"><a href="#/dashboard">Dashboard</a></li>
					<li class="dropdown-menu-item" style=""><a href="#/jobs/my-applications">Your Jobs</a></li>
					<li class="dropdown-menu-item"><a href="#/profile/edit">Edit Profile</a></li>
					<li class="dropdown-menu-item"><a href="">Invite Friends</a></li>
					<li class="dropdown-menu-item"><a href="" ng-click="logout()">Logout</a></li>
				</ul>
			</li>
		</ul>
		</div>
	</div>

	
	<div ng-view >

	</div>
	
	<footer>

			<div class="footer-contents">
				<div class="container">
					<div class="col-md-4 col-xs-12">
						<a class="logo"><b>CultStage</b></a>
						<span></span>
					</div>
					<div class="col-md-8 col-xs-12">
						<ul class="f-menu" class="col-md-6 col-xs-12">
							<li><a href="">Terms of Use</a></li>
							<li><a href="">DCMA notice</a></li>
							<li><a href="">Privacy Policy</a></li>
							<li><a href="">Contact Us</a></li>
						</ul>
						<ul class="f-menu" class="col-md-6 hidden-xs">
							<li><a href="">Press Enquiries</a></li>
							<li><a href="">Business Development</a></li>
							<li><a href="">Technical Support</a></li>
							<li><a href="">Investors Section</a></li>
						</ul>
						<ul class="f-menu" class="col-md-6 col-xs-12">
							<li><a href="#/aboutus">About Us</a></li>
							<li><a href="#/ourmission">Our Mission</a></li>
							<li><a href="#/advertise">Advertise on CultStage</a></li>
							<li><a href="#/teach">Teach with CultStage</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="footer-social">
				<div class="container">
					<span>©2010-2015 CultStage.</span>
				 	<div class="pull-right socials">
				 	<div><a href="" class="fa fa-twitter"></a> </div>
				 	<div><a href="" class="fa fa-youtube"></a> </div>
				 	<div><a href="" class="fa fa-facebook"></a> </div>
				 	<div><a href="" class="fa fa-pinterest"></a> </div>
				 	<div><a href="" class="fa fa-instagram"></a> </div>
				 </div>
				</div>
				 
			</div>
		
	</footer>

</body>
<script src="/bower_components/ng-file-upload/ng-file-upload.min.js"></script>

	<script src='/bower_components/textAngular/dist/textAngular-rangy.min.js'></script>
	<script src='/bower_components/textAngular/dist/textAngular-sanitize.min.js'></script>
	<script src='/bower_components/textAngular/dist/textAngular.min.js'></script>
	<script src='/bower_components/ui-select/dist/select.js'></script>
	
	<link rel='stylesheet' href='/bower_components/textAngular/dist/textAngular.css'>
	<link rel='stylesheet' href='/bower_components/ui-select/dist/select.css'>

</html>
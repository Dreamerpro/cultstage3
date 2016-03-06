<html ng-app="cultstage">
<head>
	<title>CultStage</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/holder.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<!-- <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'> -->
	
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<!--<script type="text/javascript" src="js/angular.min.js"></script>
	<script type="text/javascript" src="js/angular.route.min.js"></script>
	<script type="text/javascript" src="js/underscore.js"></script>-->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	
</head>
<style type="text/css">
.header-bar{
	background-color: black;
	height: 170px;
	    padding-top: 40px;
}
.header-bar>a{
    width: 200px;
    color: #fff !important;
    border: 4px solid;
    border-top: 0;
    border-bottom: 0;
    height: 110px;
    /* line-height: 100px; */
    padding: 0 20px;
    margin-left: 40px;
    text-align: center;
}
.header-bar>a>small{
	position: absolute;
    margin-top: -20;
    margin-left: -27;
}
.header-bar>.categories,.filters{
	color: #fff;
	display: inline-block;
	padding: 14px;
}
.categories-menu>div,.filters-menu>div{
	height: 50px;
	cursor: pointer;
	display: inline-block;
	padding: 10px;
	vertical-align: text-top;
	font-size: 12px;
	margin:0 5px;
}
.categories-menu>div:hover,.filters-menu>div:hover{
	background-color: #333;
}
.filters{
    border-left: 1px solid #999;
    height: 113px;
    vertical-align: top;

}
.filters-menu>div:hover>.filter-item-container{
	display: block;
	    font-size: 12px;
}
.filter-item-container{
	display: none;
	position: absolute;
    background-color: #ddd;
    margin-top: 20px;
    color: black;
    padding: 40px;
}
.filter-item-container>a.filter-items{
	display: inline-block;
	padding: 18px;
}
.filter-item-container>a.filter-items:hover{
	text-decoration: underline !important;
}
.right-top{width: 400px;
    margin-top: -40;}
.socials-top{height: 40px;
	border-bottom:1px solid #fff;
    margin-top: 10;
}
.white{    background-color: #fff;
    height: 130px;
    border-top-left-radius: 230px;
}
.socials-top>a{
	padding: 6px;
	color: #fff;
	margin-top: 5px;
	width: 30px;
    display: inline-block;
    margin-left: 14px;
}
.socials-top>a:hover{
	color: #eee;
}
.socials-top>a>i{
	font-size: 1.2em;
}

.article-item{
	background-color: #000;
	height: 500px;
	margin: 60px 60px;
}

.article-heading{
    font-size: 16px;
    font-weight: bold;
    color: #fff;
}
.article-heading>.article-infos{
	text-indent: 40px;
}
.article-heading>.white-box{
	background-color: #fff;
	height: 60px;
}
.article-infos{
	height: 60px;
	line-height: 60px;
	word-spacing: 10px
}
.share-btns{
	line-height: 60px;
}
.share-btns>a>i{
	width: 20px;
    padding: 8px; 	
    margin-right: 20px;
}
.article-content{
    height: 440px;
    padding:20px 20px 20px 0;
}
img.poster{
	width: 100%;
	height: 100%;
}
.article-content>.description{
	background-color: #fff;
	height: 100%;
	padding: 0 40px;
}
.filters>h5,.categories>h5{
	    font-weight: bold;
    color: #DADADA;
}
.pdlr8{
	padding:0 8px;
	display: inline-block;
}
.rh:hover,.rh.active{
	color: red;
}
form{
	margin: 40px 0;
}
</style>
<body>
	<div class="header-bar clearfix">
		<a href="#/"  class="pull-left"><i class="fa fa-modx"></i> <span>CultStage</span><br><small>Magazine</small></a>
		<!-- <div class="categories clearfix">
			<h5>Category</h5>
			<div class="categories-menu clearfix">
				<div class="">Movie</div>
				<div class="">TV</div>
				<div class="">Online Film <br>and Videos</div>
				<div class="">Theatre</div>
				<div class="">Events</div>
			</div>
		</div>
		<div class="filters clearfix">
			<h5>Filters</h5>
			<div class="filters-menu">
				<div class="col-md">Language <i class="fa fa-angle-down pull-right"></i>
					<div class="filter-item-container">
						<a class="filter-items">Assamese</a>
						<a class="filter-items" href="">Bengali</a>
						<a class="filter-items">Kannada</a>
						<a class="filter-items">Hindi</a>
						<a class="filter-items">English</a>
					
					</div>					
				</div>
			</div>		
		</div>
		<div class="filters clearfix">
			<br>
			<a href="send-entry"><h5 style="color:orange">Send your entries	</h5></a>
		</div> -->
		<div class="pull-right right-top">
			<div class="socials-top">
				<a href=""><i class="fa fa-facebook"></i></a>
				<a href=""><i class="fa fa-google-plus"></i></a>
				<a href=""><i class="fa fa-twitter"></i></a>
				<a href=""><i class="fa fa-instagram"></i></a>
			</div>
			<div class="white"></div>
		</div>	
	</div>


	<div ng-view >
		<div class="content container">
			<form  class="clearfix">
				<div class="col-md-6">
					<h4>New Entry</h4>
					<div class="form-group">
						<label>Title</label>
						<input class="form-control" type="text"></input>
					</div>
					<div class="form-group">
						<label>Genre</label>
						<input class="form-control" type="text"></input>
					</div>
					<div class="form-group">
						<label>Language</label>
						<input class="form-control" type="text"></input>
					</div>
					<div class="form-group">
						<label>Director</label>
						<input class="form-control" type="text"></input>
					</div>
					<div class="form-group">
						<label>Casts</label>
						<input class="form-control" type="text"></input>
					</div>
					<div class="form-group">
						<label>Release Date</label>
						<input class="form-control" type="date"></input>
					</div>
				
					<div class="form-group">
						<label>Write ups</label>
						<textarea class="form-control" type="text"></textarea>
					</div>
					<div class="form-group">
						<label>Trailer Link</label>
						<textarea class="form-control" type="text"></textarea>
					</div>
					<input class="btn btn-host" type="submit" ></input>
				</div>
				<div class="col-md-6">
					<br><br><br>
					<div class="img-placeholder">
						<img src="" atr="asd" style="width:200px;height:200px;background-color:#eee">
					</div>
					<br>
					<div class="btn btn-success">Add Photo</div>
				</div>

				
			</form>
		</div>
	</div>

	<footer>

			<div class="footer-contents">
				<div class="container">
					<div class="col-md-4">
						<a class="logo">CultStage</a>
						<span>Lines here</span>
					</div>
					<div class="col-md-8">
						<ul class="f-menu" class="col-md-6">
							<li><a href="">Terms of Use</a></li>
							<li><a href="">DCMA notice</a></li>
							<li><a href="">Privacy Policy</a></li>
							<li><a href="">Contact Us</a></li>
						</ul>
						<ul class="f-menu" class="col-md-6">
							<li><a href="">CultStage Team</a></li>
							<li><a href="">Mission Statement</a></li>
							<li><a href="">Advertise on CultStage</a></li>
							<li><a href="">Teach on CultStage</a></li>
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
</html>
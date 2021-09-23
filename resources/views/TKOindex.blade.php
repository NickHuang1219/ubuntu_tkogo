<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>大腳走高雄</title>
	<link rel="shortcut icon" href="{{ URL::asset('img/ks.ico') }}">
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
	

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ URL::asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rdel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="{{ URL::asset('css/clean-blog.min.css') }}" rel="stylesheet">

    <!-- 一般的 -->
    <link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap-grid.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap-grid.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap-reboot.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap-reboot.min.css') }}" rel="stylesheet">
	
	<!-- Page UI/UX -->
	<!-- <link rel="stylesheet" href="{{ URL::asset('css/TKOindex.css') }}"> -->
	<script src="{{ URL::asset('js/1.8.2_jquery_min.js') }}"></script>

</head>
<body><!--  style="background-color:#EEFFBB" id="mainNav" -->
	<div class="nav navbar-dafault navbar-fixed-top sticky-top">
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="indexTop">
			<div class="container">
				<font id="titleText" style="font-size:3vh;">
					<img src="{{ URL::asset('img/klog.png') }}" width="40vh">
					<!-- <img src="{{ URL::asset('img/klog.png') }}" width="40vh"> -->
					大腳走高雄
				</font>
				<div></div>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span id="MenuBtn">
					<!-- Menu -->
					<i class="fa fa-bars" style="font-size:3vh;"></i></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive" style="background-color:#fff;">
					<ul class="navbar-nav ml-auto"  style="font-size:3vh;">
						<li class="nav-item">
							<a class="nav-link" href="/Bus"><B>高雄市公車</B></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/Mrt"><B>高雄捷運</B></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/Bike"><B>高雄YouBike</B></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/TaiwanTRA"><B>台灣鐵路</B></a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	<div style="margin-top:50vh;">
		<footer id="fh5co-footer" role="contentinfo">
			<div class="container">
				<div class="row copyright">
					<div class="col-md-12 text-center">
						<small class="block" id='fdiv' style="font-size:50%;">
							<h5 style="font-size:3.5vh; margin:0;">
							<!-- <img src="{{ URL::asset('img/klog.png') }}" width='50vw'> -->
							<I style="vertical-align:bottom">旅遊台灣 首選高雄</I><br> <h5 style="font-size:2.5vh;">Travel Taiwan Top Kaohsiung.</h5></h5>
						</small>
					</div>
					<div class="col-md-12 text-center">
						<small class="block" id='fdiv'>
							<font style="font-size:2vh;">大腳走高雄 power by Laravel 6</font><br>
						</small> 
					</div>
				</div>
			</div>
		</footer>
	</div>


    <!-- Bootstrap core JavaScript -->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ URL::asset('js/clean-blog.min.js') }}"></script>
</body>
</html>

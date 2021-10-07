<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>高雄市公車</title>
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
	<script src="{{ URL::asset('js/1.8.2_jquery_min.js') }}"></script>
	<script src="{{ URL::asset('js/gotop.js') }}"></script>
	<script src="{{ URL::asset('js/KsCityBus.js') }}"></script>

</head>
<body>
	<div class="nav navbar-dafault navbar-fixed-top sticky-top" id="">
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="BusTop" style="background-color:#fff;">
			<div class="container" >
				<font id="titText" style="font-size:3vh;">
					<img src="{{ URL::asset('img/ksbus1.png') }}" width="30%">
					高雄市公車
				</font>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span id="MenuBtn">
					<i class="fa fa-bars" style="font-size:3vh;"></i></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive" style="background-color:#fff;width:90%;">
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
	<div>
		<footer id="fh5co-footer" role="contentinfo" style="margin-top:3vh; padding-bottom:3vh;"><div class="m-auto" align="center" style="">
			<div class="m-auto" align="center" style="">
			<div class="btn-group " style="margin-bottom:2vh;">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{{$busClass}}
				</button>
				@if($busMeun!=null)
				<div class="dropdown-menu dropdown-menu-center">
					@foreach ($busMeun as $v)
					<button onclick="location.href='{{$v['Addr']}}'" class="dropdown-item" type="button"><a style="font-size:2.5vh;text-decoration:none;">{{$v['lineName']}}</a></button>
					@endforeach
				</div>
				@endif
			</div>
			</div>
			@if($topBtn)
			<div style="position:fixed;top:75%;right:0%;z-index:999;">
				<a id="gotop" href="#" onclick="busMenu()">
					<img src="{{ URL::asset('img/gotop.png') }}" width="50vw">
				</a>
			</div>
			@endif
			@if($bus!=null)
			@foreach ($bus as $v)
				<div class="container">
					<div class='alert alert-light' align='left' id='' onclick="location.href='/BusCon/{{$v['ID']}}'" style="border-color:#9105a2;border-width:.23vh;border-style:solid;border-radius:.6vh;height:12vh;display:inline-table;width:100%;">
						<font style='font-family:微軟正黑體;font-size:3.15vh;overflow:hidden;text-overflow:ellipsis;display:-webkit-inline-box;-webkit-box-orient:vertical;-webkit-line-clamp:1;'>{{ $v['nameZh'] }}</font>
						<div>
							<font style='font-family:微軟正黑體; font-size:1.95vh;'>{{$v['ddesc']}}</font>
						</div>
					</div>
				</div>
			@endforeach
			@endif
		</footer>
		<footer id="fh5co-footer" role="contentinfo" style="margin-top:1vh; padding-top:0;">
			<div class="col-md-12 text-center">
				<small class="block" id='fdiv'>
					<!--<font style="font-size:2.8vh;">
						&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
						夏日清涼&ensp;冬天暖心
					</font><br>-->
					<font style="font-size:2.8vh;">
						<img src="{{ URL::asset('img/klog.png') }}" width='50vw'>
						<I style="font-size:2.8vh;">旅遊台灣&ensp;首選高雄</I>
					</font><br>
					<font style="font-size:2vh;">大腳走高雄 power by Laravel 6</font><br>
				</small> 
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

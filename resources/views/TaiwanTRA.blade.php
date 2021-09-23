<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>台灣鐵路</title>
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
	<script src="{{ URL::asset('js/traJs.js') }}"></script>

</head>
<body>
	<div class="nav navbar-dafault navbar-fixed-top sticky-top">
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="indexTop" style="background-color:#fff;">
			<div class="container">
				<font id="titleText"  style="font-size:14pt;">
					<img src="{{ URL::asset('img/TaiwanTRA.png') }}" style="width:35px;">&nbsp;台灣鐵路
				</font>
				<div id="container"></div>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span id="MenuBtn">
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
	<div>
		<footer id="fh5co-footer" role="contentinfo" style="padding-bottom:3vh;">
		
			<div align='center' style="margin-top:10vh;">
					<div class="container">
						<div class="row">
							<div class="col-6">
								@if($Counties!=null)
								<select onchange="TD(this.value)" class="btn btn-outline-primary">
									@if($CountiesID=='')
										<option value="z" selected>請 選 縣 市</option>
									@endif
									@foreach ($Counties as $v)
										@if($CountiesID==$v['id'])
											<option value="{{$v['id']}}" selected>{{$v['name']}}</option>
										@endif
										@if($CountiesID!=$v['id'])
											<option value="{{$v['id']}}">{{$v['name']}}</option>
										@endif
									@endforeach
								</select>
								@endif
							</div>
							<div class="col-6" align="left">
								@if($Trastationd!=null)
								<select onchange="createBtn(this.value)" class="btn btn-outline-primary">
									<option value="z" selected>請 選 站 別</option>
									@foreach ($Trastationd as $v)
										<option value="{{$v['StationID']}}">{{$v['StationNameTW']}}</option>
									@endforeach
								</select>
								@endif
							</div>
							<div class="col" id='Trastationd'>
							<!--</div>-->
						</div>
					</div>
			</div>
				<div class="container" id="TRABtn"></div>
				<div id="Mline" align='center' style="margin-top:5vh; background:#c8e7ff;"></div>
				<div id="QueLineD" align='center'></div>
			<div></div>
			@if($mrt!=null)
			@foreach ($mrt as $v)
				<div class="container" align='center'>
					<div class='alert alert-danger' align='left' id='' style="background-color:{{$dColor}};">
						<button class='btn btn-danger' typt='submit' onclick=ajaxNSurl("{{$v['ODMRT_Name']}}") style='font-family:微軟正黑體; font-size:2.5vh;background-color:{{$bColor}}; border:{{$borColor}}'>{{ $v['ODMRT_CName'] }}</button>
						<br><{{$v['ODMRT_Name']}}></{{$v['ODMRT_Name']}}>
					</div>
				</div>
			@endforeach
			@endif
			<div style="position:fixed;top:75%;right:0%;z-index:999;">
				<a id="gotop" href="#" onclick="busMenu()">
					<img src="{{ URL::asset('img/gotop.png') }}" width="50vw">
				</a>
			</div>
		</footer>
		<footer id="fh5co-footer" role="contentinfo" style="margin-top:1vh; padding-top:0;">
			<div class="col-md-12 text-center">
				<small class="block" id='fdiv'>
					<font style="font-size:2.8vh;">
						<img src="{{ URL::asset('img/klog.png') }}" width='50vw'>
						<I>旅遊台灣&ensp;首選高雄</I>
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
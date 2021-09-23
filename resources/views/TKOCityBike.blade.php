<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>高雄YouBike</title>
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
	<link href="{{ URL::asset('css/citybike.css') }}" rel="stylesheet">

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
	
	<script>
		function BorRetBike(BikeId)
		{
			jQuery.ajax({
				method: "GET",
				charset:"utf-8",
				dataType: "json",
				url:'/BikeConn/'+BikeId,
				// url: "https://ptx.transportdata.tw/MOTC/v2/Bike/Availability/Kaohsiung?$filter=StationUID%20eq%20'"+BikeId+"'&$top=30&$format=JSON",
				success : function(borrowD) {
					console.log(borrowD);
					if(borrowD.type==1){
						$(BikeId).empty();
						$(BikeId).append('<div>'+borrowD.Rent+'<br>'+borrowD.Return+'<div>');
					}
					else{
						$(BikeId).empty();
						$(BikeId).append('<div>'+borrowD.errT+'<div>');
					}
				}, error: function(xhr, ajaxOptions, thrownError){}
			});
		}
	</script>

</head>
<body>
	<div class="nav navbar-dafault navbar-fixed-top sticky-top" id=""><!--padding-top:0;padding-bottom:0; -->
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="BusTop" style="background-color:#fff;">
			<div class="container" style="background-color:#fff;">
				<font id="titText" style="font-size:3vh;width:39vh;">
					<img src="{{ URL::asset('img/KsBicycleLogo.png') }}" height="42vh">
					高雄YouBike
				</font>
				<div></div>
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
		<footer id="fh5co-footer" role="contentinfo" style="margin-top:3vh; padding-bottom:3vh;"><div class="m-auto" align="center" style="">
		<br>
			<div class="m-auto" align="center" style="">
			<div class="btn-group " style="margin-bottom:2vh;margin-top:7vh;">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{{$bikeClass}}
				</button>
				@if($bikeMeun!=null)
				<div class="dropdown-menu dropdown-menu-center">
					@foreach ($bikeMeun as $v)
					<button class="dropdown-item" type="button"><a href="{{$v['Addr']}}" style="font-size:2.5vh;text-decoration:none;">{{$v['lineName']}}</a></button>
					@endforeach
				</div>
				@endif
			</div>
			</div>
			@if($bike!=500)
				@if($bike!=null)
			@foreach ($bike as $v)
				<div class="alert alert-primary container" role="alert" style="width:90%" id="BikeStop">
					<div id="stopName" style="font-size:2.8vh; overflow:hidden;">{{$v['StationNameTW']}}</div>
						<div style="float: left;">
							<button type="button" class="btn btn-outline-primary" onclick="BorRetBike('{{$v['StationUID']}}')" id="btnlign">可借可還</button>&emsp;
						</div><br><br>
						<{{$v['StationUID']}} id="{{$v['StationUID']}}" class="" align="left" style="font-size:2.3vh;"></{{$v['StationUID']}}>
						<div id="addText" style="font-size:2.3vh;">地址：
							<a target="_blank" href="http://maps.google.com/?q={{$v['PositionLat']}},{{$v['PositionLon']}}">
								<img src="{{ URL::asset('img/mapImg1.png') }}" style="width:6.5vh">
							</a>
						</div>
						<div id="addr" style="font-size:2.3vh;">{{$v['StationAddressTW']}}</div>
					</div>
				</div>
			@endforeach
			@endif
			@else
			<div class="alert alert-primary container" role="alert" style="width:90%">來源錯誤.</div>
			@endif
			@if($bike==null)
			@endif
			@if($topBtn)
			<div style="position:fixed;top:75%;right:0%;z-index:999;">
				<a id="gotop" href="#" onclick="busMenu()">
					<img src="{{ URL::asset('img/gotop.png') }}" width="50vw">
				</a>
			</div>
			@endif
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
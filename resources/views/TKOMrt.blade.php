<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>高雄捷運</title>
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

	<script>
		function ajaxNSurl(RID){
			$.ajax({
				method: "GET",
				dataType: "JSON",
				url: "/MrtConn/"+RID+"/"+location.href.split('Mrt/')[1],
				success : function(fomoRData) {
					let D = '';
					if(fomoRData.type=='s'){
						if(fomoRData.dataCount==2){
							D = fomoRData.goD.goTName+'： '+fomoRData.goD.goConinTime;
							D = D+'<br>'+fomoRData.backD.backTName+'： '+fomoRData.backD.backConinTime;
						}
						else if(fomoRData.dataCount==1){
							D = fomoRData.goD.goTName+'： '+fomoRData.goD.goConinTime;
						}
					}
					$(RID).empty();
					$(RID).append(D);
				}
			});
		}
		function ajaxLRTurl(RID){
			$.ajax({
				method: "GET",
				dataType: "JSON",
				url: "/MrtConn/"+RID+"/"+location.href.split('Mrt/')[1],
				success : function(lrtData){
					let D = null;
					if(lrtData.type==200){
						D = lrtData.toGo+'： '+lrtData.GoTime;
						D = D+'<br>'+lrtData.toBack+'： '+lrtData.BackTime;
					}
					else{
						D = lrtData.type+'： '+lrtData.typeTxt;
					}
					$(RID).empty(D);
					$(RID).append(D);
				}
			});
		}
	</script>
</head>
<body>
	<div class="nav navbar-dafault navbar-fixed-top sticky-top">
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="indexTop" style="background-color:#fff;">
			<div class="container">
				<font id="titleText"  style="font-size:3vh;">
					<img src="{{ URL::asset('img/tkoMRT.png') }}" width="100vh">
				</font>
				<div id="container"></div>
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
		<footer id="fh5co-footer" role="contentinfo" style="margin-top:3vh; padding-bottom:3vh;">
		<div class="m-auto" align="center" style="">
			<div class="btn-group " style="margin-bottom:2vh;">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{$lineClass}}
				</button>
				@if($mrtMeun!=null)
				<div class="dropdown-menu dropdown-menu-center">
					@foreach ($mrtMeun as $v)
					<button class="dropdown-item" type="button"><a style="font-size:2.5vh;text-decoration:none;" href="{{$v['Addr']}}" style="font-size:2.5vh;">{{$v['lineName']}}</a></button>
					@endforeach
				</div>
				@endif
			</div>
			</div>
			@if($mrt!=null)
			@foreach ($mrt as $v)
				<div class="container">
					<div class='alert alert-danger' align='left' id='' style="background-color:{{$dColor}};">
						<button class='btn btn-danger' typt='submit' onclick=ajaxNSurl("{{$v['ODMRT_Name']}}") style='font-family:微軟正黑體; font-size:2.5vh; margin-bottom:1.5vw; background-color:{{$bColor}}; border:{{$borColor}}'>{{ $v['ODMRT_CName'] }}</button>
						<br><{{$v['ODMRT_Name']}}></{{$v['ODMRT_Name']}}>
					</div>
				</div>
			@endforeach
			@endif
			@if($lrt!=null)
			@foreach ($lrt as $v)
				<div class="container">
					<div class='alert alert-danger' align='left' id='' style="background-color:{{$dColor}};">
						<button class='btn btn-danger' typt='submit' onclick=ajaxLRTurl("{{$v['ODMRT_Name']}}") style='font-family:微軟正黑體; font-size:2.5vh; margin-bottom:1.5vw; background-color:{{$bColor}}; border:{{$borColor}}'>{{ $v['ODMRT_CName'] }}</button>
						<br><{{$v['ODMRT_Name']}}></{{$v['ODMRT_Name']}}>
					</div>
				</div>
			@endforeach
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
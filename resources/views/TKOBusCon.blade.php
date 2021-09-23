<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<title>高雄市公車</title>
	<link rel="shortcut icon" href="{{ URL::asset('resources/img/ks.ico') }}">
    <link href="{{ URL::asset('resources/css/bootstrap.min.css') }}" rel="stylesheet">
	
    
    
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
    <link href="{{ URL::asset('resources/css/clean-blog.min.css') }}" rel="stylesheet">

    <!-- 一般的 -->
    <link href="{{ URL::asset('resources/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('resources/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('resources/css/bootstrap-grid.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('resources/css/bootstrap-grid.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('resources/css/bootstrap-reboot.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('resources/css/bootstrap-reboot.min.css') }}" rel="stylesheet">
	
	<!-- Page UI/UX -->
	<script src="{{ URL::asset('resources/js/1.8.2_jquery_min.js') }}"></script>
	<script src="{{ URL::asset('resources/js/gotop.js') }}"></script>
	<script src="{{ URL::asset('resources/js/KsCityBus.js') }}"></script>
	
	<script>
		function Toback(){
			document.getElementById('S1').style.display='none';
			document.getElementById('S2').style.display='inline';
		}

		function Togo(){
			document.getElementById('S1').style.display='inline';
			document.getElementById('S2').style.display='none';
		}
        function regetbustime(id)//即時動態重新整理
        {
            jQuery.ajax({
                method: "GET",
                charset:"utf-8",
                cache:"true",
                dataType: "json",
                async:false,
                url: "/reGetBusTime/"+id+'/P',
                success : function(data) { 
					let go;
					let back;
					if(data.conn.httpCode==200){
						let title='<table style="float:center; width:100%;" style="color:#000;"><tr><td style="width:25%;"><span style="color:#FFF;">狀態</span></td><td style="width:55%;"><span style="color:#FFF;">站牌名稱</span></td><td style="width:20%;" align="right"><span style="color:#FFF;">車牌</td></span></tr>';
						if(data.conn.togo!=''){
							go=title;
				        	data.conn.togo.forEach(conn=>{
				        		go+='<tr><td style="width:25%;"><span style="color:#FFF;font-size:1.9vh;">'+conn.time+'</span></td><td style="width:55%;"><span style="color:#FFF;font-size:55%*95%;">'+conn.StopName+'</span></td><td style="width:20%;" align="right"><span style="color:#FFF;font-size:80%;">'+conn.busCarId+'</td></span></tr>';
							});
							go+='</table>';
							$('ToGo').empty();
							$('ToGo').append(go);
							// data.conn.togo.forEach(g=>{});
						}
						else{
							$('ToGo').empty();
							$('ToGo').append('<div style="color:#FFF;margin-top:5vh;font-size:3.5vh;">無去程</div>');
						}
						if(data.conn.toback!=''){
							back=title;
				        	data.conn.toback.forEach(conn=>{
				        		back+='<tr><td style="width:25%;"><span style="color:#FFF;font-size:1.9vh;">'+conn.time+'</span></td><td style="width:55%;"><span style="color:#FFF;font-size:55%*95%;">'+conn.StopName+'</span></td><td style="width:20%;" align="right"><span style="color:#FFF;font-size:80%;">'+conn.busCarId+'</td></span></tr>';
							});
							back+='</table>';
							$('ToBack').empty();
							$('ToBack').append(back);
						}
						else{
							$('ToBack').empty();
							$('ToBack').append('<div style="color:#FFF;margin-top:5vh;font-size:3.5vh;">無返程</div>');
						}
					}
					else{
						$('ToGo').empty();
						$('ToGo').append('<div style="color:#FFF;margin-top:5vh;font-size:3.5vh;">'+data.conn.errT+'</div>');
						$('ToBack').empty();
						$('ToBack').append('<div style="color:#FFF;margin-top:5vh;font-size:3.5vh;">'+data.conn.errT+'</div>');
					}
                },

                error: function(xhr, ajaxOptions, thrownError) {
                }
            });
        }
        function dad(d){
        	let da='';
        	d.forEach(conn=>{
        		console.log(conn)
				da+='<tr><td style="width:25%;"><span style="color:#FFF;font-size:1.9vh;">'+conn.coninT+'</span></td>';
				da+='<td style="width:55%;"><span style="color:#FFF;font-size:55%*95%;">'+conn.StopName+'</span></td>';
				da+='<td style="width:20%;" align="right"><span style="color:#FFF;font-size:80%;">'+conn.carId+'</td></span></tr>';
			});
			return da;
        }
        var timer = setInterval(function(){
            this.regetbustime({{$lineId}});
	        return '';
	    }, 20000)
		
	</script>

</head>
<body>
	<div class="nav navbar-dafault navbar-fixed-top sticky-top" id="">
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="BusTop" style="background-color:#fff;">
			<div class="container" >
				<font id="titText" style="font-size:3vh;">
					<img src="{{ URL::asset('resources/img/ksbus1.png') }}" width="30%">
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
		<footer id="fh5co-footer" role="contentinfo" style="padding-bottom:3vh;">
			@if($topBtn)
			<div style="position:fixed;top:75%;right:0%;z-index:999;">
				<a id="gotop" href="#" onclick="busMenu()">
					<img src="{{ URL::asset('resources/img/gotop.png') }}" width="40vw">
				</a>
			</div>
			<div style='position: fixed; top: 50%; right: 0%; z-index: 999;'>
				<a id='share_up' onclick="regetbustime({{$lineId}})" title='更新即時動態' alt='更新即時動態' class="myMOUSE">
					<img src="{{ URL::asset('resources/img/remove.png') }}" width='40vw'>
				</a>
			</div>
			@endif
    <header style='background-color:#9A0000;' id='top'>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-18 mx-auto">
            <div class="site-heading" align="center" style="padding-top:2vh;">
                <font style='color:#fff;font-size:3.5vh;'>
					{{$lineName}}<br>
					@if(!$err)
					<font style='font-size:4.5vh;' align="center">即時動態</font>
					@endif
	            </font><br>
    	        <ul style='display:inline;' align='center' id='uul'>
	        	    <li style='display:inline; font-family:微軟正黑體;' id="current">
		                <a href="javascript://" onclick="Togo();" style='text-decoration:none;'>
							<span style='color:#FF0; font-size:18pt;'><h1  class="h1"></h1>&emsp;去&nbsp;&nbsp;程&emsp;&nbsp;&nbsp;</span>
            		    </a>
	                </li>&nbsp;&nbsp;&nbsp;
		            <li style='display:inline; font-family:微軟正黑體;'>
		                <a href="javascript://" onclick="Toback();" style='text-decoration:none;'>
            		        <span style='color:#FF0; font-size:18pt;'>返&nbsp;&nbsp;程&emsp;</h1></span></span>
            		    </a>
	    	        </li>
                </ul>
                 
                 <div id="tabsC">
        	        <div id="S1" style="display:inline;">
						<!--ToGo-->
						<font style='color:#fff;' align="center">
							{{$goName}}&nbsp;&nbsp;@if($goName!=''AND$backName!='')至@endif&nbsp;&nbsp;{{$backName}}
						</font><br><br>
						@if($togo!=null)
        	            <ToGo>
						<table style="float:center; width:100%;" style="color:#000;">
						<tr><td style="width:25%;"><span style="color:#FFF;">狀態</span></td>
						<td style="width:55%;"><span style="color:#FFF;">站牌名稱</span></td>
						<td style="width:20%;" align="right"><span style="color:#FFF;">車牌</td></span></tr>
						@foreach($togo as $v)
							<tr><td style="width:25%;"><span style="color:#FFF;font-size:1.9vh;">{{$v['coninT']}}</span></td>
							<td style="width:55%;"><span style="color:#FFF;font-size:55%*95%;">{{$v['StopName']}}</span></td>
							<td style="width:20%;" align="right"><span style="color:#FFF;font-size:76%;">{{$v['carId']}}</td></span></tr>
						@endforeach
						</table>
						</ToGo>
						@endif
						@if($togo==null)
							<ToGo>
								<div style="color:#FFF;margin-top:5vh;font-size:3.5vh;">無去程</div>
							</ToGo>
						@endif
        	        </div>
    	            <div id="S2" style="display:none;">
						<!--ToBack-->
						<font style='color:#fff;' align="center">
							{{$backName}}&nbsp;&nbsp;@if($goName!=''AND$backName!='')至@endif&nbsp;&nbsp;{{$goName}}
						</font><br><br>
						@if($toback!=null)
    	                <ToBack>
						<table style="float:center; width:100%;" style="color:#000;">
						<tr><td style="width:25%;"><span style="color:#FFF;">狀態</span></td>
						<td style="width:55%;"><span style="color:#FFF;">站牌名稱</span></td>
						<td style="width:20%;" align="right"><span style="color:#FFF;">車牌</td></span></tr>
						@foreach($toback as $v)
							<tr><td style="width:25%;"><span style="color:#FFF;font-size:1.9vh;">{{$v['coninT']}}</span></td>
							<td style="width:55%;"><span style="color:#FFF;font-size:55%*95%;">{{$v['StopName']}}</span></td>
							<td style="width:20%;" align="right"><span style="color:#FFF;font-size:80%;">{{$v['carId']}}</td></span></tr>
						@endforeach
						</table>
						</ToBack>
						@endif
						@if($toback==null)
							<ToGo>
								<div style="color:#FFF;margin-top:5vh;font-size:3.5vh;">無返程</div>
							</ToGo>
						@endif
    	            </div>
                 </div>
            <div id='lineView'></div>
                
            </div>
          </div>
        </div>
      </div><br>
    </header>
		</footer>
		<footer id="fh5co-footer" role="contentinfo" style="margin-top:1vh; padding-top:0;">
			<div class="col-md-12 text-center">
				<small class="block" id='fdiv'>
					<!--<font style="font-size:2.8vh;">
						&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
						夏日清涼&ensp;冬天暖心
					</font><br>-->
					<font style="font-size:2.8vh;">
						<img src="{{ URL::asset('resources/img/klog.png') }}" width='50vw'>
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
    <script src="{{ URL::asset('resources/js/clean-blog.min.js') }}"></script>	
</body>
</html>
<html lang="{{ app()->getLocale() }}">
	<head></head>
	<body>
		<br>Test Function blade<br><br>
        	            <ToGo>
						<?//=$ToGo; ?>
						@if($togo!=null)
						<table style="float:center; width:100%;" style="color:#000;">
						<tr><td style="width:25%;"><span style="color:#FFF;">狀態</span></td>
						<td style="width:55%;"><span style="color:#FFF;">站牌名稱</span></td>
						<td style="width:20%;" align="right"><span style="color:#FFF;">車牌</td></span></tr>
						@foreach($togo as $v)
							<tr><td style="width:25%;"><span style="color:#FFF;font-size:2.3vh;">{{$v['coninT']}}</span></td>
							<td style="width:55%;"><span style="color:#FFF;font-size:55%*95%;">{{$v['StopName']}}</span></td>
							<td style="width:20%;" align="right"><span style="color:#FFF;font-size:76%;">{{$v['carId']}}</td></span></tr>
							<!--<font style='color:#fff;' align="center">{{$v['coninT']}} -- {{$v['StopName']}} -- {{$v['carId']}}</font><br>-->
						@endforeach
						</table>
						@endif
						</ToGo>
	</body>
</html>
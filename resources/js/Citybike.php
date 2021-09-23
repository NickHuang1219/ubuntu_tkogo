<!DOCTYPE>  
<html>
<?php echo header('Content-Security-Policy: upgrade-insecure-requests'); ?>
<head>
    <link rel="shortcut icon" href="img/ks.ico">
	<title><?=$title?></title>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Clean Blog - Start Bootstrap Theme</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/clean-blog.min.css" rel="stylesheet">


    <script src="/js/1.8.2_jquery_min.js"></script>
    <script src="/js/jQueryAjax.js"></script>
	<script>
        $(function(){
            $("#gotop").click(function(){
                $("html,body").animate({scrollTop:0}, 900);
                return false;
            });
        });
        function borrowBike(id)
        {
            jQuery.ajax({
                method: "GET",
                charset:"utf-8",
                cache:"true",
                dataType: "json",
                async:false,
                url: "https://ptx.transportdata.tw/MOTC/v2/Bike/Availability/Kaohsiung?$select=AvailableRentBikes%20&$filter=StationUID%20eq%20'KHH"+id+"'&$top=30&$format=JSON",

                success : function(borrowD) {
                    var borrowData = new Array();
                    var borrowData = JSON.stringify(borrowD);

                    var data = new Array();
		        	data = borrowData.split('AvailableRentBikes":',100);
                    var Bordata = new Array();
		        	Bordata = data[1].split(',"AvailableRetur',100);
                    alert('可借車數：'+Bordata[0]+'台。');
                },
                error: function(xhr, ajaxOptions, thrownError){}
            });
            //
        }
        function returnBike(id)
        {
            jQuery.ajax({
                method: "GET",
                charset:"utf-8",
                cache:"true",
                dataType: "json",
                async:false,
                url: "http://ptx.transportdata.tw/MOTC/v2/Bike/Availability/Kaohsiung?$select=AvailableReturnBikes%20&$filter=StationUID%20eq%20'KHH31'&$top=30&$format=JSON",

                success : function(returnD) {
                    var returnData = new Array();
                    var returnData = JSON.stringify(returnD);

                    // var data = new Array();
		        	// data = borrowData.split('AvailableRentBikes":',100);
                    // var Bordata = new Array();
		        	// Bordata = data[1].split(',"AvailableRetur',100);
                    alert('可還車數：'+returnData+'台。');
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr);
                }
            });
            //
        }
	</script>

	<style>
		#map
		{
			font-family: 微軟正黑體;
			font-size: 32pt;
		}
		.cdiv
		{
			position:absolute;
			left:10%;
			top:15%;
		}
        .imgg
		{
            width:50%;
            height:35%;
        }
        .wh
		{
            width:50%;
            height:35%;
        }
        .brr
		{
            height:35%;
        }
        h2
		{
            font-size:18pt;
            font-family: 微軟正黑體;
            color:#FFF;
        }
        a
		{
            font-family: 微軟正黑體;
            font-size:16pt;
            color:#FFF;
        }
        a1
		{
            font-size:16pt;
            font-family: 微軟正黑體;
            color:#FFF;
        }
        a2
		{
            font-size:18pt;
            font-family: 微軟正黑體;
            color:#000;
        }
        a3
		{
            font-size:2816pt;
            font-family: 微軟正黑體;
            color:#000;
        }
        ti
        {
            font-size:90%;
            font-family: 微軟正黑體;
        }
        #uli li
        {
            float:left;

            margin:0px 10px 0px 0px;
        }
        #titleText
        {
            font-size:18pt;
            font-family: 微軟正黑體;
            color:#FFF;
        }
        #fdiv
        {
            font-size:18pt;
            font-family: 微軟正黑體;
        }
        option
        {
            font-size:12pt;
        }
        #btnlign
        {}
        #stopName
        {
            font-size:18pt;
            text-align:left;
        }
        #addText
        {
            color:#000; 
            text-align:left; 
            font-size:15pt;
        }
        #addr
        {
            color:#000; 
            text-align:left; 
            font-size:13pt;
        }
    </style>
	
	<script src='/js/1.8.2_jquery_min.js'></script>
	<script>
		$(function(){
			$("#gotop").click(function(){
				$("html,body").animate({scrollTop:0}, 900);
				return false;
			});
		});
	</script>
	<!--<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'></script>-->

</head>
<body style="background-color:#FFF">
	<!--回頂端按鈕-->
	<div style='position: fixed; top: 75%; right: 0%; z-index: 999;'>
		<a id='gotop' href='#' title='回頂端' alt='回頂端' >
			<img src='/img/top.png' width='50pt'>
		</a>
	</div>
	
	<!--頂端導覽列-->
	<!--<div align='center'>-->
	    <?=$titleMeun;?>
    <!--</div>-->
	<br><br>
    
	
	<header class='masthead' style='background-color:#FFF;' id='top'><br><br><br>
        <div align='center'>
            <select onchange="seleBike(this.value)" style="height:28pt;">
                <option value="C">腳 踏 車 地 點 查 詢</option>
                <option value="Area" desabled>依 行 政 區</option>
                <option value="Mrt">捷 運 站 旁</option>
                <option value="S">學 校 周 邊</option>
                <option value="E">其 他 地 點</option>
            </select>
            <div id='Area' align='cneter'>
            </div>
            <div id='sele'><p>
            </div>
        </div>
    </header>


    <footer id="fh5co-footer" role="contentinfo">
        <div class="container">
            <div class="row copyright">
                <div class="col-md-12 text-center">
                        <small class="block" id='fdiv'><img src='/img/klog1-3.png' width='60pt'>2018 Go!<br></small> 
                        <small class="block" id='fdiv'><I>旅遊台灣 首選高雄</I><br> Travel Taiwan Top Kaohsiung.</small>
                    <!--<p>
                        <ul class="fh5co-social-icons">
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-facebook"></i></a></li>
                            <li><a href="#"><i class="icon-linkedin"></i></a></li>
                            <li><a href="#"><i class="icon-dribbble"></i></a></li>
                        </ul>
                    </p>-->
                </div>
            </div>
        </div>
    </footer>
    
    
    <!-- Bootstrap core JavaScript -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="/js/clean-blog.min.js"></script>
</body>
</html>
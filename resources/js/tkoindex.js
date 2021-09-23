var navbar = new Vue({
		  el:'#navbar',
		  data: {
			Mtitle:'<div class="nav navbar-dafault navbar-fixed-top sticky-top"><nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav"><div class="container"><a class="navbar-brand"><img src="img/klog1-2.png" height="55pt">高雄歡迎您！</img></a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu<i class="fa fa-bars"></i></button><div class="collapse navbar-collapse" id="navbarResponsive"><ul class="navbar-nav ml-auto"><li class="nav-item"><a class="nav-link" href=""><a1>Home</a1></a></li><li class="nav-item"><a class="nav-link" href="KsAttra"><a1>高雄景點</a1></a></li><li class="nav-item"><a class="nav-link" href="/KsCityBus"><a1>高雄公車</a1></a></li>	<li class="nav-item"><a class="nav-link" href="./MrtLine"><a1>高雄捷運</a1></a></li><li class="nav-item"><a class="nav-link" href="/Kscitybike"><a1>高雄CityBike</a1></a></li></ul></div></div></nav></div>',
			Ksheader: '<header class="masthead" style="background-color:red"><div class="overlay"></div><div class="container"><div class="row"><div class="col-lg-8 col-md-10 mx-auto"><div class="site-heading"><span style="font-size:42pt;">Welcome To <br> Kaosiung</span></div></div></div></div></header>',
			Ksfooter:'<footer id="fh5co-footer" role="contentinfo"><div class="container"><div class="row copyright"><div class="col-md-12 text-center"><small class="block" id="fdiv"><img src="img/klog1-3.png" width="60pt">2019 Go!<br></small> <small class="block" id="fdiv"><I>旅遊台灣 首選高雄</I><br> Travel Taiwan Top Kaohsiung.</small></div></div></div></footer>',
			tkotitle : '高雄歡迎您！',
			Menu: 'Menu',
			Home: 'Home',
			KsAttra: '高雄景點',
			Ksbus: '高雄公車',
			KsMRT: '高雄捷運',
			KsBicycle: '高雄公共腳踏車',
			BText: 'Welcome To <br> Kaosiung'
		  }
		})
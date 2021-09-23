
        function selebus(id){
            if(id=="C"){
                var View = '';
                View += '<br><div id="busLineC"><img src="/img/ksbus1.png"></img>';
                View += '<br>高雄公車夏日清涼，冬天暖心！</div>';

                $("#busLine").empty();
                $("#busLine").append(View);
            }
            else if(id=="Q"){
                var View = '';
                View += '<br><div align="left" id="Qdiv">';
                View += '<span style="color:red;font-size:16pt;">new~ <br>';
                View += '3月1日起市區公車一日兩段吃到飽、公路客運最高自付額60元、捷運轉乘市區公車折扣3元。</span><br><br>';
                View += '<span style="font-size:16pt;">一般票種</span><br>';
                View += '1.刷卡搭公車里程8公里以內算一段票，全票12元，半票6元，學生票10元(限具有照片且在效期內之數位學生證及高雄學生認同卡)。';
                View += '<br>2.超過8公里以上收二段票。';
                View += '<br><br><span style="font-size:16pt;">社福卡</span>';
                View += '<br>1.刷卡搭公車里程8公里以內，上車扣1點 下車扣0點。';
                View += '<br>2.刷卡搭公車里程8公里以上，上車扣1點 下車扣1點。';
                View += '</div>';
                View += '';

                $("#busLine").empty();
                $("#busLine").append(View);
            }
            else{
                if(id=="g" || id=="r" ||id=="o" ||id=="y" ||id=="m" ||id=="f" || id=="h" || id=="e"){
                    if(id=="g"){ LineTitle="一般公車"; }
                    if(id=="r"){ LineTitle="紅線公車"; }
                    if(id=="o"){ LineTitle="橘線公車"; }
                    if(id=="y"){ LineTitle="黃線公車"; }
                    if(id=="m"){ LineTitle="幹線公車"; }
                    if(id=="f"){ LineTitle="快線公車"; }
                    if(id=="h"){ LineTitle="公路客運"; }
                    if(id=="e"){ LineTitle="其他公車"; }

                    jQuery.ajax({
                        method: "GET",
                        charset:"utf-8",
                        cache:"true",
                        dataType: "html",
                        async:false,
                        url: "../Curlbusline/Selebus/"+id,

                        success : function(Data) {
                            //變數初始化
                            BusLine = '';

                            //字串切割
                            var DataArr = Data.split('&',100);

                            BusLine += '<div style="background-color:#900;"><br>';
                            for(i=0; i<DataArr.length; i++)
                            { j++;
                                busD = DataArr[i].split('*',10);
                                if(DataArr[i]!='' && busD[1]!=''){
                                BusLine += '<a href="../SeBusLine/busline/'+busD[0]+'" style="text-decoration:none;">';
                                BusLine += '<div class="alert alert-light" role="alert" id="alert">';
                                BusLine += '<a2>'+busD[1]+'</a2><br>';
                                BusLine += '<text>'+busD[2]+' - '+busD[3]+'</text></div></a>';
                                }
                            }
                            BusLine += '<br><br></div>';

                                $("#selMu").empty();
                                $("#busLine").empty();
                                $("#busLine").append('<div id="LineTitle">'+LineTitle+'</div');
                                $("#busLine").append(BusLine);
                        },
                        error: function(xhr, ajaxOptions, thrownError){}
                    });
                }
            }
        }
/*
        function busMenu(){
            var Menu = '';

            Menu += '<select onchange="selebus(this.value)" class="btn btn-outline-primary">';
            Menu += '<option value="C">請 選 公 車 分 類</option>';
            Menu += '<option value="g">一 般 公 車</option>';
            Menu += '<option value="r">紅 線 公 車</option>';
            Menu += '<option value="o">橘 線 公 車</option>';
            Menu += '<option value="y">黃 線 公 車</option>';
            Menu += '<option value="m">幹 線 公 車</option>';
            Menu += '<option value="f">快 線 公 車</option>';
            Menu += '<option value="e">其 他 公 車</option>';
            Menu += '<option value="h">公 路 客 運</option>';
            Menu += '<option value="Q">收 費 方 式</option>';
            Menu += '</select>';
            
            $("#selMu").empty();
            $('#selMu').append(Menu);
        }
		*/
		
		
		function busMenu(){
            var Menu = '';
            
            var busUrl = location.href;
            var busClass = busUrl.split('/',10);
            Menu += '<select onchange="hrefto(this.value)" class="btn btn-outline-primary">';
            if(busClass[5]=="C"){ 
                Menu += '<option value="C" selected>請 選 公 車 分 類</option>';
            }
            else{
                Menu += '<option value="C">請 選 公 車 分 類</option>';
            }
            if(busClass[5]=="g"){ 
                Menu += '<option value="g" selected>一 般 公 車</option>';
            }
            else{
                Menu += '<option value="g">一 般 公 車</option>';
            }
            if(busClass[5]=="r"){
                Menu += '<option value="r" selected>紅 線 公 車</option>';
            }
            else{
                Menu += '<option value="r">紅 線 公 車</option>';
            }
            if(busClass[5]=="o"){
                Menu += '<option value="o" selected>橘 線 公 車</option>';
            }
            else{
                Menu += '<option value="o">橘 線 公 車</option>';
            }
            if(busClass[5]=="m"){
                Menu += '<option value="m" selected>幹 線 公 車</option>';
            }
            else{
                Menu += '<option value="m">幹 線 公 車</option>';
            }
            if(busClass[5]=="f"){
                Menu += '<option value="f" selected>快 線 公 車</option>';
            }
            else{
                Menu += '<option value="f">快 線 公 車</option>';
            }
            if(busClass[5]=="y"){
                Menu += '<option value="y" selected>黃 線 公 車</option>';
            }
            else{
                Menu += '<option value="y">黃 線 公 車</option>';
            }
            if(busClass[5]=="h"){
                Menu += '<option value="h" selected>公 路 客 運</option>';
            }
            else{
                Menu += '<option value="h">公 路 客 運</option>';
            }
            if(busClass[5]=="e"){
                Menu += '<option value="e" selected>其 他 公 車</option>';
            }
            else{
                Menu += '<option value="e">其 他 公 車</option>';
            }
            if(busClass[5]=="Q"){
                Menu += '<option value="Q" selected>收 費 方 式</option>';
            }
            else{
                Menu += '<option value="Q">收 費 方 式</option>';
            }
            Menu += '</select>';
            
            $("#selMu").empty();
            $('#selMu').append(Menu);
        }

    function line(){//
        var busUrl = location.href;
        if(location.href == 'https://tkowebtest.000webhostapp.com/KsCityBus'||location.href == 'https://tkowebtest.000webhostapp.com/KsCityBus/'){
            
        }
        else{
            var busClass = busUrl.split('/',10);
            if(busClass[5]=="g"){ LineTitle="一般公車"; }
            if(busClass[5]=="r"){ LineTitle="紅線公車"; }
            if(busClass[5]=="o"){ LineTitle="橘線公車"; }
            if(busClass[5]=="y"){ LineTitle="黃線公車"; }
            if(busClass[5]=="m"){ LineTitle="幹線公車"; }
            if(busClass[5]=="f"){ LineTitle="快線公車"; }
            if(busClass[5]=="h"){ LineTitle="公路客運"; }
            if(busClass[5]=="e"){ LineTitle="其他公車"; }

            if(busClass[5]=="g"||busClass[5]=="r"||busClass[5]=="e"||busClass[5]=="o"||busClass[5]=="y"||busClass[5]=="f"||busClass[5]=="h"||busClass[5]=="m"){
                jQuery.ajax({
                    method: "GET",
                    charset:"utf-8",
                    cache:"true",
                    dataType: "html",
                    async:false,
                    url: "/Curlbusline/Selebus/"+busClass[5],

                    success : function(Data) {
                        //變數初始化
                        BusLine = '';

                        //字串切割
                        var DataArr = Data.split('&',500);

                        BusLine += '<div style="background-color:#900;"><br>';
                        for(i=0; i<DataArr.length; i++)
                        {
                            busD = DataArr[i].split('*',10);
                            if(DataArr[i]!='' && busD[1]!=''){
                                BusLine += '<a href="/SeBusLine/busline/'+busD[0]+'" style="text-decoration:none;">';
                                BusLine += '<div class="alert alert-light" role="alert" id="alert">';
                                BusLine += '<a2>'+busD[1]+'</a2><br>';
                                BusLine += '<text>'+busD[2]+' - '+busD[3]+'</text></div></a>';
                            }
                        }
                        BusLine += '<br><br></div>';
						
                        $("#selMu").empty();
                        $("#busLine").empty();
                        $("#busLine").append('<div id="LineTitle">'+LineTitle+'</div');
                        $("#busLine").append(BusLine);
                    },
                    error: function(xhr, ajaxOptions, thrownError){ alert(xhr+'\n'+ajaxOptions+'\n'+thrownError) }
                });
            }
            else if(busClass[5]=="C"){
                document.location.href="/KsCityBus";
                View += '<br><div id="busLineC"><img src="/img/ksbus1.png"></img>';
                View += '<br>高雄公車夏日清涼，冬天暖心！</div>';
            }
            else if(busClass[5]=="Q"){
                var Menu = '';
                
                var busUrl = location.href;
                var busClass = busUrl.split('/',10);
                Menu += '<select onchange="hrefto(this.value)" class="btn btn-outline-primary">';
                Menu += '<option value="C">請 選 公 車 分 類</option>'
                Menu += '<option value="g">一 般 公 車</option>';
                Menu += '<option value="r">紅 線 公 車</option>';
                Menu += '<option value="o">橘 線 公 車</option>';
                Menu += '<option value="m">幹 線 公 車</option>';
                Menu += '<option value="f">快 線 公 車</option>';
                Menu += '<option value="y">黃 線 公 車</option>';
                Menu += '<option value="h">公 路 客 運</option>';
                Menu += '<option value="e">其 他 公 車</option>';
                Menu += '<option value="Q" selected>收 費 方 式</option>';
                Menu += '</select>';
                
                $("#selMu").empty();
                $('#selMu').append(Menu);

                var View = '';
                View += '<br><div align="left" id="Qdiv">';
                View += '<span style="color:red;font-size:16pt;">new~ <br>';
                View += '3月1日起市區公車一日兩段吃到飽、公路客運最高自付額60元、捷運轉乘市區公車折扣3元。</span><br><br>';
                View += '<span style="font-size:16pt;">一般票種</span><br>';
                View += '1.刷卡搭公車里程8公里以內算一段票，全票12元，半票6元，學生票10元(限具有照片且在效期內之數位學生證及高雄學生認同卡)。';
                View += '<br>2.超過8公里以上收二段票。';
                View += '<br><br><span style="font-size:16pt;">社福卡</span>';
                View += '<br>1.刷卡搭公車里程8公里以內，上車扣1點 下車扣0點。';
                View += '<br>2.刷卡搭公車里程8公里以上，上車扣1點 下車扣1點。';
                View += '</div>';
                View += '';

                $("#busLine").empty();
                $("#busLine").append(View);
            }
        }
    }

        function hrefto(id){
            document.location.href="/KsCityBus/ksbus/"+id;
        }
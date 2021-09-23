function seleBike(text)
        {
            if(text == 'Area')
            {
                $("#sele").empty();
                jQuery.ajax({
                    method: "GET",
                    charset:"utf-8",
                    cache:"true",
                    dataType: "html",
                    async:false,
                    url: "/Curlcitybike/Area",

                    success : function(Area) {
                        //變數初始化
                        VA_Area = '';

                        //字串切割
                        var AreaText = Area.split('&',100);

                        VA_Area += "<p><p><select onchange='seleBike(this.value)' style='height:28pt;'>";
                        VA_Area += "<option>請選擇行政區</option>";
                        for(i=0; i<AreaText.length; i++)
                        {
                            AreaD = AreaText[i].split(':',100);
                            if(AreaD[0]!='' && AreaD[1]!='')
                            {
                                VA_Area += "<option value='Area&"+AreaD[1]+"'>"+AreaD[0]+"</option>";
                            }
                        }
                        VA_Area +="</select>";

                        $("#Area").empty();
                        $('#Area').append(VA_Area);
                    },
                    error: function(xhr, ajaxOptions, thrownError){}
                });
            }
            else if(text == 'Q')
            {
				var Text = '';
				
				Text += '<div align="left">高雄市CityBike須持信用卡或記名電子票券才能借腳踏車，沒有記名過的一卡通，可在借車站的機台記名，記名需有綁定電話號碼，在機台上記名需攜帶手機在身上方便驗證。</div>';
				Text += '<br><div align="left">';
				Text += '<span style="font-size:16pt;">租賃費率</span><br>';
				Text += '<table id="BikeQ">';
				Text += '<tr>';
				Text += '<td id="BikeQtd1">時間/\收費方式&emsp;&nbsp;</td>';
				Text += '<td id="BikeQtd2">各卡種</td>';
				Text += '<td id="BikeQtd3">捷運轉腳踏車</td>';
				Text += '</tr>';
				Text += '<tr>';
				Text += '<td>0-30分鐘</td>';
				Text += '<td>費用0元</td>';
				Text += '<td>費用0元</td>';
				Text += '</tr>';
				Text += '<tr>';
				Text += '<td>31-60分鐘</td>';
				Text += '<td>費用5元</td>';
				Text += '<td>費用0元</td>';
				Text += '</tr>';
				Text += '<tr>';
				Text += '<td>61-90分鐘</td>';
				Text += '<td>費用10元</td>';
				Text += '<td>費用10元</td>';
				Text += '</tr>';
				Text += '<tr>';
				Text += '<td>91-120分鐘</td>';
				Text += '<td>費用20元</td>';
				Text += '<td>費用20元</td>';
				Text += '</tr>';
				Text += '<tr>';
				Text += '<td>121-150分鐘</td>';
				Text += '<td>費用20元</td>';
				Text += '<td>費用20元</td>';
				Text += '</tr>';
				Text += '<tr>';
				Text += '<td>151-180分鐘</td>';
				Text += '<td>費用20元&emsp;</td>';
				Text += '<td>費用20元</td>';
				Text += '</tr>';
				Text += '</table><br>';
				Text += '</div>';
				
				$("#Area").empty();
                $("#sele").empty();
				$('#sele').append(Text);
				}
            else if(text == 'C')
            {
				var indexText = '';
				
				indexText += '<div id="sele"><p>';
				indexText += '<img src="/img/KsBicycle_Logo1.png" width="25%"></img><br>';
				indexText += '<span style="font-size:18px; color:#A08;">歡迎使用高雄CityBike！</span>';
				indexText += '</div>';
				
                $("#Area").empty();
                $("#sele").empty();
				$('#sele').append(indexText);
            }
            else if(text == 'MRT')
            {
                $("#sele").empty();
                $("#Area").empty();
                jQuery.ajax({
                    method: "GET",
                    charset:"utf-8",
                    cache:"true",
                    dataType: "html",
                    async:false,
                    url: "/Curlcitybike/bikeline/MRT",
                    success : function(bike) {
                        //變數初始化
                        VA_bike = '';

                        //字串切割
                        var bikeText = bike.split('&',300);

                        VA_bike += '<br>';
                        for(i=0; i<bikeText.length-1; i++)
                        {
                            bikeD = bikeText[i].split(':',10);
                            VA_bike += '<div>';
                            VA_bike += '<div class="alert alert-primary" role="alert" style="width:90%" id="BikeStop">';
                            VA_bike += '<div id="stopName">'+bikeD[1]+'</div>';
                            VA_bike += '<div style="float: left;">';
                            VA_bike += '<button type="button" class="btn btn-outline-primary" onclick="BorRetBike('+bikeD[0]+')" id="btnlign">可借可還</button>&emsp;';
                            VA_bike += '</div><br><br><div id="div'+bikeD[0]+'" class="returnBike" align="left"></div>';
                            VA_bike += '<div id="addText">地址：';
                            VA_bike += '<a target="_blank" href="http://maps.google.com/?q='+bikeD[3]+','+bikeD[4]+'"><img src="img/mapImg1.png" width="60px"></a></div>';
                            VA_bike += '<div id="addr">'+bikeD[2]+"</div></div></div>";
                        }

                        $("#sele").empty();
                        $('#sele').append(VA_bike);
                    },
                    error: function(xhr, ajaxOptions, thrownError){}
                })
            }
            else if(text == 'S')
            {
                $("#Area").empty();
                jQuery.ajax({
                    method: "GET",
                    charset:"utf-8",
                    cache:"true",
                    dataType: "html",
                    async:false,
                    url: "/Curlcitybike/bikeline/S",
                    success : function(bike) {
                        //變數初始化
                        VA_bike = '';

                        //字串切割
                        var bikeText = bike.split('&',300);

                        VA_bike += '<br>';
                        for(i=0; i<bikeText.length-1; i++)
                        {
                            bikeD = bikeText[i].split(':',10);
                            VA_bike += '<div>';
                            VA_bike += '<div class="alert alert-primary" role="alert" style="width:90%">';
                            VA_bike += '<div id="stopName">'+bikeD[1]+'</div>';
                            VA_bike += '<div style="float: left;">';
                            VA_bike += '<button type="button" class="btn btn-outline-primary" onclick="BorRetBike('+bikeD[0]+')" id="btnlign">可借可還</button>&emsp;';
                            VA_bike += '</div><br><br><div id="div'+bikeD[0]+'" class="returnBike" align="left"></div>';
                            VA_bike += '<div id="addText">地址：';
                            VA_bike += '<a target="_blank" href="http://maps.google.com/?q='+bikeD[3]+','+bikeD[4]+'"><img src="img/mapImg1.png" width="60px"></a></div>';
                            VA_bike += '<div id="addr">'+bikeD[2]+"</div></div></div>";
                        }

                        $("#sele").empty();
                        $('#sele').append(VA_bike);
                    },
                    error: function(xhr, ajaxOptions, thrownError){}
                })
            }
            else if(text == 'E')
            {
                $("#sele").empty();
                $("#Area").empty();
                jQuery.ajax({
                    method: "GET",
                    charset:"utf-8",
                    cache:"true",
                    dataType: "html",
                    async:false,
                    url: "/Curlcitybike/bikeline/E",
                    success : function(bike) {
                        //變數初始化
                        VA_bike = '';

                        //字串切割
                        var bikeText = bike.split('&',300);

                        VA_bike += '<br>';
                        for(i=0; i<bikeText.length-1; i++)
                        {
                            bikeD = bikeText[i].split(':',10);
                            BikeId = bikeD[0]+"&"+bikeD[5];

                            VA_bike += '<div>';
                            VA_bike += '<div class="alert alert-primary" role="alert" style="width:90%">';
                            VA_bike += '<div id="stopName">'+bikeD[1]+'</div>';
                            VA_bike += '<div style="float: left;">';
                            VA_bike += '<button type="button" class="btn btn-outline-primary" onclick="BorRetBike('+bikeD[0]+')" id="btnlign">可借可還</button>&emsp;';
                            VA_bike += '</div><br><br><div id="div'+bikeD[0]+'" class="returnBike" align="left"></div>';
                            VA_bike += '<div id="addText">地址：';
                            VA_bike += '<a target="_blank" href="http://maps.google.com/?q='+bikeD[3]+','+bikeD[4]+'"><img src="img/mapImg1.png" width="60px"></a></div>';
                            VA_bike += '<div id="addr">'+bikeD[2]+"</div></div></div>";
                        }

                        $("#sele").empty();
                        $('#sele').append(VA_bike);
                    },
                    error: function(xhr, ajaxOptions, thrownError){}
                })
            }
            else
            {
                var AText = text.split('&',5);
                if(AText[0] == 'Area')
                {
                    jQuery.ajax({
                        method: "GET",
                        charset:"utf-8",
                        cache:"true",
                        dataType: "html",
                        async:false,
                        url: "/Curlcitybike/bikeline/"+AText[1],
                        success : function(bike) {
                            //變數初始化
                            VA_bike = '';

                            //字串切割
                            var bikeText = bike.split('&',300);

                            
                            for(i=0; i<bikeText.length-1; i++)
                            {
                                bikeD = bikeText[i].split(':',10);
                                VA_bike += '<div>';
                                VA_bike += '<div class="alert alert-primary" role="alert" style="width:90%">';
                                VA_bike += '<div id="stopName">'+bikeD[1]+'</div>';
                                VA_bike += '<div style="float: left;">';//
                                VA_bike += '<button type="button" class="btn btn-outline-primary" onclick="BorRetBike('+bikeD[0]+')" id="btnlign">可借可還</button>&emsp;';
                                VA_bike += '</div><br><br><div id="div'+bikeD[0]+'" class="returnBike" align="left"></div>';
                                VA_bike += '<div id="addText">地址：';
                                VA_bike += '<a target="_blank" href="http://maps.google.com/?q='+bikeD[3]+','+bikeD[4]+'"><img src="img/mapImg1.png" width="60px"></a></div>';
                                VA_bike += '<div id="addr">'+bikeD[2]+"</div></div></div>";
                            }

                            $("#sele").empty();
                            $('#sele').append(VA_bike);
                        },
                        error: function(xhr, ajaxOptions, thrownError){}
                    })
                }
            }
            
        }

        //借還車資訊
        function BorRetBike(BikeId)
        {
            jQuery.ajax({
                method: "GET",
                charset:"utf-8",
                cache:"true",
                dataType: "json",
                async:false,
                url: "https://ptx.transportdata.tw/MOTC/v2/Bike/Availability/Kaohsiung?$filter=StationUID%20eq%20'KHH"+BikeId+"'&$top=30&$format=JSON",

                success : function(borrowD) {
                    //清除借還車資訊
                    $("#div"+BikeId).empty();
                    //JSON轉字串
                    var borrowData = new Array();
                    var borrowData = JSON.stringify(borrowD);
                    //字串以:切割成陣列
                    var data = new Array();
                    data = borrowData.split('":',20);
                    //可借車數
                    var Borrdata = new Array();
                    Borrdata = data[4].split(',"',5);
                    //空車位
                    var Retrdata = new Array();
                    Retrdata = data[5].split(',"',5);
                    alert('可借車：'+Borrdata[0]+'台。\n空車位：'+Retrdata[0]+'位。');
                    $("#div"+BikeId).append('可借車：'+Borrdata[0]+'台，空車位：'+Retrdata[0]+'位。');
                },
                error: function(xhr, ajaxOptions, thrownError){}
            });
        }
        
        //借車資訊
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
                    alert('可借車：'+Bordata[0]+'台。');
                },
                error: function(xhr, ajaxOptions, thrownError){}
            });
            //
        }

        //還車資訊
        function returnBike(id)
        {
            jQuery.ajax({
                method: "GET",
                charset:"utf-8",
                cache:"true",
                dataType: "json",
                async:false,
                url: "https://ptx.transportdata.tw/MOTC/v2/Bike/Availability/Kaohsiung?$select=AvailableReturnBikes%20&$filter=StationUID%20eq%20'KHH"+id+"'&$top=30&$format=JSON",

                success : function(returnD) {
                    var returnData = new Array();
                    var returnData = JSON.stringify(returnD);

                    var Rdata = new Array();
		        	Rdata = returnData.split('AvailableReturnBikes":',100);
                    var Bordata = new Array();
		        	Bordata = Rdata[1].split(',"UpdateTime',100);
                    alert('空車位：'+Bordata[0]+'位。');
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr);
                }
            });
        }
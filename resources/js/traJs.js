
    function createBtn(id){
		DOMS = '<div class="container" style="margin-top:3vh;"><div class="row"><div class="col">';
		DOMS1 = '</div><div class="col" align="left">';
		DOMS2 = '</div></div></div>';
		stationToday='stationToday';
		stationNow='stationNow';
		stationTodayBtn = '<button type="button" class="btn btn-primary btn-sm" onclick="queD('+stationToday+', '+id+')">本日列車</button>';
		stationNowBtn = '<button type="button" class="btn btn-primary btn-sm" onclick="queD('+stationNow+', '+id+')">即時動態</button>';
		All = DOMS+stationTodayBtn+DOMS1+stationNowBtn+DOMS2;
		$("#Mline").empty();
		$("#TRABtn").empty();
		$("#TRABtn").append(All);
    }
	
	function queD(queStr, id){
		jQuery.ajax({
			method: "GET",
			charset:"utf-8",
			cache:"true",
			dataType: "json",
			async:false,
			url: "/TaiwanTRA/TRAD/"+queStr+"/"+id+"/P",
			success: function(Data){
				LData = '';
				if(Data.type=='success'){
					if(queStr=='stationNow'){
						if(Data.stationNow!=''){
							LData += '<div class="container" style="padding-top:3vh; padding-bottom:3vh;">';
							LData += '<div class="row"><div class="col"></div>';
							LData += '<div class="col-7" style="font-size:4vh;">列車即時動態.</div>';
							LData += '<div class="col"></div></div></div>';
							Data.stationNow.forEach(d =>{
								LData += '<div class="container" style="padding-bottom:5vh;">';
								LData += '<div class="row"><div class="col"></div>';
								LData += '<div class="col-7" align=left style="font-size:2.5vh;">車種: '+d.TrainTypeNameTW+'</div>';
								LData += '<div class="col"></div></div>';
								LData += '<div class="row"><div class="col"></div>';
								LData += '<div class="col-7" align=left style="font-size:2.5vh;">車次: '+d.TrainNo+'</div><div class="col"></div></div>';
								LData += '<div class="row"><div class="col"></div>';
								LData += '<div class="col-7" align=left style="font-size:2.5vh;">開往: '+d.GO+'</div><div class="col"></div></div>';
								LData += '<div class="row"><div class="col"></div>';
								LData += '<div class="col-7" align=left style="font-size:2.5vh;">路線: '+d.TripLine+'</div><div class="col"></div>';
								LData += '</div><div class="row"><div class="col"></div>';
								if(d.RunningStatus=='誤點'){
									LData += '<div class="col-7" align=left style="font-size:2.5vh;">狀態: <font color="'+d.color+'" size=4.75vw>●</font>'+d.RunningStatus+'&nbsp;&nbsp;'+d.DelayTime+'</div>';
								}
								else{
									LData += '<div class="col-7" align=left style="font-size:2.5vh;">狀態: <font color="'+d.color+'" size=4.75vw>●</font>'+d.RunningStatus+'</div>';
								}
								LData += '<div class="col"></div></div></div>';
							});
						}
					}
					else if(queStr=='stationToday'){
						if(Data.DS=='' && Data.DN==''){
							LData = '<div class="col-10" align=center style="padding:10vh 0;font-size:2.8vh; width:90%;">無列車上下行停靠.</div>';
						}
						else{
							if(Data.DN!=''){
								dn=Data.DN;
								LData += '<div class="container" style="padding-bottom:2vh; padding-top:2.5vh">';
								LData += '<div class="row"><div class="col"></div>';
								LData += '<div class="col-11" style="font-size:2.8vh;">本日上行車次</div>';
								LData += '<div class="col"></div></div></div>';
								dn.forEach(d =>{
									LData += '<div class="container" style="padding-bottom:3vh;"><div class="row"><div class="col"></div>';
									LData += '<div class="col-10" align=left>'+d.TrainTypeNameTW+'</div><div class="col"></div></div>';
									LData += '<div class="row"><div class="col"></div>';
									LData += '<div class="col-10" align=left>車次: '+d.TrainNo+'&emsp;&emsp;開往: '+d.DestinationStationNameTW+'</div>';
									LData += '<div class="col"></div></div><div class="row"><div class="col"></div>';
									LData += '<div class="col-10" align=left>搭車時間: '+d.ArrivalTime+'</div>';
									LData += '<div class="col"></div></div><div class="row"><div class="col"></div>';
									LData += '<div class="col-10" align=left>發車時間: '+d.DepartureTime+'</div>';
									LData += '<div class="col"></div></div></div>';
								});
							}
							else{
								LData += '<div class="container" style="padding-bottom:5vh;">';
								LData += '<div class="row"><div class="col"></div>';
								LData += '<div class="col-10" align=left>無列車上行停靠.</div>';
								LData += '<div class="col"></div></div></div>';
							}
							if(Data.DS!=''){
								ds=Data.DS;
								LData += '<div class="container" style="padding-bottom:2vh; padding-top:2.5vh">';
								LData += '<div class="row"><div class="col"></div>';
								LData += '<div class="col-11" style="font-size:2.8vh;">本日下行車次</div>';
								LData += '<div class="col"></div></div></div>';
								ds.forEach(d =>{
									LData += '<div class="container" style="padding-bottom:3vh;"><div class="row"><div class="col"></div>';
									LData += '<div class="col-10" align=left>'+d.TrainTypeNameTW+'</div><div class="col"></div></div>';
									LData += '<div class="row"><div class="col"></div>';
									LData += '<div class="col-10" align=left>車次: '+d.TrainNo+'&emsp;&emsp;開往: '+d.DestinationStationNameTW+'</div>';
									LData += '<div class="col"></div></div><div class="row"><div class="col"></div>';
									LData += '<div class="col-10" align=left>搭車時間: '+d.ArrivalTime+'</div>';
									LData += '<div class="col"></div></div><div class="row"><div class="col"></div>';
									LData += '<div class="col-10" align=left>發車時間: '+d.DepartureTime+'</div>';
									LData += '<div class="col"></div></div></div>';
								});
							}
							else{
								LData += '<div class="container" style="padding-bottom:5vh;">';
								LData += '<div class="row"><div class="col"></div>';
								LData += '<div class="col-10" align=left>無列車下行停靠資訊.</div>';
								LData += '<div class="col"></div></div></div>';
							}
						}
					} 
				}
				else{ 
					LData += '<div class="container" style="padding-bottom:5vh; padding-top:2.5vh">';
					LData += '<div class="row"><div class="col"></div>';
					LData += '<div class="col-10" style="font-size:2.8vh;">';
					// if(queStr=='stationNow'){
					// 	LData += '目前沒有列車進站.';
					// }
					// else if(queStr=='stationToday'){
					// 	LData += '無此站台列車停靠資訊.';
					// }
					LData += Data.type+': '+Data.errT;
					LData += '</div><div class="col"></div></div></div>';
				}
				$("#Mline").empty();
				$("#Mline").append(LData);
			},
			error: function(xhr, ajaxOptions, thrownError){}
		});
	}
	
	function TD(id){
		$("#TRABtn").empty();
		$("#Mline").empty();
		document.location.href="/TaiwanTRA/TTrastationd/"+id;
		/*
		jQuery.ajax({
			method: "GET",
			charset:"utf-8",
			cache:"true",
			dataType: "json",
			async:false,
			url: "/TaiwanTRA/Trastationd/0"+id,
			success : function(Data){
					Trastationd = '<select onchange="createBtn(this.value)" class="btn btn-outline-primary">'
					Trastationd = '<option value="z" selected>請 選 站 別</option>'
					Data.forEach(d=>{
						Trastationd += '<option value="'+d["StationID"]+'">'+d["StationNameTW"]+'</option>'
					});
					Trastationd += '</select>';
					$("#Trastationd").empty();
					$("#Trastationd").append(Trastationd);
			},
			error: function(xhr, ajaxOptions, thrownError){}
		});
		*/
	}
	
	$(function(){
		$("#gotop").click(function(){
			$("html,body").animate({scrollTop:0}, 900);
			return false;
		});
	});
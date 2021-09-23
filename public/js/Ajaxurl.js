function ajaxurl(id){
        var Mid = new Array();
        //var Mid = id.substring(0,3);
        var Mid = id.split("&");
        $(Mid[1]).empty();
        $.ajax({
        method: "GET",
        url: "http://data.kaohsiung.gov.tw/Opendata/MrtJsonGet.aspx?site="+Mid[0],//+id,//
        })
      .done(function( msg ) {
        console.log(msg);
        var MrtLineData = new Array();
        var MrtLineData = msg.split('}, {',10);

        //判斷末班車
        var LineE = new Array();
        var LineE = MrtLineData[0].split('"arrival":"',10);
        var LineEnd = new Array();
        var LineEnd = LineE[1].split('","next_arriva',10);
        var NLineE = new Array();
        var NLineE = MrtLineData[1].split('"arrival":"',10);
        var NLineEnd = new Array();
        var NLineEnd = NLineE[1].split('","next_arriva',10);
        if(LineEnd[0] == "e" && NLineEnd[0] == "e")
        {
            var ToNS = "</p><span>末班車已駛離</span>";
        }
        else
        {
            if(Mid[0]=='101' || Mid[0]=='124' || Mid[0]=='201' || Mid[0]=='214')
            {
                //取第一站與最後一站往反方向名稱
                var ToN = new Array();
                var ToN = MrtLineData[0].split('descr":"',10);
                var ToN1 = new Array();
                var ToN1 = ToN[1].split('","arrival"',10);

                //取第一站與最後一站往反方向下一班時間
                var thistime = new Array();
                var thistime = MrtLineData[0].split('"arrival":"',10);
                var thistime1 = new Array();
                var thistime1 = thistime[1].split('","next_arriva',10);
                if(thistime1[0] == '--'){ exttime2 = '未發車.'; }
                else if(thistime1[0] == 0){ exttime2 = '進站中.'; }
                else{ exttime2 = thistime1[0].concat("分鐘後"); }

                //取第一站與最後一站往反方向下下一班時間
                var nexttime = new Array();
                var nexttime = MrtLineData[0].split('"next_arrival":"',10);
                var nexttime1 = new Array();
                var nexttime1 = nexttime[1].split('"},',10);
                if(nexttime1[0] == '--'){ nexttime2 = '未發車</span><br>'; }
                else{ nexttime2 = nexttime1[0].concat("分鐘後</span><br>"); }
                $("button1").remove();

                //字串組合
                var ToNS = "</p>".concat("<span>往",ToN1[0],":&emsp;<br>下一班：",exttime2,"&nbsp;/&nbsp;下下班：",nexttime2);//往:",ToN1[0],"<br>
            }
            else
            {
                //取往南岡山or大寮名稱
                var ToN = new Array();
                var ToN = msg.split('{ "MRT":[{ "descr":"',10);
                var ToN1 = new Array();
                var ToN1 = ToN[1].split('","arrival"',10);

                //取往南岡山or大寮下一班時間
                var thistime = new Array();
                var thistime = msg.split('"arrival":"',10);
                var thistime1 = new Array();
                var thistime1 = thistime[1].split('","next_arriva',10);
                if(thistime1[0] == '--'){ exttime2 = '未發車'; }
                else if(thistime1[0] == 0){ exttime2 = '進站中'; }
                else{ exttime2 = thistime1[0].concat("分鐘後"); }

                //取往南岡山or大寮下下一班時間
                var nexttime = new Array();
                var nexttime = msg.split('"next_arrival":"',10);
                var nexttime1 = new Array();
                var nexttime1 = nexttime[1].split('"},',10);
                if(nexttime1[0] == '--'){ nexttime2 = '未發車</span><br>'; }
                else{ nexttime2 = nexttime1[0].concat("分鐘後</span><br>"); }

                //往南岡山or大寮字串組合
                var ToE = "</p>".concat("<span>往",ToN1[0],":&emsp;<br>下一班：",exttime2,"&nbsp;/&nbsp;下下班：",nexttime2);//往:",ToN1[0],"<br>


                //取往小港or西子灣名稱
                var ToWe = new Array();
                var ToWe = msg.split('"}, { "descr":"',10);
                var ToWe1 = new Array();
                var ToWe1 = ToWe[1].split('","arrival"',10);
                var ToWes = ToWe1[0];

                //取往小港or西子灣下一班時間
                var Wtime = "".concat(ToWe1[0],'"arrival":"');
                var Wthistime = new Array();
                var Wthistime = msg.split(':',20);
                var Wthistime1 = new Array();
                var Wthistime1 = Wthistime[6].split('","next_arriva',10);
                var Wthistimes = new Array();
                var Wthistimes = Wthistime1[0].split('"',10);
                if(Wthistimes[1] == '--'){ Wexttime2 = '未發車'; }
                else if(Wthistimes[1] == 0){ Wexttime2 = '進站中'; }
                else{ Wexttime2 = Wthistimes[1].concat("分鐘後"); }

                //取往小港or西子灣下下一班時間
                var Wnexttime = new Array();
                var Wnexttime = msg.split('"next_arrival":"',10);
                var Wnexttime1 = new Array();
                var Wnexttime1 = Wthistime[7].split('"},',10);
                var Wnexttimes = new Array();
                var Wnexttimes = Wnexttime1[0].split('"}',10);
                var Wnexttimess = new Array();
                var Wnexttimess = Wnexttime1[0].split('"',10);
                if(Wnexttimess[1] == '--'){ Wnexttime2 = '未發車</span><br>'; }
                else{ Wnexttime2 = Wnexttimess[1].concat("分鐘後</span><br>"); }

                //往小港or西子灣字串組合
                var ToWest = "".concat("<span>往",ToWes,":&emsp;<br>下一班：",Wexttime2,"&nbsp;/&nbsp;下下班：",Wnexttime2);//往:",ToN1[0],"<br>

                //組合雙向字串
                var ToNS = "".concat(ToE,ToWest);
                $("button1").remove();
            }
        }
        $(Mid[1]).append(ToNS);

      });
      }


      function fajaxurl(id){
        var Mid = new Array();
        var Mid = id.split("&");
        $(Mid[1]).empty();
        $.ajax({
        method: "GET",
        url: "http://data.kaohsiung.gov.tw/Opendata/MrtJsonGet.aspx?site="+Mid[0],//+id,//
        })
      .done(function( msg ) {
        console.log(msg);
        var LineData = new Array();
        var LineData = msg.split('}, { ');

        //往大寮
        var EStaName = new Array();
        EStaName = LineData[0].split('"descr":"',10);
        var EaStaName = new Array();
        EaStaName = EStaName[1].split('","arrival',10);
        //下一班
        var Earrival = new Array();
        Earrival = LineData[0].split('arrival":"',10);
        var Eaarrival = new Array();
        Eaarrival = Earrival[1].split('","next_',10);
        if(Eaarrival[0] == '--'){ Eaarrivals = '未發車'; }
        else if(Eaarrival[0] == 0){ Eaarrivals = '進站中'; }
        else{ Eaarrivals = Eaarrival[0].concat("分鐘後"); }
        //下下一班
        var Enextarrival = new Array();
        Enextarrival = LineData[0].split('next_arrival":"',10);
        var Eanextarrival = new Array();
        Eanextarrival = Enextarrival[1].split('"',10);
        if(Eanextarrival[0] == '--'){ Eanextarrivals = '未發車</span><br>'; }
        else{ Eanextarrivals = Eanextarrival[0].concat("分鐘後</span><br>"); }

        var EastLine = "".concat("</p>往",EaStaName[0],"：<br>下一班:&nbsp;",Eaarrivals,"&nbsp;/&nbsp;下下一班:&nbsp;",Eanextarrivals);

        //往西子灣
        var WStaName = new Array();
        WStaName = LineData[1].split('"descr":"',10);
        var WeStaName = new Array();
        WeStaName = WStaName[1].split('","arrival',10);
        //下一班
        var Warrival = new Array();
        Warrival = LineData[1].split('arrival":"',10);
        var Wearrival = new Array();
        Wearrival = Warrival[1].split('","next_',10);
        if(Wearrival[0] == '--'){ Wearrivals = '未發車'; }
        else if(Wearrival[0] == 0){ Wearrivals = '進站中'; }
        else{ Wearrivals = Wearrival[0].concat("分鐘後"); }
        //下下一班
        var Wnextarrival = new Array();
        Wnextarrival = LineData[1].split('next_arrival":"',10);
        var Wenextarrival = new Array();
        Wenextarrival = Wnextarrival[1].split('"',10);
        if(Wenextarrival[0] == '--'){ Wenextarrivals = '未發車</span><br>'; }
        else{ Wenextarrivals = Wenextarrival[0].concat("分鐘後</span><br>"); }

        var WestLine = "".concat("</p>往",WeStaName[0],"：<br>下一班:&nbsp;",Wearrivals,"&nbsp;/&nbsp;下下一班:&nbsp;",Wenextarrivals);

        //往南岡山
        var NStaName = new Array();
        NStaName = LineData[2].split('"descr":"',10);
        var WeStaName = new Array();
        NoStaName = NStaName[1].split('","arrival',10);
        //下一班
        var Narrival = new Array();
        Narrival = LineData[2].split('arrival":"',10);
        var Noarrival = new Array();
        Noarrival = Narrival[1].split('","next_',10);
        if(Noarrival[0] == '--'){ Noarrivals = '未發車'; }
        else if(Noarrival[0] == 0){ Noarrivals = '進站中'; }
        else{ Noarrivals = Noarrival[0].concat("分鐘後"); }
        //下下一班
        var Nnextarrival = new Array();
        Nnextarrival = LineData[2].split('next_arrival":"',10);
        var Nonextarrival = new Array();
        Nonextarrival = Nnextarrival[1].split('"',10);
        if(Nonextarrival[0] == '--'){ Nonextarrivals = '未發車</span><br>'; }
        else{ Nonextarrivals = Nonextarrival[0].concat("分鐘後</span><br>"); }

        var NostLine = "".concat("</p>往",NoStaName[0],"：<br>下一班:&nbsp;",Noarrivals,"&nbsp;/&nbsp;下下一班:&nbsp;",Nonextarrivals);

        //往南岡山
        var SStaName = new Array();
        SStaName = LineData[3].split('"descr":"',10);
        var SoStaName = new Array();
        SoStaName = SStaName[1].split('","arrival',10);
        //下一班
        var Sarrival = new Array();
        Sarrival = LineData[3].split('arrival":"',10);
        var Soarrival = new Array();
        Soarrival = Sarrival[1].split('","next_',10);
        if(Soarrival[0] == '--'){ Soarrivals = '未發車'; }
        else if(Soarrival[0] == 0){ Soarrivals = '進站中'; }
        else{ Soarrivals = Soarrival[0].concat("分鐘後"); }
        //下下一班
        var Snextarrival = new Array();
        Snextarrival = LineData[3].split('next_arrival":"',10);
        var Sonextarrival = new Array();
        Sonextarrival = Snextarrival[1].split('"',10);
        if(Sonextarrival[0] == '--'){ Sonextarrivals = '未發車</span><br>'; }
        else{ Sonextarrivals = Sonextarrival[0].concat("分鐘後</span><br>"); }

        var SostLine = "".concat("</p>往",SoStaName[0],"：<br>下一班:&nbsp;",Soarrivals,"&nbsp;/&nbsp;下下一班:&nbsp;",Sonextarrivals);

        var ToNS = EastLine+WestLine+NostLine+SostLine;
        $(Mid[1]).append(ToNS);

      });
      }
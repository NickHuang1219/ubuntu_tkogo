<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class mrtConinCurlController extends Controller
{
	public function getMRTTime($Line,$str){
		if($str=='se'){
            $this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
			// $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
            $this->db->exec("set names utf8");
            $seleMrt = $this->db->query("SELECT * FROM mrt WHERE `ODMRT_Name` = '".$Line."' && `MEnable` = '1'");
            $MrtCount = $seleMrt->fetchAll(PDO::FETCH_ASSOC);
            if($MrtCount==null){
                $mrtStationD['type'] = 'e';
                $mrtStationD['errT'] = '此站台停止停服務！';
                return json_encode($mrtStationD);
            }
            else{
                return $this->getMTime($Line);
            }
        }
        else{
            $mrtStationD['type'] = 'e';
            $mrtStationD['errT'] = '權限不足.';
            return json_encode($mrtStationD);
        }
    }
	public function getMTime($Line){
		#----------------------------
		#變數初始化
		#----------------------------
		$mrtStationD = array();
		$stationN = array();
		$goD = array();
		$backD= array();
		
		//OData ID&Key
		//L1
		$appId = '5631949d5d2e45279ea8124254e8780a';
		$appKey = 'Jd3jTb7fltKz4skNHFrF1kFz16k';
		//L2
		//$appId = 'd9c2907546174d2c9fe8e0582f60c9e7';
		//$appKey = 'hlQwPHu0JGqAP9GGOFSpqS589s4';
		
		//連接網址
		$SELE_Line = 'OT1';
		$url = 'https://ptx.transportdata.tw/MOTC/v2/Rail/Metro/LiveBoard/KRTC?$filter=StationID%20eq%20%27'.$Line.'%27&$top=10&$format=JSON';
		
		//取得UTC時間
		//date_default_timezone_set('Asia/Shanghai');
		//date_default_timezone_set('UTC');
	//	$timestamp=date("D, d M Y H:i:s \G\M\T");//." GMT";
	//	$timestamp=date("D, d M Y H:i:s GMT");//." GMT";
		$dow_map = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
		$timestamp = $dow_map[date("w")] . ", " . gmdate("d M Y H:i:s") . " GMT";
		
		// 簽章
		$signature = base64_encode(hash_hmac('sha1', 'x-date: '.$timestamp, $appKey, true ));
		
		// 認證欄位
		$authorization = 'hmac username="'.$appId.'", algorithm="hmac-sha1", headers="x-date", signature="'.$signature.'"';
		

		//送出查詢
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch , CURLOPT_HTTPHEADER, array(
			'Authorization: ' . $authorization,
			'x-date: ' . $timestamp,
			'Accept: ' . 'application/json',
			"Cache-Control: no-cache"
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$result=curl_exec($ch);
		$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);

        if($httpCode==200){
            $d = json_decode(json_encode(json_decode($result)), true);
            if(count($d)==0){
                    $mrtStationD['StatusCode'] = 0;
                    $mrtStationD['mrtD'] = null;
                    $mrtStationD['type'] = 'w';
                    $mrtStationD['errT'] = '捷運伺服器無訊息回傳.';
                    return json_encode($mrtStationD);
            }
            else{
                for($m=0; $m<count($d); $m++){
                    if($m==0){
                        $goD['goTName'] = '往 '.$d[$m]['DestinationStationName']['Zh_tw'];
				        $goD['goEName'] = 'Go to '.$d[$m]['DestinationStationName']['En'];
				        $goD['goConinTime'] = $this->dugeTime($d[$m]['EstimateTime']);
				        $mrtStationD['goD'] = $goD;
                        $backD['backTName'] = '';
				        $backD['backEName'] = '';
				        $backD['backConinTime'] = '';
				        $mrtStationD['backD'] = $backD;
                    }
                    else if($m==1){
                        $backD['backTName'] = '往 '.$d[$m]['DestinationStationName']['Zh_tw'];
				        $backD['backEName'] = 'Go to '.$d[$m]['DestinationStationName']['En'];
				        $backD['backConinTime'] = $this->dugeTime($d[$m]['EstimateTime']);
				        $mrtStationD['backD'] = $backD;
				        // $mrtStationD['dataCount'] = 2;
                    }
                }
                $mrtStationD['stationLineID'] = $Line;
				$mrtStationD['type'] = 's';
                $mrtStationD['stationN'] = $d[0]['StationName']['Zh_tw'];
                $mrtStationD['dataCount'] = count($d);
                return json_encode($mrtStationD);
            }
        }
        else{
            $mrtStationD['StatusCode'] = 0;
            $mrtStationD['mrtD'] = null;
            $mrtStationD['type'] = 'w';
            $mrtStationD['errT'] = '捷運伺服器異常.';
            return json_encode($mrtStationD);
        }
		// print_r($d);//gettype()//json_decode($result)
        /*
        [
            {
                "LineNO":"R",
                "LineID":"R",
                "LineName":{
                                "Zh_tw":"紅線",
                                "En":""
                            },
                "StationID":"R6",
                "StationName":{
                                "Zh_tw":"凱旋",
                                "En":"Kaisyuan"
                            },
                "TripHeadSign":"往小港",
                "DestinationStaionID":"R3",
                "DestinationStationID":"R3",
                "DestinationStationName":{
                                            "Zh_tw":"小港",
                                            "En":"Siaogang"
                                        },
                "EstimateTime":6,
                "SrcUpdateTime":"2021-08-01T10:46:38+08:00",
                "UpdateTime":"2021-08-01T10:46:53+08:00"
            },
            {
                "LineNO":"R",
                "LineID":"R",
                "LineName":{
                            "Zh_tw":"紅線",
                            "En":""
                        },
                "StationID":"R6",
                "StationName":{
                                "Zh_tw":"凱旋","En":"Kaisyuan"
                            },
                "TripHeadSign":"往南岡山",
                "DestinationStaionID":"R24",
                "DestinationStationID":"R24",
                "DestinationStationName":{
                                            "Zh_tw":"南岡山",
                                            "En":"Gangshan South"
                                        },
                "EstimateTime":6,
                "SrcUpdateTime":"2021-08-01T10:46:38+08:00",
                "UpdateTime":"2021-08-01T10:46:53+08:00"
            }
            ]
		*/

		// $jsonT = explode('"},"TripHeadSign":"',$result);
		// //捷運站名
		// $lineNameExp1 = explode('","StationName":{"Zh_tw":"',$jsonT[0]);
		// $lineNameExp2 = explode('","En":"',$lineNameExp1[1]);
		// if($lineNameExp2[0]=='' || $lineNameExp2[0]==null){
		// 	$mrtStationD['StatusCode'] = 0;
		// 	$mrtStationD['mrtD'] = null;
		// 	$mrtStationD['type'] = 'w';
		// 	$mrtStationD['errT'] = '捷運伺服器無訊息回傳！';
		// 	echo json_encode($mrtStationD);
		// }
		// else{
		// 	$stationN['stationTName']= $lineNameExp2[0];
		// 	$stationN['stationEName']= $lineNameExp2[1];
			
			
		// 	$goconinTime1 = explode(',"EstimateTime":',$result);
		// 	$goConinTime2 = explode(',"SrcUpdateTime"',$goconinTime1[1]);
		// 	$goConinTime = $goConinTime2[0];//$this->dugeTime($goConinTime2[0]);
		// 	$goStr1 = explode('"DestinationStationName":{"Zh_tw":"',$jsonT[1]);
		// 	$goStr2 = explode('"},"EstimateTime',$goStr1[1]);
		// 	$go = explode('","En":"',$goStr2[0]);
		// 	$goD['goTName'] = '往 '.$go[0];
		// 	$goD['goEName'] = 'Go to '.$go[1];
		// 	$goD['goConinTime'] = $this->dugeTime($goConinTime);
			
		// 	//回傳資料組合
		// 	$mrtStationD['stationN'] = $stationN;
		// 	$mrtStationD['goD'] = $goD;
		// 	$mrtStationD['httpCode'] = $httpCode;
		// 	$mrtStationD['StatusCode'] = 200;
		// 	$mrtStationD['mrtD'] = 'yes';
		// 	$mrtStationD['type'] = 's';
		// 	$mrtStationD['errT'] = '';
			
		// 	//資料筆數判別
		// 	if(count($jsonT)<3){
		// 		$mrtStationD['dataCount'] = 1;
		// 		echo json_encode($mrtStationD);
		// 	}
		// 	if(count($jsonT)>2){
		// 		$backStr1 = explode(',"DestinationStationName":{"Zh_tw":"',$jsonT[2]);
		// 		$backStr2 = explode('"},"EstimateTime":',$backStr1[1]);
		// 		$back = explode('","En":"',$backStr2[0]);
		// 		$backConinTime1 = explode(',"SrcUpdateTime',$backStr2[1]);
		// 		$backConinTime = $backConinTime1[0];//$this->dugeTime($backConinTime1[0]);
				
		// 		//回傳資料組合
		// 		$backD['backTName'] = '往 '.$back[0];
		// 		$backD['backEName'] = 'Go to '.$back[1];
		// 		$backD['backConinTime'] = $this->dugeTime($backConinTime);
		// 		$mrtStationD['backD'] = $backD;
		// 		$mrtStationD['dataCount'] = 2;
		// 		echo json_encode($mrtStationD);
		// 	}
		// }
    }
	public function dugeTime($str){
		if((int)$str==0){
			return '進站中.';
		}
		else if((int)$str==1){
			return '即將進站.';
		}
		else{
			return $str.'分鐘.';
		}
		if($str=='e'){
			return '末班車已駛離.';
		}
	}
}

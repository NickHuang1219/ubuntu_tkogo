<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class lrtConinCurlController extends Controller
{
    public function getLRTTime($Line, $str){
		if($str=='sel'||$str=='se'){
            $this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
			// $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
            $this->db->exec("set names utf8");
            $seleLrt = $this->db->query("SELECT * FROM lrtstation WHERE StationID='".$Line."' && oc='1'");
            $LrtCount = $seleLrt->fetchAll(PDO::FETCH_ASSOC);
            if($LrtCount==null){
                $mrtStationD['type'] = 443;
                $mrtStationD['errT'] = '此站台停止停服務！';
                return json_encode($mrtStationD);
            }
            else{
				return $this->getTime($Line);
            }
		}
        else{
            $mrtStationD['type'] = 500;
            $mrtStationD['errT'] = '權限不足.';
            return json_encode($mrtStationD);
        }
	}
    public function getTime($id){
		#----------------------------
		#變數初始化
		#----------------------------
		$reD = array();
		
		//OData ID&Key
		//L1
		$appId = '5631949d5d2e45279ea8124254e8780a';
		$appKey = 'Jd3jTb7fltKz4skNHFrF1kFz16k';
		//L2
		// $appId = 'd9c2907546174d2c9fe8e0582f60c9e7';
		// $appKey = 'hlQwPHu0JGqAP9GGOFSpqS589s4';
		
		
		//連接網址
		$url = 'https://ptx.transportdata.tw/MOTC/v2/Rail/Metro/LiveBoard/KLRT?$filter=StationID%20eq%20%27'.$id.'%27&$top=30&$format=JSON';
		
		//取得UTC時間
		//date_default_timezone_set('Asia/Shanghai');
		//date_default_timezone_set('UTC');
	//	$timestamp=date("D, d M Y H:i:s \G\M\T");//." GMT";
	//	$timestamp=date("D, d M Y H:i:s GMT");//." GMT";
		$dow_map = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
		$timestamp = $dow_map[date("w")] . ", " . gmdate("d M Y H:i:s") . " GMT";
		#echo "<br><br>timestamp: ".$timestamp."<br>";
		
		// 簽章
		$signature = base64_encode(hash_hmac('sha1', 'x-date: '.$timestamp, $appKey, true ));
		#echo "<br><br>signature: ".$signature."<br><br><br><br>";
		
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
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLINFO_HTTP_CODE, 1);
		
		$result=curl_exec($ch);
		$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		#curl_close($ch);
		// print_r($result);
		#echo $httpCode;

		if($httpCode==200){
			$d = json_decode(json_encode(json_decode($result)), true);
			if(count($d)==0){
				$reD['type'] = 4044;
				$reD['typeTxt'] = '捷運伺服器無回傳資料.';
			}
			else{
				$reD['type'] = 200;
				$reD['stationLineID'] = $id;
				for($l=0; $l<count($d); $l++){
					if($l==0){
						// if(isset($d[$l]['LineName']['Zh_tw'])){
						// 	$reD['Station'] = $d[$l]['LineName']['Zh_tw'];
						// }
						// else{
						// 	$reD['Station'] = '---';
						// }
						// if(isset($d[$l]['DestinationStationName']['Zh_tw'])){
						// 	$reD['toGo'] = '往 '.$d[$l]['DestinationStationName']['Zh_tw'];
						// }
						// else{
						// 	$reD['toGo'] = '往 ---';
						// }
						$reD['Station'] = $d[$l]['StationName']['Zh_tw'];
						$reD['toGo'] = '往 '.$d[$l]['DestinationStationName']['Zh_tw'];
						$reD['GoTime'] = $this->cheTime($d[$l]['EstimateTime']);
						$reD['toBack'] = '';
						$reD['BackTime'] = '';
					}
					if($l==1){
						$reD['Station'] = $d[$l]['StationName']['Zh_tw'];
						$reD['toBack'] = '往 '.$d[$l]['DestinationStationName']['Zh_tw'];
						$reD['BackTime'] = $this->cheTime($d[$l]['EstimateTime']);
					}
				}
			}
		}
		else{
			$reD['type'] = 404;
			$reD['typeTxt'] = '捷運伺服器異常.';
		}
		return json_encode($reD);
    }

	public function cheTime($t){
		if($t==-1){
			return '末班車駛離.';
		}
		else if($t==0){
			return '進站中.';
		}
		else if($t<3){
			return '即將進站.';
		}
		else if($t>2){
			return $t.'分鐘.';
		}
		else if($t==null){
			return '---';
		}
	}
}

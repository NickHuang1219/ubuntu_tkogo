<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class bikeConinCurlController extends Controller
{
    public function getBike($id,$str){
		#----------------------------
		#變數初始化
		#----------------------------
		$BikeData = array();

		if($str=='se'){
			$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
			// $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
			$this->db->exec("set names utf8");
			$seleBike = $this->db->query("SELECT * FROM bikedata WHERE StationUID='".$id."' && Enable=1");
			$BikeCount = $seleBike->fetchAll(PDO::FETCH_ASSOC);
            if($BikeCount==null){
                $BikeData['type'] = 443;
                $BikeData['errT'] = '此站台停止停服務！';
                return json_encode($BikeData);
            }
            else{
				return $this->BikeValue($id);
            }
		}
		else{
            $BikeData['type'] = 500;
            $BikeData['errT'] = '權限不足.';
            return json_encode($BikeData);
		}
		
	}
	public function BikeValue($id){
		#----------------------------
		#變數初始化
		#----------------------------
		$BikeD = array();
        
		//OData ID&Key
		//L1
		$appId = '5631949d5d2e45279ea8124254e8780a';
		$appKey = 'Jd3jTb7fltKz4skNHFrF1kFz16k';
		//L2
		//$appId = 'd9c2907546174d2c9fe8e0582f60c9e7';
		//$appKey = 'hlQwPHu0JGqAP9GGOFSpqS589s4';
		
		//連接網址
		$url = 'https://ptx.transportdata.tw/MOTC/v2/Bike/Availability/Kaohsiung?$filter=StationUID%20eq%20%27'.$id.'%27&$top=30&$format=JSON';
		
		//取得UTC時間
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
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLINFO_HTTP_CODE, 1);
		
		$result=curl_exec($ch);
		$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		
		if($httpCode==200){
			$d = json_decode(json_encode(json_decode($result)), true);
			// print_r($d[0]);
			if(count($d)==0){
				$BikeD['type'] = 403;
				$BikeD['errT'] = 'YouBike無回傳資訊.';
			}
			else{
				if($d[0]['ServiceStatus']==0){
					$BikeD['errT'] = '此站停止服務.';
					$BikeD['type'] = $d[0]['ServiceStatus'];
					$BikeD['Rent'] = '';
					$BikeD['Return'] = '';
				}
				else if($d[0]['ServiceStatus']==1){
					$BikeD['errT'] = '';
					$BikeD['stationLineID'] = $id;
					//服務狀態
					$BikeD['type'] = $d[0]['ServiceStatus'];
					//可借
					$BikeD['Rent'] = '可借車輛: '.$d[0]['AvailableRentBikes']."台。";
					//可還
					$BikeD['Return'] = "可還車位: ".$d[0]['AvailableReturnBikes']."位。";
				}
				else if($d[0]['ServiceStatus']==2){
					$BikeD['errT'] = '此站暫停服務.';
					$BikeD['type'] = $d[0]['ServiceStatus'];
					$BikeD['Rent'] = '';
					$BikeD['Return'] = '';
				}
			}
		}
		else{
            $BikeD['type'] = 404;
            $BikeD['errT'] = 'YouBike伺服器異常.';
		}
		return json_encode($BikeD);
	}

}

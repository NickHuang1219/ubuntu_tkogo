<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

use App\Http\Controllers\mrtConinCurlController;
use App\Http\Controllers\lrtConinCurlController;

class TkoMrtController extends Controller
{
    public function index()
	{
		// return '私は髙雄がすきです';
	}

	public function __construct()
    {
		// $this->users = $users;
		$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
	}
	
    public function Mrtindex()
	{
		// $users = DB::table('mrt')->get();
		// DB::select('select * from mrt where ODMRT_Code>=100 AND ODMRT_Code<200', [100]);
		// print_r($users);

		// $db = new PDO('mysql:host=localhost;dbname=id5748318_tkolifego;charset=utf8', 'root', '');
		// foreach ($db->query('SELECT * FROM mrt where ODMRT_Code>=100 AND ODMRT_Code<200') as $row) {
		// 	echo "<li>".$row['ODMRT_Name']." - ".$row['ODMRT_CName']."</li>";
		// }

		$data = ['h'=>'私は髙雄がすきです'];
		$h = '私は髙雄がすきです';
		return view('TKOMrt', [
								'mrt'=>$row=null,
								'lrt'=>$row=null,
								'lineClass'=>'請選擇 路線',
								'rAdd'=>'Mrt/r',
								'oAdd'=>'Mrt/o',
								'mAdd'=>'Mrt/formosa',
								'topBtn'=>false,
									'mrtMeun'=>[
											['Addr'=>'../Mrt/r','lineName'=>'紅線捷運',],
											['Addr'=>'../Mrt/o','lineName'=>'橘線捷運',],
											['Addr'=>'../Mrt/CL','lineName'=>'環狀輕軌',],
									],
								'dColor'=>'',
								'bColor'=>'',
								'borColor'=>'',
								'titleImg'=>"{{ URL::asset('resources/img/tkoMRT.png') }}",
		]);
	}

	public function MrtLineConn($id, $type){
		if($type=='r' || $type=='o'){
			$mrtConn = new mrtConinCurlController;
			return $mrtConn->getMRTTime($id, 'se');
		}
		else if($type=='CL'){
			$lrtConn = new lrtConinCurlController;
			return $lrtConn->getLRTTime($id, 'se');
		}
	}

	public function MrtLine($id){
		$lineD = array();
		$i = 0;
		$line = $this->db->query("SET NAMES 'utf8'");
		if($id=='r'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=100 AND ODMRT_Code<200');
			$this->row=$line->fetchAll();
			$this->lrt='';
			$this->dColor='#f8d7da';
			$this->bColor='#dc3545';
			$this->borColor='#dc3545';
			$this->lineClass='目前: 紅線捷運路線';
		}
		else if($id=='o'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=200 AND ODMRT_Code<250');
			$this->row=$line->fetchAll();
			$this->lrt='';
			$this->dColor='#ffeeba';
			$this->bColor='#ffc107';
			$this->borColor='#ffc107';
			$this->lineClass='目前: 橘線捷運路線';
		}
		else if($id=='CL'){
			$CLi = 0;
			$CLD = array();
			$line = $this->db->query('SELECT * FROM `lrtstation` WHERE oc=1 ORDER BY StationNum ASC');
			$AllLRTD = $line->fetchAll();
			\Log::info('postt'.json_encode($AllLRTD));
			\Log::info('postt'.gettype($AllLRTD));
			foreach($AllLRTD as $v){
				#\Log::info('$CLi==count($AllLRTD): '.json_encode($CLD));
				$CLD[$CLi]['ODMRT_Name'] = $v['StationID'];
				$CLD[$CLi]['ODMRT_CName'] = $v['StationName_TW'];
				\Log::info('CLD-'.$CLi.': '.json_encode($CLD));
				if($CLi+1==count($AllLRTD)){ $this->lrt=$CLD; $this->row=''; }
				$CLi = $CLi+1;
			}
			
			$this->dColor='#d4edda';
			$this->bColor='#28a745';
			$this->borColor='#28a745';
			$this->lineClass='目前: 環狀輕軌';
		}
		else if($id=='formosa'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=300 AND ODMRT_Code<1000');
			// $row=$line->fetchAll();
			return view('TKOMrt', [
									'mrt'=>$row,
									'lineClass'=>'目前: 美麗島站',
									'rAdd'=>'../Mrt/r',
									'oAdd'=>'../Mrt/o',
									'mAdd'=>'../Mrt/formosa',
									'dColor'=>'#d4edda',
									'bColor'=>'#28a745',
									'borColor'=>'#28a745',
									'titleImg'=>"{{ URL::asset('resources/img/tkoMRT.png') }}",
			]);//compact('h3'));,  $data
		}
		return view('TKOMrt', [
								'mrt'=>$this->row,
								'lrt'=>$this->lrt,
								'lineClass'=>$this->lineClass,
								'rAdd'=>'../Mrt/r',
								'oAdd'=>'../Mrt/o',
								'clAdd'=>'../Mrt/CL',
								'topBtn'=>true,
								'mrtMeun'=>[
										['Addr'=>'../Mrt/r','lineName'=>'紅線捷運',],
										['Addr'=>'../Mrt/o','lineName'=>'橘線捷運',],
										['Addr'=>'../Mrt/CL','lineName'=>'環狀輕軌',],
								],
								'mAdd'=>'../Mrt/formosa',
								'dColor'=>$this->dColor,
								'bColor'=>$this->bColor,
								'borColor'=>$this->borColor,
								'titleImg'=>"{{ URL::asset('resources/img/tkoMRT.png') }}",
			]);
	}
	
	public function getLRTTime($ID, $type){
		#----------------------------
		#變數初始化
		#----------------------------
		
		//OData ID&Key
		//L1
		$appId = '5631949d5d2e45279ea8124254e8780a';
		$appKey = 'Jd3jTb7fltKz4skNHFrF1kFz16k';
		//L2
		// $appId = 'd9c2907546174d2c9fe8e0582f60c9e7';
		// $appKey = 'hlQwPHu0JGqAP9GGOFSpqS589s4';
		
		
		//連接網址
		$url = 'https://ptx.transportdata.tw/MOTC/v2/Rail/Metro/LiveBoard/KLRT?$filter=StationID%20eq%20%27'.$ID.'%27&$top=30&$format=JSON';
		
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
		#print_r($ch);
		#echo $httpCode;

		if($httpCode==200){
			$LRTTime = json_decode(json_encode(json_decode($result)), true);
			#print_r($LRTTime);
			#echo '<br><br>';
			$Station = null;
			$toGo = null;
			$toBack = null;
			$reD = array();
			if(empty($LRTTime)){
				$reD['type'] = 'err';
				$reD['typeTxt'] = '權限不足.';
				echo json_encode($reD);
			}
			else{
				if(!empty($LRTTime[0])||!empty($LRTTime[1])){
					$reD['type'] = 200;
					$reD['typeTxt'] = '';
				}
				if(!empty($LRTTime[0])){
					$reD['Station'] = $LRTTime[0]['StationName']['Zh_tw'];
					// $reD['toGo'] = $LRTTime[0]['TripHeadSign'];
					$reD['toGo'] = '往 '.$LRTTime[0]['DestinationStationName']['Zh_tw'];
					$reD['GoTime'] = null;

					$Station = $LRTTime[0]['StationName']['Zh_tw'];
					$Station .= '<br>';
					$Go = $LRTTime[0]['DestinationStationName']['Zh_tw'];
					if($LRTTime[0]['EstimateTime']==-1){
						$GoTime = '末班車駛離.';
						$reD['GoTime'] = '末班車駛離.';
					}
					else if((int)$LRTTime[0]['EstimateTime']==0){
						$GoTime = '進站中.';
						$reD['GoTime'] = '進站中.';
					}
					// else if(!is_int($LRTTime[0]['EstimateTime'])||$LRTTime[0]['EstimateTime']==null||$LRTTime[0]['EstimateTime']==''){
					// 	$GoTime = '---';
					// 	$reD['GoTime'] = '---';
					// }
					else if((int)$LRTTime[0]['EstimateTime']<3){
						$GoTime = '即將進站.';
						$reD['GoTime'] = '即將進站.';
					}
					else{
						$GoTime = $LRTTime[0]['EstimateTime'].'分.';
						$reD['GoTime'] = $LRTTime[0]['EstimateTime'].'分.';
					}
					$toGo = '往'.$Go.':'.$GoTime.'<br>';
				}
				else{
					$reD['Station'] = '';
					$reD['toGo'] = '';
					$reD['GoTime'] = '';
				}
				if(!empty($LRTTime[1])){
					$reD['Station'] = $LRTTime[1]['StationName']['Zh_tw'];
					// $reD['toBack'] = $LRTTime[1]['TripHeadSign'];
					$reD['toBack'] = '往 '.$LRTTime[1]['DestinationStationName']['Zh_tw'];
					$reD['BackTime'] = null;

					$Station = $LRTTime[1]['StationName']['Zh_tw'];
					$Station .= '<br>';
					$Back = $LRTTime[1]['DestinationStationName']['Zh_tw'];
					$BackTime = $LRTTime[1]['EstimateTime'];
					if($LRTTime[1]['EstimateTime']==-1){
						$GoTime = '末班車駛離.';
						$reD['BackTime'] = '末班車駛離.';
					}
					if((int)$LRTTime[1]['EstimateTime']==0){
						$GoTime = '進站中.';
						$reD['BackTime'] = '進站中.';
					}
					// else if(!is_int($LRTTime[1]['EstimateTime'])||$LRTTime[1]['EstimateTime']==null||$LRTTime[1]['EstimateTime']==''){
					// 	$GoTime = '---';
					// 	$reD['BackTime'] = '末班車已駛離.';
					// }
					else if((int)$LRTTime[1]['EstimateTime']<3){
						$GoTime = '即將進站.';
						$reD['BackTime'] = '即將進站.';
					}
					else{
						$GoTime = $LRTTime[1]['EstimateTime'].'分.';
						$reD['BackTime'] = $LRTTime[1]['EstimateTime'].'分.';
					}
					$toBack = '往'.$Back.':'.$BackTime;
				}
				else{
					$reD['Station'] = '';
					$reD['toBack'] = '';
					$reD['BackTime'] = '';
				}
				echo json_encode($reD);
				// echo $Station.$toGo.$toBack;
			}
		}
		else{
			$reD['type'] = $httpCode;
			$reD['typeTxt'] = '伺服器異常.';
			echo json_encode($reD);
			// echo $httpCode.'伺服器異常';
		}
		
	}
	
}

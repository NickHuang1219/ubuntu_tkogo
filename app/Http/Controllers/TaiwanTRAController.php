<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

use App\Http\Controllers\traConinCurlController;

class TaiwanTRAController extends Controller
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
	
    public function TaiwanTRAindex()
	{
		return view('TaiwanTRA', [
								'mrt'=>$row=null,
								'lineClass'=>'請選擇 路線',
								'rAdd'=>'Mrt/r',
								'oAdd'=>'Mrt/o',
								'mAdd'=>'Mrt/formosa',
								'topBtn'=>false,
									'mrtMeun'=>[
											['Addr'=>'../Mrt/r','lineName'=>'紅線捷運',],
											['Addr'=>'../Mrt/o','lineName'=>'橘線捷運',],
									],
								'dColor'=>'',
								'bColor'=>'',
								'borColor'=>'',
								'titleImg'=>"{{ URL::asset('resources/img/tkoMRT.png') }}",
								'CountiesID'=>'',
								// 'Counties'=>$this->Counties(''),
								'Counties'=>null,
								'Trastationd'=>null,
		]);
	}
	public function Counties($id=''){	//縣市	
	    #----------------------------
	    #變數初始化
	    #----------------------------
		$countiesArr = array();
		$i = 0;
		$countiesDOM = '<option value="C">請 選 擇 縣 市</option>';
		
		$counties = $this->db->query("SELECT * FROM counties WHERE TRAop=1 ORDER BY id asc");
		//$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=100 AND ODMRT_Code<200');
		return$this->row=$counties->fetchAll();
		$countiesD = count($this->row);
	}
	public function Trastationd($id=''){	//站別	
	    #----------------------------
	    #變數初始化
	    #----------------------------
		$countiesArr = array();
		$i = 0;
		$countiesDOM = '<option value="C">請 選 擇 縣 市</option>';
		
		$counties = $this->db->query("SELECT * FROM trastationd WHERE CountiesID=".$id);
		
		if($id==''){
			$this->row=$counties->fetchAll();
			return json_encode($this->row);
		}
		else if($id!=''){
			return $this->row=$counties->fetchAll();
		}
		$countiesD = count($this->row);
	}


    public function TRAD($seleStr, $stationID, $seleID=''){
    	// \Log::info('00000: '.$seleStr.'--'.$stationID.'--'.$seleID='');
    	$traD = new traConinCurlController;
    	return $traD->TRALineD($seleStr, $stationID);
    }
	
    public function TaiwanTrastationd($id)
	{
		return view('TaiwanTRA', [
								'mrt'=>$row=null,
								'lineClass'=>'請選擇 路線',
								'rAdd'=>'Mrt/r',
								'oAdd'=>'Mrt/o',
								'mAdd'=>'Mrt/formosa',
								'topBtn'=>false,
									'mrtMeun'=>[
											['Addr'=>'../Mrt/r','lineName'=>'紅線捷運',],
											['Addr'=>'../Mrt/o','lineName'=>'橘線捷運',],
									],
								'dColor'=>'',
								'bColor'=>'',
								'borColor'=>'',
								'titleImg'=>"{{ URL::asset('resources/img/tkoMRT.png') }}",
								'CountiesID'=>$id,
								'Counties'=>$this->Counties(''),
								'Trastationd'=>$this->Trastationd($id),
		]);
	}
	
	
	public function TTRALineD($seleStr='', $stationID='', $str){
		if($stationID==''){
			echo '404.1';
		}
		else if($stationID==''){
			echo '404.3';
		}
		else if($this->seleStationID($stationID)=='1'){
			if($seleStr=='stationNow'){
				//echo 'stationNow';
				$url = 'https://ptx.transportdata.tw/MOTC/v3/Rail/TRA/StationLiveBoard/Station/'.$stationID.'?$top=30&$format=JSON';
				echo $this->TTRAD($seleStr, $url, $stationID);
			}
			else if($seleStr=='stationToday'){
				//echo 'stationToday';
				$url = 'https://ptx.transportdata.tw/MOTC/v3/Rail/TRA/DailyStationTimetable/Today/Station/'.$stationID.'?$top=30&$format=JSON';
				echo $this->TTRAD($seleStr, $url, $stationID);
			}
			else{
				echo '404.2';
			}
		}
		else{
				echo '404.4';
		}
	}
	public function seleStationID($id){
		if($id=='1'){
			return '0';
		}
		else{
			return '1';
		}
	}
    public function TTRAD($seleStr, $url, $stationID, $seleID=''){
        #----------------------------
        #變數初始化
        #----------------------------
        $cityBike = array();
        $i = 0;
        
        //OData ID&Key
        //L1
        $appId = '5631949d5d2e45279ea8124254e8780a';
        $appKey = 'Jd3jTb7fltKz4skNHFrF1kFz16k';
        //L2
        // $appId = 'd9c2907546174d2c9fe8e0582f60c9e7';
        // $appKey = 'hlQwPHu0JGqAP9GGOFSpqS589s4';
        
		
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
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        
        $result=curl_exec($ch);
        $httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
		
		if($seleStr=='stationNow'){
			return $this->stationLineNow($result);
		}
		else if($seleStr=='stationToday'){
			return $this->stationTodayData($result);
		}
		else{
			return '404.0';
		}
    }
	private function stationLineNow($result){
		#-------------------------------------
		#變數宣告
		#-------------------------------------
		$retD = array();
		$stationNow = array();
		$DN = array();
		$ii = 0;
		
		$TRAD1 = json_decode($result);
		$lineNow = $TRAD1->StationLiveBoards;
	
		if(count($lineNow)>=1){
			$url = 'https://ptx.transportdata.tw/MOTC/v3/Rail/TRA/DailyStationTimetable/Today/Station/4400?$top=30&$format=JSON';
			$retD['type'] = 'success';
			
			for($RDi=0; $RDi<count($lineNow); $RDi++){
				// $lineNow[$RDi]->TrainNo; //車次代碼
				// $lineNow[$RDi]->TrainTypeID; //車種代碼
				// $lineNow[$RDi]->TrainTypeCode; //車種簡碼
					// 車種簡碼 = ['1: 太魯閣', '2: 普悠瑪', '3: 自強', '4: 莒光', 
					//             '5: 復興', '6: 區間', '7: 普快', '10: 區間快']
				// $lineNow[$RDi]->TrainTypeName->Zh_tw; //車種名稱 中文
				// $lineNow[$RDi]->TrainTypeName->En; //車種名稱 英文
				// $lineNow[$RDi]->StationID; //車站代碼
				// $lineNow[$RDi]->StationName->Zh_tw; //車站名稱 中文
				// $lineNow[$RDi]->StationName->En; //車站名稱 英文
				// $lineNow[$RDi]->RunningStatus; //列車狀態 0準點 1誤點 2取消
				// $lineNow[$RDi]->DelayTime; //進站 延誤時間
				// $lineNow[$RDi]->UpdateTime; //資料更新時間
				

				//echo '開往: '.$this->stationToday($todayLineD, 'aLineD', $lineNow[$RDi]->TrainNo)."<br>";
				//echo '開往: '.$lineNow[$RDi]->EndingStationName->Zh_tw."<br>";
				//echo '&nbsp;&nbsp;&nbsp;車次代碼: '.$lineNow[$RDi]->TrainNo."<br>";
				//echo '&nbsp;&nbsp;&nbsp;車種代碼: '.$lineNow[$RDi]->TrainTypeID."<br>";
				//echo '&nbsp;&nbsp;&nbsp;車種簡碼: '.$lineNow[$RDi]->TrainTypeCode."<br>";
				//echo '&nbsp;&nbsp;&nbsp;車種名稱: '.$lineNow[$RDi]->TrainTypeName->Zh_tw."<br>";
				// echo '&nbsp;&nbsp;&nbsp;: '.$lineNow[$RDi]->TrainTypeName->En."<br>";
				//echo '&nbsp;&nbsp;&nbsp;車站代碼: '.$lineNow[$RDi]->StationID."<br>";
				//echo '&nbsp;&nbsp;&nbsp;車站名稱: '.$lineNow[$RDi]->StationName->Zh_tw."<br>";
				// echo '&nbsp;&nbsp;&nbsp;: '.$lineNow[$RDi]->StationName->En."<br>";
				$stationNow[$RDi]['GO'] = $lineNow[$RDi]->EndingStationName->Zh_tw;
				$stationNow[$RDi]['TrainNo'] = $lineNow[$RDi]->TrainNo;
				$stationNow[$RDi]['TrainTypeNameTW'] = $lineNow[$RDi]->TrainTypeName->Zh_tw;
				//$stationNow[$RDi][] = 
				if($lineNow[$RDi]->TripLine==0){
					//echo '&nbsp;&nbsp;&nbsp;列車線路: 不經山海線'."<br>";
					$stationNow[$RDi]['TripLine'] = '不經山海線';
				}
				else if($lineNow[$RDi]->TripLine==1){
					//echo '&nbsp;&nbsp;&nbsp;列車線路: 山線'."<br>";
					$stationNow[$RDi]['TripLine'] = '山線';
				}
				else if($lineNow[$RDi]->TripLine==2){
					//echo '&nbsp;&nbsp;&nbsp;列車線路: 海線'."<br>";
					$stationNow[$RDi]['TripLine'] = '海線';
				}
				else if($lineNow[$RDi]->TripLine==3){
					//echo '&nbsp;&nbsp;&nbsp;列車線路: 追成線'."<br>";
					$stationNow[$RDi]['TripLine'] = '追成線';
				}
				
				if($lineNow[$RDi]->RunningStatus==0){
					//echo '&nbsp;&nbsp;&nbsp;列車狀態: 準點'."<br>";
					$stationNow[$RDi]['RunningStatus'] = '準點.';
					$stationNow[$RDi]['color'] = '#04bf04';
				}
				else if($lineNow[$RDi]->RunningStatus==1){
					//echo '&nbsp;&nbsp;&nbsp;列車狀態: 誤點'."<br>";
					$stationNow[$RDi]['RunningStatus'] = '誤點';
					$stationNow[$RDi]['color'] = '#f00';
				}
				else if($lineNow[$RDi]->RunningStatus==2){
					//echo '&nbsp;&nbsp;&nbsp;列車狀態: 取消'."<br>";
					$stationNow[$RDi]['RunningStatus'] = '取消.';
					$stationNow[$RDi]['color'] = '#000';
				}
				else{
					//echo '&nbsp;&nbsp;&nbsp;列車狀態: 取消'."<br>";
					$stationNow[$RDi]['RunningStatus'] = '---';
				}
				
				if($lineNow[$RDi]->DelayTime==0){
					//echo '&nbsp;&nbsp;&nbsp;進站 延誤時間: ---'."<br>";
					$stationNow[$RDi]['DelayTime'] = '---';
				}
				else if($lineNow[$RDi]->DelayTime>0){
					//echo '&nbsp;&nbsp;&nbsp;進站 延誤時間: '.$lineNow[$RDi]->DelayTime."分鐘<br>";
					$stationNow[$RDi]['DelayTime'] = $lineNow[$RDi]->DelayTime."分.";
				}
				else{
					//echo '&nbsp;&nbsp;&nbsp;進站 延誤時間: ---'."<br>";
					$stationNow[$RDi]['DelayTime'] = '---';
				}
				//echo '&nbsp;&nbsp;&nbsp;資料更新時間: '.$lineNow[$RDi]->UpdateTime."<br>";
				//行駛方向 : [0:'順行(北上)',1:'逆行(南下)'] ,
			}
			$retD['stationNow']=$stationNow;
			$retD['DN'] = '';
			$retD['DS'] = '';
			return json_encode($retD);
		}
		else{
			$retD['type'] = 'err';
			$retD['errT'] = '目前沒有列車進站.';
			echo json_encode($retD);//.'無資料顯示';
		}
	}
	private function stationTodayData($result, $seleStr='', $seleID=''){
		#-------------------------------------
		#變數宣告
		#-------------------------------------
		$retD = array();
		$DS = array();
		$DN = array();
		$ii = 0;
		$ji = 0;
		
        $TRAD1 = json_decode($result);
        $TRAD11 = $TRAD1->StationTimetables;
        
		date_default_timezone_set('Asia/Taipei');
		$timeD = strtotime(date('Y-m-d H:i:s+08:00'));
		if($TRAD1==''&&($seleStr==''&&$seleID=='')){
			$retD['err'] = 'err'; 
			$retD['errT'] = '無此站台列車停靠資訊.';
			echo json_encode($retD);//.'無資料顯示';
		}
        else if($TRAD11!=''){
			for($RDi=0; $RDi<count($TRAD11); $RDi++){
				//echo $TRAD11[$RDi]->Direction; //行駛方向 : [0:'順行(北上)',1:'逆行(南下)'] ,
				for($c=0;$c<count($TRAD11[$RDi]->TimeTables);$c++){
					$trainTime = strtotime(date($TRAD11[$RDi]->TimeTables[$c]->ArrivalTime));
					// $TRAD11[$RDi]->TimeTables[$c]->TrainTypeCode; //車種簡碼
					// 車種簡碼 = ['1: 太魯閣', '2: 普悠瑪', '3: 自強', '4: 莒光', 
					//             '5: 復興', '6: 區間', '7: 普快', '10: 區間快']
		
					// $TRAD11[$RDi]->TimeTables[$c]->TrainNo; //車次代碼
					// $TRAD11[$RDi]->TimeTables[$c]->TrainTypeID; //車中代碼
					// $TRAD11[$RDi]->TimeTables[$c]->TrainTypeName->Zh_tw; //車種中文
					// $TRAD11[$RDi]->TimeTables[$c]->TrainTypeName->En; //車種英文
					// $TRAD11[$RDi]->TimeTables[$c]->DestinationStationID; //目的站車站代號// $TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->Zh_tw; //目的地中文
					// $TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->En; //目的地英文
					// $TRAD11[$RDi]->TimeTables[$c]->ArrivalTime; //到站時刻
					// $TRAD11[$RDi]->TimeTables[$c]->DepartureTime; // 出發時刻
					
					if($TRAD11[$RDi]->Direction==0 || $TRAD11[$RDi]->Direction=='0'){
						if((($timeD-$trainTime)<1800)||($timeD<$trainTime)){
							$DN[$ii]['TrainNo'] = $TRAD11[$RDi]->TimeTables[$c]->TrainNo;
							$DN[$ii]['TrainTypeID'] = $TRAD11[$RDi]->TimeTables[$c]->TrainTypeID;
							$DN[$ii]['TrainTypeNameTW'] = $TRAD11[$RDi]->TimeTables[$c]->TrainTypeName->Zh_tw;
							//$DN[$ii]['TrainTypeNameEN'] = $TRAD11[$RDi]->TimeTables[$c]->TrainTypeName->En;
							$DN[$ii]['DestinationStationNameTW'] = $TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->Zh_tw;
							//$DN[$ii]['DestinationStationNameEN'] = $TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->En;
							$DN[$ii]['ArrivalTime'] = $TRAD11[$RDi]->TimeTables[$c]->ArrivalTime;
							$DN[$ii]['DepartureTime'] = $TRAD11[$RDi]->TimeTables[$c]->DepartureTime;
							#$DN[$ii][''] = ;
							$ii++;
						}
					}
					else if($TRAD11[$RDi]->Direction==1 || $TRAD11[$RDi]->Direction=='1'){
						if((($timeD-$trainTime)<1800)||($timeD<$trainTime)){
							$DS[$ji]['TrainNo'] = $TRAD11[$RDi]->TimeTables[$c]->TrainNo;
							$DS[$ji]['TrainTypeID'] = $TRAD11[$RDi]->TimeTables[$c]->TrainTypeID;
							$DS[$ji]['TrainTypeNameTW'] = $TRAD11[$RDi]->TimeTables[$c]->TrainTypeName->Zh_tw;
							//$DS[$ji]['TrainTypeNameEN'] = $TRAD11[$RDi]->TimeTables[$c]->TrainTypeName->En;
							$DS[$ji]['DestinationStationNameTW'] = $TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->Zh_tw;
							//$DS[$ji]['DestinationStationNameEN'] = $TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->En;
							$DS[$ji]['ArrivalTime'] = $TRAD11[$RDi]->TimeTables[$c]->ArrivalTime;
							$DS[$ji]['DepartureTime'] = $TRAD11[$RDi]->TimeTables[$c]->DepartureTime;
							#$DS[$ji][''] = ;
							$ji++;
						}
					}
					//}
					/*
					if((($timeD-$trainTime)<1800)||($timeD<$trainTime)){
					// echo $TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->Zh_tw;
					echo "車次代碼: ".$TRAD11[$RDi]->TimeTables[$c]->TrainNo;
					echo '&nbsp;&nbsp;&nbsp;--車種代碼: '.$TRAD11[$RDi]->TimeTables[$c]->TrainTypeID; 
					echo '&nbsp;&nbsp;&nbsp;--車種: '.$TRAD11[$RDi]->TimeTables[$c]->TrainTypeName->Zh_tw; //車種中文
					// echo $TRAD11[$RDi]->TimeTables[$c]->TrainTypeName->En; //車種英文
					echo '&nbsp;&nbsp;&nbsp;--開往: '.$TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->Zh_tw; //目的地中文
					// echo $TRAD11[$RDi]->TimeTables[$c]->DestinationStationName->En; //目的地英文
					echo '&nbsp;&nbsp;&nbsp;--到達本站: '.$TRAD11[$RDi]->TimeTables[$c]->ArrivalTime; //到站時刻
					echo '&nbsp;&nbsp;&nbsp;--出發時刻: '.$TRAD11[$RDi]->TimeTables[$c]->DepartureTime."<br><br>"; // 出發時刻
					//echo json_encode($TRAD11[$RDi]->TimeTables[$c])."<br><br>";
					
					}
					*/
				}
			}
			$retD['stationNow'] = '';
			$retD['DN'] = $DN;
			$retD['DS'] = $DS;
			$retD['type'] = 'success';
			return json_encode($retD);
		}
	}

	public function MrtLine($id){
		$lineD = array();
		$i = 0;
		if($id=='r'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=100 AND ODMRT_Code<200');
			$this->row=$line->fetchAll();
			$this->dColor='#f8d7da';
			$this->bColor='#dc3545';
			$this->borColor='#dc3545';
			$this->lineClass='目前: 紅線捷運路線';
		}
		else if($id=='o'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=200 AND ODMRT_Code<250');
			$this->row=$line->fetchAll();
			$this->dColor='#ffeeba';
			$this->bColor='#ffc107';
			$this->borColor='#ffc107';
			$this->lineClass='目前: 橘線捷運路線';
		}
		else if(id=='formosa'){
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
									'lineClass'=>$this->lineClass,
									'rAdd'=>'../Mrt/r',
									'oAdd'=>'../Mrt/o',
									'topBtn'=>true,
									'mrtMeun'=>[
											['Addr'=>'../Mrt/r','lineName'=>'紅線捷運',],
											['Addr'=>'../Mrt/o','lineName'=>'橘線捷運',],
									],
									'mAdd'=>'../Mrt/formosa',
									'dColor'=>$this->dColor,
									'bColor'=>$this->bColor,
									'borColor'=>$this->borColor,
									'titleImg'=>"{{ URL::asset('resources/img/tkoMRT.png') }}",
			]);//compact('h3'));,  $data
		// foreach ($row as $row) {
		// 	echo $row['ODMRT_Name']." - ".$row['ODMRT_CName'];
		// }
		// foreach ($row as $v) {
		// 	$lineD[$i]['name'] = $v->ODMRT_Name;
		// 	$lineD[$i]['Cname'] = $v->ODMRT_CName;
		// 	$i++;
		// }
		// print_r($row);
	}
}

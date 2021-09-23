<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

use App\Http\Controllers\seleBusDataController;

use App\Http\Controllers\busConinCurlController;

class TkoBusLineController extends Controller
{
    public function index()
	{
		return '私は髙雄がすきです';
	}

	public function __construct()
    {
		// $this->users = $users;
		$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
	}
	
    public function Busindex()
	{
		$data = ['h'=>'私は髙雄がすきです'];
		$h = '私は髙雄がすきです';
		$busMeun = array();
		$busMeun[0]=['Addr'=>'123'];
		return view('TKOBus',[
								'busClass'=>'請選分類',
								'topBtn'=>false,
								'bus'=>null,
								'busMeun'=>[
											['Addr'=>'./Bus/g','lineName'=>'一般公車',],
											['Addr'=>'/Bus/r','lineName'=>'紅線公車',],
											['Addr'=>'/Bus/o','lineName'=>'橘線公車',],
											['Addr'=>'/Bus/y','lineName'=>'黃線公車',],
											['Addr'=>'/Bus/gr','lineName'=>'綠線公車',],
											['Addr'=>'/Bus/m','lineName'=>'幹線公車',],
											['Addr'=>'/Bus/f','lineName'=>'快線公車',],
											['Addr'=>'/Bus/h','lineName'=>'公路客運',],
											['Addr'=>'/Bus/e','lineName'=>'其他公車',],
								],
		]);
	}
	
    public function BusLine($id)
	{
		$seleBus = new seleBusDataController;
		return view('TKOBus',[
								'busClass'=>$this->menuIf($id),
								'topBtn'=>true,
								'bus'=>$seleBus->BusLineD($id, ''),
								'busMeun'=>[
											['Addr'=>'/Bus/g','lineName'=>'一般公車',],
											['Addr'=>'/Bus/r','lineName'=>'紅線公車',],
											['Addr'=>'/Bus/o','lineName'=>'橘線公車',],
											['Addr'=>'/Bus/y','lineName'=>'黃線公車',],
											['Addr'=>'/Bus/gr','lineName'=>'綠線公車',],
											['Addr'=>'/Bus/m','lineName'=>'幹線公車',],
											['Addr'=>'/Bus/f','lineName'=>'快線公車',],
											['Addr'=>'/Bus/h','lineName'=>'公路客運',],
											['Addr'=>'/Bus/e','lineName'=>'其他公車',],
								],
		]);
	}
	private function BusLineD($id){
		#-------------------------
		#變數初始化
		#-------------------------
		if($id=='e'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='E' ORDER BY busline_data.nameZh ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='gr'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='Gre' ORDER BY busline_data.seRounts ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='m'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_data.nameZh like '%幹線%' ORDER BY busline_data.nameZh ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='g'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='o'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='r'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='y'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='h'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='f'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.nameZh ASC");
			return $this->row=$line->fetchAll();
		}
		else{
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			return $this->row=$line->fetchAll();
		}
		#else if($id!='gre' AND $id!='e'){
			#$line = $this->db->query('SELECT  busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID where busline_idop.BClass="'.strtoupper($id).'" AND busline_idop.BusLineEnable=1 ORDER BY busline_data.seRounts ASC');
			#return $this->row=$line->fetchAll();
		#}
	}
	public function BusConinTimes($id){
		#echo "<br><br><br><br><br>　";
		$data = $this->seLineD($id);//json_decode();
		#print_r($data[0]['nameZh']);
		return view('TKOBusCon',[
								'topBtn'=>true,
								'lineName'=>'----',//$data[0]->nameZh,
								'toGo'=>'++++',//$data[0]->departureZh,
								'toBack'=>'***',//$data[0]->destinationZh,
		]);
	}
	public function reGetBusTime($id, $type){
		$bus = new busConinCurlController;
		$connTime = $bus->ConinTime($id, $type);
		// \Log::info('BusConnin-'.$connTime->type);
		$data = $this->seLineD($id);
		if($data==null){
			$data['code']='-1';
			return json_encode($data);
		}
		else{
			if($type=='P'){
				// $busConT = $this->gobustime($id);
				// $bdata[1]=$busConT[1];
				// $bdata[2]=$busConT[2];
				$bdata['conn'] = $connTime;
				return json_encode($bdata);
			}
		}
	}
	
	public function BusConinTime($id){
		$busConn = new busConinCurlController;
		$data = $this->seLineD($id);//json_decode();
		if($data==null){
			return view('TKOBusCon',[
									'topBtn'=>true,
									'lineName'=>'路線已停駛...',
									'lineId'=>'',
									'goName'=>'',
									'backName'=>'',
									'togo'=>null,
									'toback'=>null,
									'err'=>true,
			]);
		}
		else{
			$busConT = $this->gobustime($id);
			return view('TKOBusCon',[
									'topBtn'=>true,
									'lineName'=>$data[0]['nameZh'],
									'lineId'=>$data[0]['ID'],
									'goName'=>$data[0]['departureZh'],
									'backName'=>$data[0]['destinationZh'],
									'togo'=>$busConT[1],
									'toback'=>$busConT[2],
									'err'=>false,
			]);
		}
		#echo "<br><br><br><br>　";
		#print_r($data[0]);
		#if($data[0]->BusLineEnable==1){
		#}
		#else{
		#	return '+++';
		#}
	}
	
	public function BConTime($id){
		$data = $this->seLineD($id);//json_decode();
		if($data==null){
			echo 'yes';
			return view('TKOBusCon',[
									'topBtn'=>false,
									'lineName'=>'路線已停駛...',//$data[0]['nameZh'],
									'lineId'=>'',
									'goName'=>'',//$data[0]['departureZh'],
									'backName'=>'',//$data[0]['destinationZh'],
									'togo'=>null,//$busConT[1],
									'toback'=>null,//$busConT[2],
									'err'=>true,
			]);
		}
		else{
			$busConT = $this->gobustime($id);
			#print_r($data);
			return view('TKOBusCon',[
									'topBtn'=>true,
									'lineName'=>$data[0]['nameZh'],
									'lineId'=>$data[0]['ID'],
									'goName'=>$data[0]['departureZh'],
									'backName'=>$data[0]['destinationZh'],
									'togo'=>$busConT[1],
									'toback'=>$busConT[2],
									'err'=>false,
			]);
		}
		#echo '<br><br>1: ';
		#print_r($busConT[1]);
		#echo '<br><br>2: ';
		#print_r($busConT[2]);
		#echo "<br><br><br><br>　";
		#print_r($data[0]);
		#if($data[0]->BusLineEnable==1){
	}
	/**/
	public function seLineD($id)
	{
		$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.ID='".$id."'");
		return $line->fetchAll();//json_encode();
	}
	/**/
	public function gobustime($id)
	{
		#---------------------
		#變數初始化
		#---------------------
		$ToGo = array();
		$ToBack = array();
		$lineCon = array();
		$coninCar = 0;
		$ToGoN = 0;
		$ToBackN = 0;
		$VToGo = '';
		$VToBack = '';
		$craIdIf = '';
				
		//CURL開始
		$ch = curl_init();
		$url = "ibus.tbkc.gov.tw/xmlbus/GetEstimateTime.xml?routeIds=".$id;
		
		//curl_setopt可以設定curl參數
		//設定url
		curl_setopt($ch , CURLOPT_URL , $url);
			
		//獲取結果不顯示
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
		curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");//執行，並將結果存回
		$BusLine = curl_exec($ch);
		$BusLineN = explode('<EstimateTime', $BusLine);
		$pre1 = preg_match('/GoBack="1"/i',$BusLine);
		$pre2 = preg_match('/GoBack="2"/i',$BusLine);
		
		if($pre1!=1&&$pre2!=1){
			$busConT[1]=null;
			$busConT[2]=null;
		}
		else{
			for($i=1; $i<count(json_decode(json_encode($BusLineN))); $i++){
				$StopNameS = explode('StopName="', $BusLineN[$i]);
				$StopNameStr = explode('" ', $StopNameS[1]);
				$StopName = $StopNameStr[0];
				
				$GoBackS = explode('GoBack="', $StopNameStr[1]);
				$GoBackStr = explode('" ', $GoBackS[1]);
				$GoBack = $GoBackStr[0];
				
				$ValueS = explode('Value="', $BusLineN[$i]);
				$ValueStr = explode('" ', $ValueS[1]);
				$Value = $ValueStr[0];
					
				$comeTimeS = explode('comeTime="', $BusLineN[$i]);
				$comeTimeStr = explode('" ', $comeTimeS[1]);
				$comeTime = $comeTimeStr[0];
					
				$carIdS = explode('carId="', $BusLineN[$i]);
				$carIdStr = explode('" ', $carIdS[1]);
				$carId = $carIdStr[0];
					
					
				$comeCaridS = explode('comeCarid="', $BusLineN[$i]);
				$comeCaridStr = explode('" ', $comeCaridS[1]);
				$comeCarid = $comeCaridStr[0];
				$coninT = $this->coninTimeIf($Value, $comeTime);
				if($coninT=='進站中.'){
					$BcarId = $this->carId($carId, $comeCarid);
					$craIdIf = $BcarId;
					$coninCar = 1;
				}
				else if($coninT=='末班車已離'){
					$BcarId = '';
					$coninT = '末班車已離';
				}
				else if($coninT=='1分鐘.'){
					$BcarId = '即將進站.';
				}
				else{
					$BcarId = '';
				}
				if($GoBack==1||$GoBack=='1'){
					$Togo[$ToGoN]['StopName'] = $StopName;
					$Togo[$ToGoN]['carId'] = $BcarId;
					$Togo[$ToGoN]['coninT'] = $coninT;
					$ToGoN++;
				}
				else if($GoBack==2||$GoBack=='2'){
					$ToBack[$ToBackN]['StopName'] = $StopName;
					$ToBack[$ToBackN]['carId'] = $BcarId;
					$ToBack[$ToBackN]['coninT'] = $coninT;
					$ToBackN++;
				}
			}
			if($pre1==1){
				$busConT[1]=$Togo;
			}
			else{
				$busConT[1]=null;
			}
			if($pre2==1){
				$busConT[2]=$ToBack;
			}
			else{
				$busConT[2]=null;
			}
		}
		return $busConT;
	}
	public function carId($carId, $comeCarid){
		if($carId!=''||$carId!=null||$carId!="null"){
			return $carId;
		}
		else if($comeCarid!=''||$comeCarid!=null||$comeCarid!="null"){
			return $comeCarid;
		}
		else{
			return '';
		}
	}
	public function coninTimeIf($Value, $comeTime){
		if(($Value=='null'||$Value=='')&&($comeTime=='null'||$comeTime=='')){
			return '';
		}
		else if((string)$Value=='-3'){
			return '末班車已離';
		}
		else if((string)$comeTime=='-3'){
			return '末班車已離';
		}
		else if($Value=='null'){
			if(count(explode(":",$comeTime))==2){
				return $comeTime;
			}
			else{
				if((string)$comeTime=='0'){
					return '進站中.';
				}
				else{
					return $comeTime.'分鐘.';
				}
			}
		}
		else if($Value!='null'){
			if(count(explode(":",$Value))==2){
				return $Value;
			}
			else{
				if((string)$Value=='0'){
					return '進站中.';
				}
				else{
					return $Value.'分鐘.';
				}
			}
		}
		else{
			return '';
		}
	}

	
	public function menuIf($id){
		if($id=='g'){
			return '一般公車';
		}
		else if($id=='r'){
			return '紅線公車';
		}
		else if($id=='o'){
			return '橘線公車';
		}
		else if($id=='y'){
			return '黃線公車';
		}
		else if($id=='gr'){
			return '綠線公車';
		}
		else if($id=='m'){
			return '幹線公車';
		}
		else if($id=='f'){
			return '快線公車';
		}
		else if($id=='h'){
			return '公路客運';
		}
		else if($id=='e'){
			return '其他公車';
		}
		else{
			return '----';
		}
	}
	
	
	
	public function botMP(Request $text){
		#---------
		#變數宣告
		#---------
		$reD = array();
		return '123';
	}
	
	public function botU($uId, $uName, $uImgURL, $uTitleMessage){
		#---------
		#變數宣告
		#---------
		$reD = array();
		$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		$ud = $this->db->query('SELECT * FROM botUData WHERE uid="'.$uId.'"');
		#return $ud;
		if(empty($ud!='')){
			return 'yes';
		}
		else{
			return 'no';
		}
	}
	public function botM($retype,$text='',$uId='',$uName='',$uImgURL='',$uTitleMessage=''){
		#---------
		#變數宣告
		#---------
		$reD = array();
		#return '123';/**/
		#$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		if($retype=='txt'){
			$messages = $this->db->query('SELECT * FROM message WHERE u_text="'.$text.'"');
			$mess = $messages->fetch(PDO::FETCH_ASSOC);
			/*$reD->re_text = '';
			$reD->relationTable = '';
			$reD->relationTableID = '';
			$reD->reType = 'err';
			$reD->u_text = '';
			$reD->bImg = '';
			$reD->sImg = '';*/
			#echo "<br>";
			#print_r(empty($mess['u_text']));
			#print_r($mess);
			if(!empty($mess['u_text'])){
				/*
			$reD->re_text = $mess['re_text'];
			$reD->relationTable = $mess['relationTable'];
			$reD->relationTableID = $mess['relationTableID'];
			$reD->reType = $mess['reType'];
			$reD->u_text = $mess['u_text'];
			$reD->bImg = $mess['bImg'];
			$reD->sImg = $mess['sImg'];
			*/
				/**/
				$reD['re_text'] = $mess['re_text'];
				$reD['reType'] = $mess['reType'];
				$reD['u_text'] = $mess['u_text'];
				$reD['bImg'] = $mess['bImg'];
				$reD['sImg'] = $mess['sImg'];
				
				return json_encode($reD);//gettype()
			}
			else{
				/**/
				$reD['re_text'] = '';
				$reD['reType'] = 'err';
				$reD['u_text'] = '';
				$reD['bImg'] = '';
				$reD['sImg'] = '';
				
				return json_encode($reD);
				#return 'err';
			}
		}
		else if($retype=='uds'){
			#return 3;
			$connection = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
			$ud = $connection->query('SELECT * FROM botUData WHERE uid="'.$uId.'"');
			#exec('INSERT INTO pdo VALUES ("","PJCHENder", 12345678)');
			$uds = $ud->fetch(PDO::FETCH_ASSOC);
			\Log::info('UD'.count($uds));
			if(!empty($uds['uid'])){//有
				#$sql = "UPDATE botUData SET uName=?, uImgURL=?, uTitleMessage=? WHERE uid=?";
				#$stmt= $this.db->prepare($sql);
				#$stmt->execute([$uName, $uImgURL, $uTitleMessage, $uid]);
				#$upd = $this->db->query('UPDATE botUData SET uName="'.$uName.'",uImgURL="'.$uImgURL.'",uTitleMessage="'$uTitleMessage.'" WHERE uid="'.$uid.'"');
				return 'updata ok.';
			}
			else{
				#$insertd = $this->db->query('INSERT INTO botUData(uid, uName, uImgURL, uTitleMessage) VALUES ("'.$uid.'","'.$uName.'","'.$uImgURL.'","'.$uTitleMessage.'"');
				return 'insert ok.';
			}
		}
		else{
			return '404';
		}
		
	}
	public function botUDSet($uId,$uName='',$uImgURL='',$uTitleMessage=''){
		return 'botUDSet';
	}
	
}

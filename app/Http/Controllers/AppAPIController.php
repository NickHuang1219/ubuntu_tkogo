<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TkoCityBikeController;
use App\Http\Controllers\TkoBusLineController;

use App\Http\Controllers\seleBusDataController;
use App\Http\Controllers\seleMrtDataController;
use App\Http\Controllers\seleBikeDataController;
use App\Http\Controllers\seleTraDataController;
use App\Http\Controllers\curlWeathersController;
// use App\Http\Controllers\seleBusDataController;

class AppAPIController extends Controller{
	
	public function AppDataV($Weather=''){
        $busD = new seleBusDataController;
        $mrtD = new seleMrtDataController;
		$bikeD = new seleBikeDataController;
		$traD = new seleTraDataController;
		$WeatherD = new curlWeathersController;
		
		$weather = '新興區';
		$dataV = array();
		$data = array();
		$LD = array();
		$mrt = array();
		$Area = array();
		$LD['bus'] = [
						$busD->BusLineD('g', 'mobile'), 
						$busD->BusLineD('r', 'mobile'),
						$busD->BusLineD('o', 'mobile'),
						$busD->BusLineD('y', 'mobile'),
						$busD->BusLineD('gre', 'mobile'),
						$busD->BusLineD('m', 'mobile'),
						$busD->BusLineD('f', 'mobile'),
						$busD->BusLineD('h', 'mobile'),
						$busD->BusLineD('e', 'mobile'),
		];
		$LD['mrt'] = [
						$mrtD->MrtLineD('r', 'mobile'),
						$mrtD->MrtLineD('o', 'mobile'),
						$mrtD->MrtLineD('CL', 'mobile')
		];
		$LD['bike'] = [
						$bikeD->BikeLineD('MRT', 'mobile'),
						$bikeD->BikeLineD('S', 'mobile'),
						$bikeD->BikeLineD('E', 'mobile'),
						$bikeD->BikeLineD('park', 'mobile'),
						$bikeD->BikeLineD('Attra', 'mobile'),
						$bikeD->BikeLineD('Commu', 'mobile'),
						$bikeD->BikeLineD('RSI', 'mobile'),
						$bikeD->BikeLineD('AdPol', 'mobile'),
						$bikeD->BikeLineD('stas', 'mobile'),
		];
		$LD['tra'] = [
						$traD->TraLineD(),
		];
		$dataV['lineData'] = $LD;
		$dataV['DV']['bus'] = ['GeBus', 'RBus', 'OBus', 'YBus', 'GBus', 
								'MBus', 'FBus', 'HBus', 'EBus'];
		$dataV['DV']['mrt'] = ['mrtRLine', 'mrtOLine', 'LRTLine'];
		$dataV['DV']['bike'] = ['BikeLineMRT', 'BikeLineS', 'BikeLineE', 
								'BikeLinePark', 'BikeLineAttra', 'BikeLineCommu', 
								'BikeLineRSI', 'BikeLineAdPol', 'BikeLineStas', ];
		$dataV['DV']['tra'] = ['TRAD'];
		// $LD = [
		// 	$busD->BusLineD('g', 'mobile'), 
		// 	$busD->BusLineD('r', 'mobile'),
		// 	$busD->BusLineD('o', 'mobile'),
		// 	$busD->BusLineD('y', 'mobile'),
		// 	$busD->BusLineD('gre', 'mobile'),
		// 	$busD->BusLineD('m', 'mobile'),
		// 	$busD->BusLineD('f', 'mobile'),
		// 	$busD->BusLineD('h', 'mobile'),
		// 	$busD->BusLineD('e', 'mobile'),
		// 	$mrtD->MrtLineD('r', 'mobile'),
		// 	$mrtD->MrtLineD('o', 'mobile'),
		// 	$bikeD->BikeLineD('MRT', 'mobile'),
		// 	$bikeD->BikeLineD('S', 'mobile'),
		// 	$bikeD->BikeLineD('E', 'mobile'),
		// 	$bikeD->BikeLineD('park', 'mobile'),
		// 	$bikeD->BikeLineD('Attra', 'mobile'),
		// 	$bikeD->BikeLineD('Commu', 'mobile'),
		// 	$bikeD->BikeLineD('RSI', 'mobile'),
		// 	$bikeD->BikeLineD('AdPol', 'mobile'),
		// 	$bikeD->BikeLineD('stas', 'mobile'),
		// 	$traD->TraLineD(),
		// 	$mrtD->MrtLineD('CL', 'mobile')
		// ];
		// $LD[21] = $this->SeleBusLineAll();//'BusLineAll',

		// $data['lineData'] = $LD;//$mrt.$bus;//$this->seMrtLine();
		// $dataV['LData'] = $data;
		// $dataV['DV'] = ['GeBus', 'RBus', 'OBus', 'YBus', 'GBus', 
		// 				'MBus', 'FBus', 'HBus', 'EBus' ,'mrtRLine', 
		// 				'mrtOLine', 'BikeLineMRT', 'BikeLineS', 'BikeLineE', 
		// 				'BikeLinePark', 'BikeLineAttra', 'BikeLineCommu', 
		// 				'BikeLineRSI', 'BikeLineAdPol', 'BikeLineStas', 
		// 				'TRAD', 'LRTLine'];//, 'BikeLineE', 'BikeLineS', 'BikeLineMRT', 'BikeLineArea'
		
		$dataV['now'] = '0.0.0';
		$dataV['new'] = $this->cheVer('sele');
		
		$listBus[0]['EL'] = 'GeBus';
		$listBus[0]['TL'] = '一般公車';
		$listBus[1]['EL'] = 'RBus';
		$listBus[1]['TL'] = '紅線公車';
		$listBus[2]['EL'] = 'OBus';
		$listBus[2]['TL'] = '橘線公車';
		$listBus[3]['EL'] = 'YBus';
		$listBus[3]['TL'] = '黃線工程';
		$listBus[4]['EL'] = 'GBus';
		$listBus[4]['TL'] = '綠線公車';
		$listBus[5]['EL'] = 'MBus';
		$listBus[5]['TL'] = '幹線公車';
		$listBus[6]['EL'] = 'FBus';
		$listBus[6]['TL'] = '快線公車';
		$listBus[7]['EL'] = 'HBus';
		$listBus[7]['TL'] = '公路客運';
		$listBus[8]['EL'] = 'EBus';
		$listBus[8]['TL'] = '其他公車';
		$dataText[0] = $listBus;
		
		$listMRT[0]['EL'] = 'mrtRLine';
		$listMRT[0]['TL'] = '紅線捷運';
		$listMRT[0]['VBg'] = '#FFC7C7';
		$listMRT[0]['btnBg'] = '#FF7979';
		$listMRT[0]['TColor'] = '#000';
		$listMRT[1]['EL'] = 'mrtOLine';
		$listMRT[1]['TL'] = '橘線捷運';
		$listMRT[1]['VBg'] = '#FFF6D4';
		$listMRT[1]['btnBg'] = '#FFBA33';
		$listMRT[1]['TColor'] = '#000';
		$listLRT[2]['EL'] = 'LRTLine';
		$listLRT[2]['TL'] = '高雄輕軌';
		$listMRT[2]['VBg'] = '#FFF6D4';
		$listMRT[2]['btnBg'] = '#FFBA33';
		$listMRT[2]['TColor'] = '#6400AD';
		$dataText[1] = $listMRT;
		
		$listBick[0]['EL'] = 'BikeLineMRT';
		$listBick[0]['TL'] = '輕軌捷運';
		$listBick[1]['EL'] = 'BikeLineStas';
		$listBick[1]['TL'] = '車站周邊';
		$listBick[2]['EL'] = 'BikeLineAttra';
		$listBick[2]['TL'] = '景點周邊';
		$listBick[3]['EL'] = 'BikeLineS';
		$listBick[3]['TL'] = '學校周邊';
		$listBick[4]['EL'] = 'BikeLineCommu';
		$listBick[4]['TL'] = '社區周邊';
		$listBick[5]['EL'] = 'BikeLinePark';
		$listBick[5]['TL'] = '公園周邊';
		$listBick[6]['EL'] = 'BikeLineRSI';
		$listBick[6]['TL'] = '路街巷口';
		$listBick[7]['EL'] = 'BikeLineAdPol';
		$listBick[7]['TL'] = '行政警消';
		$listBick[8]['EL'] = 'BikeLineE';
		$listBick[8]['TL'] = '其他地方';
		$dataText[2] = $listBick;
		
		$listTRA[0]['EL'] = 'TaiwanTRA';
		$listTRA[0]['TL'] = '台灣鐵路';
		$dataText[3] = $listTRA;
		
		$listLRT[0]['EL'] = 'LRT';
		$listLRT[0]['TL'] = '高雄輕軌';
		$dataText[4] = $listLRT;
		
		$dataV['listK'] = ['Bus', 'MRT', 'BikeLineList', 'TaiwanTRA', 'LRT'];
		$dataV['listV'] = $dataText;
		#$dataV['BBMT'] = ['Bus'=>$listBus, 'Bike'=>$listBick, 'MRT'=>$listMRT, 'TRA'=>$listTRA];
		/*$dataV['BBMT']['Bus'] = $listBus;
		$dataV['BBMT']['Bike'] = $listBick;
		$dataV['BBMT']['MRT'] = $listMRT;
		$dataV['BBMT']['TRA'] = $listTRA;*/
		$dataV['BBMT'][0]['v'] = $listBus;
		$dataV['BBMT'][0]['k'] = 'bus';
		$dataV['BBMT'][1]['v'] = $listBick;
		$dataV['BBMT'][1]['k'] = 'bike';
		$dataV['BBMT'][2]['v'] = $listMRT;
		$dataV['BBMT'][2]['k'] = 'mrt';
		$dataV['BBMT'][3]['v'] = $listTRA;
		$dataV['BBMT'][3]['k'] = 'tra';
		
		$dataV['Area'] = $traD->Area();
		if($Weather!=''){
			$dataV['WeatherOC'] = $Weather;
			$dataV['Weather'] = $WeatherD->Weathers($Weather, 'k900nh');
		}
		else if($Weather==''){
			$dataV['WeatherOC'] = '';
			$dataV['Weather'] = $WeatherD->Weathers('新興區', 'k900nh');
		}

		return json_encode($dataV);
	}

	public function cheVer($sele, $str=''){
		$WeatherD = new curlWeathersController;
		$dataV = array();
		$data = array();
		$data['AppV'] = '2.1.1';//1.2.3, 1.3.3
		$data['DataV'] = '2.3.6';//1.3.2
		$data['mrt'] = 'flex';
		$data['bus'] = 'flex';
		$data['bike'] = 'flex';
		$data['tra'] = 'flex';
		$data['lrt'] = 'flex';
		$data['sys'] = 5;
		#$data[2] = ['1.0'];
		#$data[3] = ['1.0'];
		#$data['Weather'] = $Weather;
		if($sele=='sele'){
			return $data;
		}
		else if($sele=='che'){
			// $WeatherD = new curlWeathersController;
			$data['Weather'] = $WeatherD->Weathers($str,'k900nh');
			return json_encode($data);
		}
		else{
			$data['Weather'] = '';
			$err['code']='401'; 
			$err['errT']='無權訪問';
			return json_encode($err);
		}/**/
		// $dataV[0] = $data;
		// if($sele=='sele'){
		// 	return $data;
		// }
		// else if($sele=='che'){
		// 	echo json_encode($data);
		// }
		// else{
		// 	$err['code']='401'; 
		// 	$err['errT']='無權訪問';
		// 	echo json_encode($err);
		// }
	}
}

?>
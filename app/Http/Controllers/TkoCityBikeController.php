<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

use App\Http\Controllers\bikeConinCurlController;

class TkoCityBikeController extends Controller
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

    public function CityBikeindex()
	{
		$data = ['h'=>'私は髙雄がすきです'];
		$h = '私は髙雄がすきです';
		return view('TKOCityBike',[
								'bikeClass'=>'請選分類',
								'topBtn'=>false,
								'bike'=>null,
								'bikeMeun'=>[
											['Addr'=>'/Bike/MRT','lineName'=>'輕軌捷運',],
											['Addr'=>'/Bike/stas','lineName'=>'車站周邊',],
											['Addr'=>'/Bike/Attra','lineName'=>'景點周邊',],
											['Addr'=>'/Bike/S','lineName'=>'學校周邊',],
											['Addr'=>'/Bike/Commu','lineName'=>'社區周邊',],
											['Addr'=>'/Bike/RSI','lineName'=>'路街巷口',],
												['Addr'=>'/Bike/park','lineName'=>'公園周邊',],
											['Addr'=>'/Bike/AdPol','lineName'=>'行政警消',],
											['Addr'=>'/Bike/E','lineName'=>'其他地方',],
								],
		]);
	}
	
	public function CityBikeLine($id, $type='')
	{
		#-------------------------
		#變數初始化
		#-------------------------
		if($id=='MRT'){
			$line = $this->db->query('SELECT * FROM bikedata where class="M" AND Enable=1');
			$this->row=$line->fetchAll();
		}
		else if($id=='park'){
			$line = $this->db->query('SELECT * FROM bikedata where class="PP" AND Enable=1');
			$this->row=$line->fetchAll();
		}
		else if($id=='E'||$id=='S'||$id=='stas'||$id=='Attra'||$id=='Commu'||$id=='RSI'||$id=='AdPol'){
			$line = $this->db->query('SELECT * FROM bikedata where class="'.$id.'" AND Enable=1');
			$this->row=$line->fetchAll();
		}
		else{
			$this->row = 500;
		}
		
		if($type=='mobile'){
			return '';
		}
		else{
			return view('TKOCityBike',[
									'bikeClass'=>$this->menuIf($id),
									'topBtn'=>true,
									'bike'=>$this->row,
									'bikeMeun'=>[
												['Addr'=>'/Bike/MRT','lineName'=>'輕軌捷運',],
												['Addr'=>'/Bike/stas','lineName'=>'車站周邊',],
												['Addr'=>'/Bike/Attra','lineName'=>'景點周邊',],
												['Addr'=>'/Bike/S','lineName'=>'學校周邊',],
												['Addr'=>'/Bike/Commu','lineName'=>'社區周邊',],
												['Addr'=>'/Bike/RSI','lineName'=>'路街巷口',],
												['Addr'=>'/Bike/park','lineName'=>'公園周邊',],
												['Addr'=>'/Bike/AdPol','lineName'=>'行政警消',],
												['Addr'=>'/Bike/E','lineName'=>'其他地方',],
									],
			]);
		}
		
	}
	
	public function menuIf($id){
		if($id=='S'){
			return '學校周邊';
		}
		else if($id=='MRT'){
			return '輕軌捷運';
		}
		else if($id=='E'){
			return '其他地方';
		}
		else if($id=='park'){
			return '公園周邊';
		}
		else if($id=='stas'){
			return '車站周邊';
		}
		else if($id=='Attra'){
			return '景點周邊';
		}
		else if($id=='Commu'){
			return '社區周邊';
		}
		else if($id=='AdPol'){
			return '行政警消';
		}
		else if($id=='RSI'){
			return '路街巷口';
		}
		else if($id=='park'){
			return '公園周邊';
		}
		else{
			return '----';
		}
	}

	public function BikeCon($id){
		$Conn = new bikeConinCurlController;
		return $Conn->getBike($id, 'se');
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;


class seleBikeDataController extends Controller
{
	public function __construct()
    {
		// $this->users = $users;
		$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		// $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
        $this->db->exec("set names utf8");
	}
    
	public function BikeLineD($id, $type='')
	{
		#-------------------------
		#變數初始化
		#-------------------------
		if($id=='MRT'){
			$line = $this->db->query('SELECT * FROM bikedata where class="M" AND Enable=1');
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
			return $this->dataSubpackage($d, $type);
		}
		else if($id=='park'){
			$line = $this->db->query('SELECT * FROM bikedata where class="PP" AND Enable=1');
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
			return $this->dataSubpackage($d, $type);
		}
		else if($id=='E'||$id=='S'||$id=='stas'||$id=='Attra'||$id=='Commu'||$id=='RSI'||$id=='AdPol'){
			$line = $this->db->query('SELECT * FROM bikedata where class="'.$id.'" AND Enable=1');
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
			return $this->dataSubpackage($d, $type);
		}
		else{
			return 'err 500-bike';
		}
	}
	
    public function dataSubpackage($data, $type=''){
		//------------------------
		//變數宣告
		//------------------------
		$Bike = array();
		
        if(count($data)>0){
            foreach($data as $key=>$v){
                $num = count($Bike);
				$Bike[$num]['StationID'] = $v['StationID']?$v['StationID']:'---';
				$Bike[$num]['StationName'] = $v['StationNameTW']?$v['StationNameTW']:'---';
				$Bike[$num]['StationAddr'] = $v['StationAddressTW']?$v['StationAddressTW']:'---';
				$Bike[$num]['StationLat'] = $v['PositionLat']?$v['PositionLat']:'---';
				$Bike[$num]['StationLon'] = $v['PositionLon']?$v['PositionLon']:'---';
            }
            return $Bike;
        }
        else{
            return '';
        }
    }
}

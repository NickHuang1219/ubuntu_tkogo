<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class seleMrtDataController extends Controller
{
	public function __construct()
    {
		// $this->users = $users;
		$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		// $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
        $this->db->exec("set names utf8");
	}

    public function MrtLineD($id, $type=''){
        if($id=='r'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=100 AND ODMRT_Code<200 ORDER BY ODMRT_Code DESC');
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
			return $this->dataSubpackage($d, $type);
        }
        else if($id=='o'){
            $line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=200 AND ODMRT_Code<250');
            $d = $line->fetchAll(PDO::FETCH_ASSOC);
			return $this->dataSubpackage($d, $type);
        }
        else if($id=='CL'){
			$CLi = 0;
			$CLD = array();
			$line = $this->db->query('SELECT * FROM `lrtstation` WHERE oc=1 ORDER BY StationNum ASC');
			$AllLRTD = $line->fetchAll(PDO::FETCH_ASSOC);
			\Log::info('postt'.json_encode($AllLRTD));
			\Log::info('postt'.gettype($AllLRTD));
			foreach($AllLRTD as $v){
				$num = count($CLD);
				$CLD[$num]['ODMRT_Name'] = $v['StationID'];
				$CLD[$num]['ODMRT_CName'] = $v['StationName_TW'];
				// \Log::info('CLD-'.$num.': '.json_encode($CLD));
			}
			return $CLD;
        }
        else if($id=='formosa'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=300 AND ODMRT_Code<1000');
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
			return $this->dataSubpackage($d, $type);
        }
        else{
            return '404';
        }
    }

	
    public function MrtLineDT($id, $type=''){
        if($id=='r'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=100 AND ODMRT_Code<200');
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
			return count($this->dataSubpackage($d, $type));
        }
	}
	
    public function dataSubpackage($data, $type=''){
		//------------------------
		//變數宣告
		//------------------------
		$lineData = array();
		
		if(count($data)>0){
			foreach($data as $k=>$v){
				$num = count($lineData);
				$lineData[$num]['ODMRT_CName'] = $v['ODMRT_CName'];
				$lineData[$num]['ODMRT_Name'] = $v['ODMRT_Name'];
			}
			return $lineData;
		}
		else{
			return '';
		}
	}
}

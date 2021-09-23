<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class seleTraDataController extends Controller
{
	public function __construct()
    {
		// $this->users = $users;
		$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		// $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
        $this->db->exec("set names utf8");
	}

	public function TraLineD()
	{
	    #----------------------------
	    #變數初始化
	    #----------------------------
		$trastacounArr = array();
		$trastaArr = array();
		$counArr = array();
		$ci = 0;
		$ti = 0;
		$i = 0;
		
		// $this->load->database();
		$counties = $this->db->query("SELECT * FROM counties WHERE TRAop=1 ORDER BY id asc");
		// $AllCountiesD = $counties->result_array();
		// $countiesD = $counties->num_rows();
        $countiesD = $counties->fetchAll(PDO::FETCH_ASSOC);
		// $this->db->close();
		
		
		$trastationd = $this->db->query("SELECT * FROM trastationd WHERE op=1");
		// $trastationdD = $trastationd->result_array();
		#print_r($trastationdD);
		// $trastationdRows = $trastationd->num_rows();
        $trastationdD = $trastationd->fetchAll(PDO::FETCH_ASSOC);
		// $this->db->close();
		
		
		foreach($countiesD as $cd){
			$trastaArr[$ci]['id'] = $cd['id'];
			$trastaArr[$ci]['name'] = $cd['name'];
			$ci++;
			$ti=0;
			foreach($trastationdD as $td){
				if($cd['id']==$td['CountiesID']){
					$counArr[$cd['id']][$ti]['CountiesID'] = $td['CountiesID'];
					$counArr[$cd['id']][$ti]['StationID'] = $td['StationID'];
					$counArr[$cd['id']][$ti]['StationUID'] = $td['StationUID'];
					$counArr[$cd['id']][$ti]['StationNameTW'] = $td['StationNameTW'];
					$counArr[$cd['id']][$ti]['StationNameEN'] = $td['StationNameEN'];
					$counArr[$cd['id']][$ti]['PositionLat'] = $td['PositionLat'];
					$counArr[$cd['id']][$ti]['PositionLon'] = $td['PositionLon'];
					$counArr[$cd['id']][$ti]['StationClass'] = $td['StationClass'];
					$counArr[$cd['id']][$ti]['StationAddress'] = $td['StationAddress'];
					$ti++;
					$i++;
				}
			}
		}
		$trastacounArr['AllCountiesD'] = $trastaArr;
		$trastacounArr['trastationdD'] = $counArr;
		/*
		foreach($AllCountiesD as $c){
			print_r($counArr["'".$c['id']."'"]);
			echo "<br><br>";
		}*/
		#print_r($trastacounArr);
		return $trastacounArr;
	}
    
    public function dataSubpackage($data, $type=''){}
	
	public function Area(){
	    #------------------------
		#變數初始化
		#------------------------
		$Area = array();
		$AreaD = array();
		$i = 0;
		
        $seleArea = $this->db->query("SELECT * FROM `area` WHERE 1");
        $AreaData = $seleArea->fetchAll(PDO::FETCH_ASSOC);//result_array();
        // $seArea = $seleArea->num_rows();
        // $this->db->close();
        //echo $seArea;
        
        foreach($AreaData as $Arow)
        {
			$Area[$i]['AreaName'] = $Arow['AreaName'];
			$Area[$i]['AreaNum'] = $Arow['AreaNum'];
			$Area[$i]['AreaID'] = $Arow['TID'];
			$Area[$i]['total'] = $Arow['total'];
			$i++;
            /*if($Arow['total'] > 0)
            {
				$Area[$i]['AreaName'] = $Arow['AreaName'];
				$Area[$i]['AreaNum'] = $Arow['AreaNum'];
				$Area[$i]['TID'] = $Arow['TID'];
				$Area[$i]['total'] = $Arow['total'];
				$i++;
            }*/
        }

        return $Area;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class seleDataController extends Controller
{
	public function __construct()
    {
		// $this->users = $users;
		// $this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		$this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
        $this->db->exec("set names utf8");
	}

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {}
    
	public function BusLineD($id, $type=''){
		#-------------------------
		#變數初始化
		#-------------------------
        $d = array();
        $i = 0;
		if($id=='e'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='E' ORDER BY busline_data.nameZh ASC");
			foreach($line->fetchAll(PDO::FETCH_ASSOC) as $key=>$v){
                if($i==0){
                    if(isset($v['ID'])&&!empty($v['ID'])){ $d['ID'] = $v['ID']; }
                    else{ $d['ID'] = '---'; }
                    if(isset($v['nameZh'])&&!empty($v['nameZh'])){ $d['nameZh'] = $v['nameZh']; }
                    else{ $d['nameZh'] = '---'; }
                    if(isset($v['departureZh'])&&!empty($v['departureZh'])){ $d['departureZh'] = $v['departureZh']; }
                    else{ $d['departureZh'] = '---'; }
                    if(isset($v['destinationZh'])&&!empty($v['destinationZh'])){ $d['destinationZh'] = $v['destinationZh']; }
                    else{ $d['destinationZh'] = '---'; }
                    if(isset($v['ddesc'])&&!empty($v['ddesc'])){ $d['ddesc'] = $v['ddesc']; }
                    else{ $d['ddesc'] = '---'; }
                    print_r($v);
                    return count($v);
                }
                // $d[$i]= $v;
                $i++;
            }
            // return $d;
            // return $this->row=$line->fetchAll();
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
		else if($id=='f'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.nameZh ASC");
			return $this->row=$line->fetchAll();
		}
		else if($id=='o'||$id=='r'||$id=='y'||$id=='h'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			return $this->row=$line->fetchAll();
		}
		else{
			return 'err-500-1';
		}
	}
    
    public function MrtLineD($id, $type=''){
        if($id=='r'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=100 AND ODMRT_Code<200');
			$this->row=$line->fetchAll();
        }
        else if($id=='o'){
            $line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=200 AND ODMRT_Code<250');
            $this->row=$line->fetchAll();
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
        }
        else if($id=='formosa'){
			$line = $this->db->query('SELECT * FROM mrt where ODMRT_Code>=300 AND ODMRT_Code<1000');
			// $row=$line->fetchAll();
        }
        else{
            return '404';
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class seleBusDataController extends Controller
{
	public function __construct(){
		// $this->users = $users;
		$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		// $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
        $this->db->exec("set names utf8");
	}

	public function BusLineD($id, $type=''){
		if($id=='e'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='E' ORDER BY busline_data.nameZh ASC");
            $d = $line->fetchAll(PDO::FETCH_ASSOC);
            return $this->dataSubpackage($d, $type);
            // return $this->row=$line->fetchAll();
		}
		else if($id=='gr'||$id=='gre'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='Gre' ORDER BY busline_data.nameZh ASC");
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
            return $this->dataSubpackage($d, $type);
		}
		else if($id=='m'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_data.nameZh like '%幹線%' ORDER BY busline_data.nameZh ASC");
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
            return $this->dataSubpackage($d, $type);
		}
		else if($id=='g'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
            return $this->dataSubpackage($d, $type);
		}
		else if($id=='f'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.nameZh ASC");
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
            return $this->dataSubpackage($d, $type);
		}
		else if($id=='o'||$id=='r'||$id=='y'||$id=='h'){
			$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh, busline_idop.BusLineEnable FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='".strtoupper($id)."' ORDER BY busline_data.seRounts ASC");
			$d = $line->fetchAll(PDO::FETCH_ASSOC);
            return $this->dataSubpackage($d, $type);
		}
		else{
			return 'err-500-1';
		}
	}

    public function dataSubpackage($data, $type=''){
		#-------------------------
		#變數初始化
		#-------------------------
        $d = array();
        $i = 0;
        if(count($data)>0){
            foreach($data as $key=>$v){
                $d[$i]['ID'] = $v['ID']?$v['ID']:'---';
                $d[$i]['nameZh'] = $v['nameZh']?$v['nameZh']:'---';
                $d[$i]['departureZh'] = $v['departureZh']?$v['departureZh']:'---';
                $d[$i]['destinationZh'] = $v['destinationZh']?$v['destinationZh']:'---';
                $d[$i]['ddesc'] = $v['ddesc']?$v['ddesc']:'---';
                // if(isset($v['ID'])&&!empty($v['ID'])){ $d[$i]['ID'] = $v['ID']; }
                // else{ $d[$i]['ID'] = '---'; }
                // if(isset($v['nameZh'])&&!empty($v['nameZh'])){ $d[$i]['nameZh'] = $v['nameZh']; }
                // else{ $d[$i]['nameZh'] = '---'; }
                // if(isset($v['departureZh'])&&!empty($v['departureZh'])){ $d[$i]['departureZh'] = $v['departureZh']; }
                // else{ $d[$i]['departureZh'] = '---'; }
                // if(isset($v['destinationZh'])&&!empty($v['destinationZh'])){ $d[$i]['destinationZh'] = $v['destinationZh']; }
                // else{ $d[$i]['destinationZh'] = '---'; }
                // if(isset($v['ddesc'])&&!empty($v['ddesc'])){ $d[$i]['ddesc'] = $v['ddesc']; }
                // else{ $d[$i]['ddesc'] = '---'; }\
                $i++;
            }
            return $d;
        }
        else{}
    }
	
	public function dt(){
		$line= $this->db->query("SELECT busline_idop.ID, busline_data.nameZh, busline_data.ddesc, busline_data.departureZh, busline_data.destinationZh FROM busline_idop JOIN busline_data ON busline_idop.ID=busline_data.ID WHERE busline_idop.BusLineEnable=1 AND busline_idop.BClass='G' ORDER BY busline_data.seRounts ASC");
		$data = $line->fetchAll();
		foreach($data as $key=>$v){
			print_r(json_encode($v['departureZh']));
			echo '<br><br>.';
			// $d[$i]['ID'] = $v['ID']?$v['ID']:'---';
			// $d[$i]['nameZh'] = $v['nameZh']?$v['nameZh']:'---';
			// $d[$i]['departureZh'] = $v['departureZh']?$v['departureZh']:'---';
			// $d[$i]['destinationZh'] = $v['destinationZh']?$v['destinationZh']:'---';
			// $d[$i]['ddesc'] = $v['ddesc']?$v['ddesc']:'---';
			// $i++;
		}
	}
}

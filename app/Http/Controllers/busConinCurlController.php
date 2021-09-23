<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class busConinCurlController extends Controller
{
    public function ConinTime($busId, $class){
        $data = array();
        if($class=='g'||$class=='r'||$class=='o'||$class=='y'||$class=='m'||
            $class=='f'||$class=='green'||$class=='gre'||$class=='h'||$class=='e'||$class=='P'){
            $this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
            // $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
            $this->db->exec("set names utf8");
            $line= $this->db->query("SELECT * FROM busline_idop WHERE busline_idop.BusLineEnable=1 AND busline_idop.ID=".$busId);
            $d = $line->fetchAll(PDO::FETCH_ASSOC);
            if($d==null){
                $data['type'] = 0;
                $data['errT'] = '無此路線或路線已停駛.';
                return json_encode($data);
            }
            else if($class=='P'){
                return $this->busConinTime($busId);
            }
            else{
                return json_encode($this->busConinTime($busId));
            }
        }
        else{
            $data['type'] = 0;
            $data['errT'] = '資訊錯誤，權限不足.';
            return json_encode($data);
        }
    }
    public function busConinTime($id){
        #--------------------
        #變數宣告
        $i=0;
        $go = 0;
        $goS = '';
        $goE = '';
        $back = 0;
        $backS = '';
        $backE = '';
        $coninTime = array();
        $togo = array();
        $toback = array();
        $busC = '';
        $busCarId = '';
        $busCount = 0;
        $nowCar = '';
        
        //CURL開始
        $ch = curl_init();
        $url = "ibus.tbkc.gov.tw/xmlbus/GetEstimateTime.xml?routeIds=".$id;//0";//
                
        //curl_setopt可以設定curl參數
        //設定url
        curl_setopt($ch , CURLOPT_URL , $url);
                    
        //獲取結果不顯示
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        #curl_setopt($ch, CURLINFO_HTTP_CODE);
        #$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        #echo $httpCode;//curl_getinfo($ch,CURLINFO_RESPONSE_CODE); 
                    
        curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");//執行，並將結果存回
        $BusLine = curl_exec($ch);
        $httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
        // return $this->bus($BusLine, $httpCode);

        if($httpCode==200){
            $xml = simplexml_load_string($BusLine);
            $xml2array = json_decode(json_encode($xml),TRUE);
            if(isset($xml2array['BusInfo']['Route']['EstimateTime'])){
                $coninData = $xml2array['BusInfo']['Route']['EstimateTime'];
                foreach($coninData as $v){
                    if($i>=0){
                        $StopName = $v['@attributes']['StopName'];
                        $GoBack = $v['@attributes']['GoBack'];
                        $Value = $v['@attributes']['Value'];
                        $Time = $comeTime = $v['@attributes']['comeTime'];
                        $carId = $v['@attributes']['carId'];
                        $comeCarid = $v['@attributes']['comeCarid'];
                        if(strpos($Value,':')==false&&(int)$Value<10){
                            if($carId!=''||$carId!=null||$carId!='null'){
                                $nowCar=$carId;
                            }
                            else if($comeCarid!=''||$comeCarid!=null||$comeCarid!='null'){
                                $nowCar = $comeCarid;
                            }
                            else{
                                $nowCar = '';
                            }
                            if($i<2){
                                $busC = $nowCar;
                                $busCarId = $nowCar;
                            }
                            else if($busC==$nowCar){
                                $busCarId = '';
                            }
                            else{
                                $busC = $nowCar;
                                $busCarId = $nowCar;
                            }
                        }
                        else{
                            $busCarId = '';
                        }
                        if($GoBack=='1'){
                            if($go==0){
                                $goS = $StopName;
                            }
                            $goE = $StopName;
                            $togo[$go]['StopName'] = $StopName;
                            $togo[$go]['time'] = $this->cheTime($Value, $Time);
                            $togo[$go]['busCarId'] = $busCarId;
                            $go++;
                        }
                        if($GoBack=='2'){
                            if($back==0){
                                $backS = $StopName;
                            }
                            $backE = $StopName;
                            $toback[$back]['StopName'] = $StopName;
                            $toback[$back]['time'] = $this->cheTime($Value, $Time);
                            $toback[$back]['busCarId'] = $busCarId;
                            $back++;
                        }
                    }
                    $i++;
                }
                
                
                $coninTime['backS'] = $backS;
                $coninTime['backE'] = $backE;
                $coninTime['httpCode'] = $httpCode;
                $coninTime['stationLineID'] = $id;
                $coninTime['errT'] = '';
                if($go>0 && $back==0){
                    $coninTime['type'] = 1;
                    $coninTime['togo'] = $togo;
                    $coninTime['toback'] = '';
                }
                else if($go==0 && $back>0){
                    $coninTime['type'] = 2;
                    $coninTime['togo'] = '';
                    $coninTime['toback'] = $toback;
                }
                else{
                    $coninTime['type'] = 3;
                    $coninTime['togo'] = $togo;
                    $coninTime['toback'] = $toback;
                }
            }
            else{
                $coninTime['type'] = 0;
                $coninTime['errT'] = "高雄市公車Server無回傳即時動態.";
            }
        }
        else{
            $coninTime['type'] = 0;
            $coninTime['errT'] = "高雄市公車伺服器異常.";
        }
        return $coninTime;//'111';//
    }
    public function cheTime($time, $nextTime){
        $explTime = explode(':', $time);
        $explNextTime = explode(':', $nextTime);
        if($time=='null' || $time==null || $time==''){
            if(isset($explNextTime[1])){
                return $nextTime;
            }
            else{
                return $this->cheConinTime($nextTime);
            }
        }
        else{
            if(isset($explTime[1])){
                return $time;
            }
            else{
                return $this->cheConinTime($time);
            }
        }
    }
    public function cheConinTime($num){
        if($num=='-3'){
            return "末班車已離";
        }
        else if($num==''){
            return "";
        }
        else{
            if($num=='0'){
                return "進站中！";
            }
            else if($num=='1' || $num=='2'){
                return "即將進站.";
            }
            else{
                return $num."分.";
            }
        }
    }
    public function cheCarId($Id, $nextId, $Time){
        if($Time=="進站中！"){
            if($Id!='' && $Id!='null' && $Id!=null){
                return $Id;
            }
            else if($nextId!='' && $nextId!='null' && $nextId!=null){
                return $Time;
            }
            else{
                return '';
            }
        }
        else{
            return '';
        }
    }
    
    
    public function gobustime($id)
    {
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

            //echo $aaa->result_array();
            //echo $BusLineN;
            //CURL結束
            #---------------------
            #變數初始化
            #---------------------
            $ToGo = '';
            $ToBack = '';
            $VToGo = '';
            $VToBack = '';
            $LN = '';

            
            #---------------------
            #防呆變數
            #---------------------
            $Foolproof = preg_match("/GoBack=\"1\"/",$BusLine);
            
            
            #---------------------
            #防呆判斷
            #---------------------
            if($Foolproof == 1){
                
                $ToGo .= '<ToGo><table style="float:center; width:100%;" style="color:#000;">';
                $ToGo .= '<tr><td style="width:25%;"><span style="color:#FFF;">狀態</span></td>';
                $ToGo .= '<td style="width:55%;"><span style="color:#FFF;">站牌名稱</span></td>';
                $ToGo .= '<td style="width:20%;" align="right"><span style="color:#FFF;">車牌</td></span></tr>';
            foreach($BusLineN as $k => $v){
                $vv =  preg_split("/[\s,]\"/", $v);
                
                foreach($vv as $ro){
                    $GoBack = explode('GoBack="', $ro);
                    $GoBackN = explode('" ', $GoBack[1]);
                    $BusGo = $GoBackN[0];

                
                    if($BusGo == 1){
                        $StopName = explode('StopName="', $ro);
                        $StopNameN = explode('" ', $StopName[1]);

                    
                        $Value = explode('Value="', $ro);
                        $ValueN = explode('" ', $Value[1]);
                        if($ValueN[0] == '-3'){
                            $ToGo .= '<tr><td style="width:25%;" id="ValueN" align="left"><span style="color:#FFF;">末班車已離</span></td>';
                            $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                            $ToGo .= '<td style="width:20%;"></td></tr>';
                        }
                        else if($ValueN[0] == 'null'){
                            $comeTime = explode('comeTime="', $ro);
                            $comeTimeN = explode('" ', $comeTime[1]);
                            
                            $ToGo .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$comeTimeN[0].'</span></td>';
                            $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                            $ToGo .= '<td></td></tr>';
                        }
                        else if($ValueN[0] == 0){
                            //車牌
                            $carId = explode('carId="', $ro);
                            $carIdN = explode('" ', $carId[1]);
                            if($carIdN[0] == ''){
                                $comeCarid = explode('comeCarid="', $ro);
                                $comeCaridN = explode('" ', $comeCarid[1]);
                                
                                $ToGo .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">進站中</span></td>';//.'<br>'; background-color:#9A0033;
                                $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                $ToGo .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$comeCaridN[0].'</span></td></tr>';
                            }
                            else{
                                $ToGo .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">進站中</span></td>';//.'<br>';
                                $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                $ToGo .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$carIdN[0].'</span></td></tr>';
                            }
                                
                                $LN = '1';
                        }
                        else if($ValueN[0] == 1){
                            if($LN == '1'){
                                $ToGo .= '<tr><td style="width:25%;" id="ValueN">'.$ValueN[0].'分</td>';
                                $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                $ToGo .= '<td style="width:20%; color:#FFF;" align="right" id="carId">即將進站</td></tr>';
                            }
                            else{
                                $carId = explode('carId="', $ro);
                                $carIdN = explode('" ', $carId[1]);
                                if($carIdN[0] == ''){
                                    $comeCarid = explode('comeCarid="', $ro);
                                    $comeCaridN = explode('" ', $comeCarid[1]);
                                    
                                    $ToGo .= '<tr><td style="width:25%;" id="ValueN">'.$ValueN[0].'分</td>';
                                    $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                    $ToGo .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$comeCaridN[0].'</span></td></tr>';
                                }
                                else{
                                    $ToGo .= '<tr><td style="width:25%;" id="ValueN">'.$ValueN[0].'分</td>';
                                    $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                    $ToGo .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$carIdN[0].'</span></td></tr>';
                                }
                                $LN = '1';
                            }
                        }
                        else if($ValueN[0] == 2){
                            //echo '即將進站';
                            if($LN == '1'){
                                $ToGo .= '<tr><td style="width:25%;" id="ValueN">'.$ValueN[0].'分</td>';
                                $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</td>';
                                $ToGo .= '<td style="width:20%; color:#FFF;" align="right" id="carId">即將進站</td></tr>';
                            }
                            else{
                                $carId = explode('carId="', $ro);
                                $carIdN = explode('" ', $carId[1]);
                                if($carIdN[0] == ''){
                                    $comeCarid = explode('comeCarid="', $ro);
                                    $comeCaridN = explode('" ', $comeCarid[1]);
                                    
                                    $ToGo .= '<tr><td style="width:25%;" id="ValueN"><'.$ValueN[0].'分</td>';
                                    $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                    $ToGo .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$comeCaridN[0].'</span></td></tr>';
                                }
                                else{
                                    $ToGo .= '<tr><td style="width:25%;" id="ValueN">'.$ValueN[0].'分</td>';
                                    $ToGo .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</td>';
                                    $ToGo .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$carIdN[0].'</span></td></tr>';
                                }
                                $LN = '1';
                            }
                        }
                        else{
                            $ToGo .= '<tr><td style="width:25%;" id="ValueN">'.$ValueN[0].'分</td>';
                            $ToGo .= '<td style="width:55%; color:#FFF;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</td>';
                            $ToGo .= '<td style="width:20%;"></td></tr>';
                            $LN = '';
                            
                        }
                    }
                }
            }
            $ToGo .= '</table></ToGo>';//return
            echo $ToGo;
        }
    }

    public function backbustime($id)
    {
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
            //CURL結束
            
            #---------------------
            #變數初始化
            #---------------------
            $ToGo = '';
            $ToBack = '';
            $VToGo = '';
            $VToBack = '';
            $LM = '';
            
            
            #---------------------
            #防呆變數
            #---------------------
            $Foolproof = preg_match("/GoBack=\"2\"/",$BusLine);
            
            
            #---------------------
            #防呆判斷 background-color:#003A2B;
            #---------------------
            if($Foolproof == 1){
                $ToBack .= '<ToGo><table style="float:center; width:100%;">';
                $ToBack .= '<tr><td style="width:25%;"><span style="color:#FFF;">狀態</span></td>';
                $ToBack .= '<td style="width:55%;"><span style="color:#FFF;">站牌名稱</span></td>';
                $ToBack .= '<td style="width:20%;" align="right"><span style="color:#FFF;">車牌</span></td></tr>';
                
            foreach($BusLineN as $k => $v){
                $vv =  preg_split("/[\s,]\"/", $v);
                
                foreach($vv as $ro){
                    $GoBack = explode('GoBack="', $ro);
                    $GoBackN = explode('" ', $GoBack[1]);
                    $BusGo = $GoBackN[0];

                
            
                    if($BusGo == 2){
                        $StopName = explode('StopName="', $ro);
                        $StopNameN = explode('" ', $StopName[1]);

                    
                        $Value = explode('Value="', $ro);
                        $ValueN = explode('" ', $Value[1]);
                        if($ValueN[0] == '-3'){
                            $ToBack .= '<tr><td style="width:25%;" id="EndCard" align="left"><span style="color:#FFF;">末班車已離</span></td>';
                            $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                            $ToBack .= '<td style="width:20%; color:#FFF;"></td></tr>';
                        }
                        else if($ValueN[0] == 'null'){
                            $comeTime = explode('comeTime="', $ro);
                            $comeTimeN = explode('" ', $comeTime[1]);
                            
                            $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$comeTimeN[0].'</span></td>';
                            $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                            $ToBack .= '<td style="width:20%; color:#FFF;"></td></tr>';
                        }
                        else if($ValueN[0] == 0){
                            //車牌
                            $carId = explode('carId="', $ro);
                            $carIdN = explode('" ', $carId[1]);
                            if($carIdN[0] == ''){
                                $comeCarid = explode('comeCarid="', $ro);
                                $comeCaridN = explode('" ', $comeCarid[1]);
                                
                                $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">進站中</span></td>';//.'<br>';
                                $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                $ToBack .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$comeCaridN[0].'</span></td></tr>';
                            }
                            else{
                                $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">進站中</span></td>';//.'<br>';
                                $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                $ToBack .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$carIdN[0].'</span></td></tr>';
                            }
                                
                                $LN = '1';
                        }
                        else if($ValueN[0] == 1){
                            if($LN == '1'){
                                $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$ValueN[0].'</span>分</td>';
                                $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                $ToBack .= '<td style="width:20%; color:#FFF;" align="right" id="carId">即將進站</td></tr>';
                            }
                            else{
                                $carId = explode('carId="', $ro);
                                $carIdN = explode('" ', $carId[1]);
                                if($carIdN[0] == ''){
                                    $comeCarid = explode('comeCarid="', $ro);
                                    $comeCaridN = explode('" ', $comeCarid[1]);
                                    
                                    $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$ValueN[0].'分</span></td>';
                                    $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                    $ToBack .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$comeCaridN[0].'</span></td></tr>';
                                }
                                else{
                                    $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$ValueN[0].'分</span></td>';
                                    $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                    $ToBack .= '<td style="width:20%; color:#FFF;" align="right" id="carId"><span style="color:#FFF;">'.$carIdN[0].'</span></td></tr>';
                                }
                                $LN = '1';
                            }
                        }
                        else if($ValueN[0] == 2){
                            //echo '即將進站';
                            if($LN == '1'){
                                $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$ValueN[0].'分</span></td>';
                                $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                $ToBack .= '<td style="width:20%; color:#FFF;" align="right" id="carId">即將進站</td></tr>';
                            }
                            else{
                                $carId = explode('carId="', $ro);
                                $carIdN = explode('" ', $carId[1]);
                                if($carIdN[0] == ''){
                                    $comeCarid = explode('comeCarid="', $ro);
                                    $comeCaridN = explode('" ', $comeCarid[1]);
                                    
                                    $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$ValueN[0].'分</span></td>';
                                    $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                    $ToBack .= '<td style="width:20%;" align="right" id="carId"><span style="color:#FFF;">'.$comeCaridN[0].'</span></td></tr>';
                                }
                                else{
                                    $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$ValueN[0].'分</span></td>';
                                    $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                                    $ToBack .= '<td style="width:20%;" align="right" id="carId"><span style="color:#FFF;">'.$carIdN[0].'</span></td></tr>';
                                }
                                $LN = '1';
                            }
                        }
                        else{
                            $ToBack .= '<tr><td style="width:25%;" id="ValueN"><span style="color:#FFF;">'.$ValueN[0].'分</span></td>';
                            $ToBack .= '<td style="width:55%;" align="left" id="lineName"><span style="color:#FFF;">'.$StopNameN[0].'</span></td>';
                            $ToBack .= '<td style="width:20%;"></td></tr>';
                            $LN = '';
                            
                        }
                    }
                }
            }
            $ToBack .= '</table></ToGo>';
            echo $ToBack; 
        }
    }


    public function togobustime($id)
    {
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

            //echo $aaa->result_array();
            //echo $BusLineN;
            //CURL結束
            #---------------------
            #變數初始化
            #---------------------
            $ToGo = '';
            $ToBack = '';
            $VToGo = '';
            $VToBack = '';
            $LN = '';

            
            #---------------------
            #防呆變數
            #---------------------
            $Foolproof = preg_match("/GoBack=\"1\"/",$BusLine);
            
            
            #---------------------
            #防呆判斷
            #---------------------
            if($Foolproof == 1){
                
                //$ToGo .= '<ToGo><table style="float:center; width:100%;" style="color:#000;">';
                // $ToGo .= '{ValueN:狀態';
                // $ToGo .= 'StopNameN:站牌名稱';
                // $ToGo .= 'carIdN:車牌}';
                $ToGo = $a = array('ValueN'=>"狀態",'StopNameN'=>"站牌名稱",'carIdN'=>"車牌");
            foreach($BusLineN as $k => $v){
                $vv =  preg_split("/[\s,]\"/", $v);
                
                foreach($vv as $ro){
                    $GoBack = explode('GoBack="', $ro);
                    $GoBackN = explode('" ', $GoBack[1]);
                    $BusGo = $GoBackN[0];

                
                    if($BusGo == 1){
                        $StopName = explode('StopName="', $ro);
                        $StopNameN = explode('" ', $StopName[1]);

                    
                        $Value = explode('Value="', $ro);
                        $ValueN = explode('" ', $Value[1]);
                        if($ValueN[0] == '-3'){
                            // $ToGo .= '{ValueN:末班車已離';
                            // $ToGo .= 'StopNameN:'.$StopNameN[0];
                            // $ToGo .= 'carIdN:'.'},';
                            $ToGo .= $a = array('ValueN'=>"末班車已離",'StopNameN'=>$StopNameN[0],'carIdN'=>"");
                        }
                        else if($ValueN[0] == 'null'){
                            $comeTime = explode('comeTime="', $ro);
                            $comeTimeN = explode('" ', $comeTime[1]);
                            
                            // $ToGo .= '{ValueN:'.$comeTimeN[0];
                            // $ToGo .= 'StopNameN:'.$StopNameN[0];
                            // $ToGo .= 'carIdN:'.'},';
                            $ToGo .= $a = array('ValueN'=>$comeTimeN[0],'StopNameN'=>$StopNameN[0],'carIdN'=>"");
                        }
                        else if($ValueN[0] == 0){
                            //車牌
                            $carId = explode('carId="', $ro);
                            $carIdN = explode('" ', $carId[1]);
                            if($carIdN[0] == ''){
                                $comeCarid = explode('comeCarid="', $ro);
                                $comeCaridN = explode('" ', $comeCarid[1]);
                                
                                // $ToGo .= '{ValueN:進站中';
                                // $ToGo .= 'StopNameN:'.$StopNameN[0];
                                // $ToGo .= 'carIdN:'.$comeCaridN[0].'},';
                                $ToGo .= $a = array('ValueN'=>"進站中",'StopNameN'=>$StopNameN[0],'carIdN'=>$comeCaridN[0]);
                            }
                            else{
                                // $ToGo .= '{ValueN:進站中';
                                // $ToGo .= 'StopNameN:'.$StopNameN[0];
                                // $ToGo .= 'carIdN:'.$carIdN[0].'},';
                                $ToGo .= $a = array('ValueN'=>"進站中",'StopNameN'=>$StopNameN[0],'carIdN'=>$carIdN[0]);
                            }
                                
                                $LN = '1';
                        }
                        else if($ValueN[0] == 1){
                            if($LN == '1'){
                            //    $ToGo .= '{ValueN:'.$ValueN[0];
                    //  		$ToGo .= 'StopNameN:'.$StopNameN[0];
                                // $ToGo .='carIdN:即將進站},';
                            $ToGo .= $a = array('ValueN'=>$ValueN[0],'StopNameN'=>$StopNameN[0],'carIdN'=>"即將進站");
                            }
                            else{
                                $carId = explode('carId="', $ro);
                                $carIdN = explode('" ', $carId[1]);
                                if($carIdN[0] == ''){
                                    $comeCarid = explode('comeCarid="', $ro);
                                    $comeCaridN = explode('" ', $comeCarid[1]);
                                    
                                    // $ToGo .= '{ValueN:'.$ValueN[0];
                                    // $ToGo .= 'StopNameN:'.$StopNameN[0];
                                    // $ToGo .= 'carIdN:'.$comeCaridN[0].'},';
                                    $ToGo .= $a = array('ValueN'=>$ValueN[0],'StopNameN'=>$StopNameN[0],'carIdN'=>$comeCaridN[0]);
                                }
                                else{
                                    // $ToGo .= '{ValueN:'.$ValueN[0];
                                    // $ToGo .= 'StopNameN:'.$StopNameN[0];
                                    // $ToGo .= 'carIdN:'.$carIdN[0].'},';
                                    $ToGo .= $a = array('ValueN'=>$ValueN[0],'StopNameN'=>$StopNameN[0],'carIdN'=>$carIdN[0]);
                                }
                                $LN = '1';
                            }
                        }
                        else if($ValueN[0] == 2){
                            //echo '即將進站';
                            if($LN == '1'){
                            //    $ToGo .= '{ValueN:'.$ValueN[0];
                    //  		$ToGo .= 'StopNameN:'.$StopNameN[0];
                                // $ToGo .= 'carIdN:即將進站},';
                                $ToGo .= $a = array('ValueN'=>$ValueN[0],'StopNameN'=>$StopNameN[0],'carIdN'=>"即將進站");
                            }
                            else{
                                $carId = explode('carId="', $ro);
                                $carIdN = explode('" ', $carId[1]);
                                if($carIdN[0] == ''){
                                    $comeCarid = explode('comeCarid="', $ro);
                                    $comeCaridN = explode('" ', $comeCarid[1]);
                                    
                                    // $ToGo .= '{ValueN:'.$ValueN[0];
                                    // $ToGo .= 'StopNameN:'.$StopNameN[0];
                                    // $ToGo .= 'carIdN:'.$comeCaridN[0].'},';
                                    $ToGo .= $a = array('ValueN'=>$ValueN[0],'StopNameN'=>$StopNameN[0],'carIdN'=>$comeCaridN[0]);
                                }
                                else{
                                    // $ToGo .= '{ValueN:'.$ValueN[0];
                                    // $ToGo .= 'StopNameN:'.$StopNameN[0];
                                    // $ToGo .= 'carIdN:'.$carIdN[0].'},';
                                    $ToGo .= $a = array('ValueN'=>$ValueN[0],'StopNameN'=>$StopNameN[0],'carIdN'=>$carIdN[0]);
                                }
                                $LN = '1';
                            }
                        }
                        else{
                            // $ToGo .= '{ValueN:'.$ValueN[0];
                    //   	$ToGo .= 'StopNameN:'.$StopNameN[0];
                            // $ToGo .= 'carIdN:'.'},';
                            $ToGo .= $a = array('ValueN'=>$ValueN[0],'StopNameN'=>$StopNameN[0],'carIdN'=>"");
                            $LN = '';
                        }
                    }
                }
            }
            //$ToGo .= '</table></ToGo>';
            return $ToGo;
        }
    }

}

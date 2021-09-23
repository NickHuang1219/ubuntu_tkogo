<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDO;
use App\Http\Controllers\Controller;

use App\User;
use App\Repositories\UserRepository;

class curlWeathersController extends Controller
{
	
	public function getWeathers($str, $chS, $chT){
		$D = array();
		$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		// $this->db = new PDO('mysql:host=localhost;dbname=db000;', 'root', '');
        $this->db->exec("set names utf8");
		$area= $this->db->query('SELECT * FROM area WHERE AreaName="'.$str.'"');
		$areaD = $area->fetchAll(PDO::FETCH_ASSOC);
		\Log::info('00000');
        if($areaD==null){
			$D['httpType'] = 'err';//成功失敗辨識
			$D['ErrCode'] = 'Weather500-';//前端錯誤代碼
			$D['ErrT'] = '氣象參數錯誤.';//前端錯誤顯示訊息
			return json_encode($D);
		}
		else{
			if($chS=='p' && $chT=='k900nh'){
				return json_encode($this->Weathers($str, $chT));
			}
			else{
				$D['httpType'] = 'err';//成功失敗辨識
				$D['ErrCode'] = 'Weather500-1-';//前端錯誤代碼
				$D['ErrT'] = '參數錯誤.';//前端錯誤顯示訊息
				return json_encode($D);
			}
		}
	}
	public function Weathers($str, $chS){
		#----------------------------
		#變數初始化
		#----------------------------
		$weatherD = array();
		$i=0;
		
		$url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-067?Authorization=CWB-356DE013-F4B0-4777-81B0-05E0FD12E298&format=JSON&locationName='.$str.'&elementName=WeatherDescription&sort=time';
		//&startTime=2020-07-29T06%3A00%3A00&timeTo=2020-07-29T11%3A41%3A55
		
		//送出查詢
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		//curl_setopt可以設定curl參數
		//設定url
		curl_setopt($ch , CURLOPT_URL , $url);
					
		//獲取結果不顯示
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					
		curl_setopt($ch, CURLOPT_USERAGENT, "Google Bot");//執行，並將結果存回
		$WeatherD = curl_exec($ch);
		$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);
					
		$tt = json_decode($WeatherD);
		if($httpCode=='200' && count($tt->records->locations[0]->location[0]->weatherElement[0]->time)>0){
			$D = $tt->records->locations[0]->location[0]->weatherElement[0]->time[0]->elementValue[0]->value;
			$v=explode('。', $D);
			
			if(count($v)==7){
				$wea=explode('至', $v[2]);
				$weaMin=explode('溫度攝氏', $wea[0]);
				$weaMax=explode('度', $wea[1]);
				
				$vD = $v[0];
				$weatherD['ImgCode'] = $this->getImgCodeType($vD,'imgCode');
				if($chS=='k900nh'){
					$weatherD['ImgCode'] = $this->getImgCodeType($vD,'imgCode');
				}/**/
				$weatherD['weatherT'] = $v[0];//氣候
				$weatherD['Rainfall'] = $v[1];//降雨機率
				#$weatherD[''] = ;//天氣型態
				$weatherD['temperaHight'] = $weaMax[0];//最高溫度
				$weatherD['temperaLow'] = $weaMin[1];//最低溫度
				$weatherD['todayWeather'] = $this->getWeatherTData($str);//當下氣溫
				#$weatherD['ImgCode'] = $this->getImgCode($str);
				$weatherD['httpType'] = 'success';//成功失敗辨識
				$weatherD['ErrCode'] = '0';//前端錯誤代碼
				$weatherD['ErrT'] = '';//前端錯誤顯示訊息
				#$weatherD['httpCode'] = $httpCode;//curl第三方httpCode
				#print_r($weatherD);
				return $weatherD;
			}
			else{
				$weatherD['weatherT'] = '';//氣候
				$weatherD['Rainfall'] = '';//降雨機率
				#$weatherD[''] = ;//天氣型態
				#$weatherD[''] = ;//最高溫度
				#$weatherD[''] = ;//最低溫度
				#$weatherD[''] = ;//當下氣溫
				$weatherD['httpType'] = 'err';//成功失敗辨識
				$weatherD['ErrCode'] = 'D404-'.count($v);//前端錯誤代碼
				$weatherD['ErrT'] = '氣象局無資料回傳.';//前端錯誤顯示訊息
				return $weatherD;
			}
		}
		else{
			$weatherD['weatherT'] = '';//氣候
			$weatherD['Rainfall'] = '';//降雨機率
			#$weatherD[''] = ;//天氣型態
			#$weatherD[''] = ;//最高溫度
			#$weatherD[''] = ;//最低溫度
			#$weatherD[''] = ;//當下氣溫
			$weatherD['httpType'] = 'err';//成功失敗辨識
			#$weatherD['httpCode'] = $httpCode;//curl第三方httpCode
			$weatherD['ErrCode'] = 'C404';//前端錯誤代碼
			$weatherD['ErrT'] = '氣象局Server異常.';//前端錯誤顯示訊息
			return $weatherD;
		}
    }
	private function getWeatherTData($s){
		$url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-067?Authorization=CWB-356DE013-F4B0-4777-81B0-05E0FD12E298&format=JSON&locationName='.$s.'&elementName=T&sort=time';
		
		//送出查詢
		$WeatherTData = curl_init();
		curl_setopt($WeatherTData, CURLOPT_URL,$url);
		//curl_setopt可以設定curl參數
		//設定url
		curl_setopt($WeatherTData , CURLOPT_URL , $url);
					
		//獲取結果不顯示
		curl_setopt($WeatherTData, CURLOPT_RETURNTRANSFER, true);
					
		curl_setopt($WeatherTData, CURLOPT_USERAGENT, "Google Bot");//執行，並將結果存回
		$TD = curl_exec($WeatherTData);
		$THttpCode=curl_getinfo($WeatherTData,CURLINFO_HTTP_CODE);
		curl_close($WeatherTData);
		
		$TR = json_decode($TD);
		$T = $TR->records->locations[0]->location[0]->weatherElement[0]->time[0]->elementValue[0]->value;
		#echo 'WeatherT: '.$T;
		return $T;
	}
	private function getImgCodeType($weatherStr, $cheStr){
		$sun = preg_match('/晴/i', $weatherStr);#晴
		$cloudy = preg_match('/多雲/i', $weatherStr);#多雲
		$yin = preg_match('/陰/i', $weatherStr);#陰
		$rain = preg_match('/雨/i', $weatherStr);#雨
		$fog = preg_match('/霧/i', $weatherStr);#霧
		$mine = preg_match('/雷/i', $weatherStr);#雷
		$imgNumS = (string)$sun.(string)$cloudy.(string)$yin.(string)$rain.(string)$fog.(string)$mine;
		#echo $weatherStr.'--'.$imgNumS."<br>";
			
		if($cheStr=='imgType'){
			return $imgNumS;
		}
		else if($cheStr=='imgCode'){
			if($sun){#晴
				if($cloudy){#多雲
					#晴 多雲
					if($yin){#陰
						#晴 多雲 陰
						if($rain){#雨
							#晴 多雲 陰 雨
							if($fog){#霧
								#晴 多雲 陰 雨 霧
								if($mine){#雷
									#晴 多雲 陰 雨 霧 雷V
									return '1';
								}
								else{
									#晴 多雲 陰 雨 霧V
									return '2';
								}
							}
							else if($mine){#雷
								#晴 多雲 陰 雨 雷V
								return '1';
							}
							else{
								#晴 多雲 陰 雨V
								return '2';
							}
						}
						else if($fog){#霧
							#晴 多雲 陰 霧
							if($mine){#雷
								#晴 多雲 陰 霧 雷V
								return '3';
							}
							else{
								#晴 多雲 陰 霧V
								return '4';
							}
						}
						else if($mine){#雷
							#晴 多雲 陰 雷V
							return '3';
						}
						else{
							#晴 多雲 陰V
							return '4';
						}
					}
					else if($rain){#雨
						#晴 多雲 雨
						if($fog){#霧
							#晴 多雲 雨 霧
							if($mine){#雷
								#晴 多雲 雨 雷V
								return '5';
							}
							else{
								#晴 多雲 雨 霧V
								return '6';
							}
						}
						else if($mine){#雷
							#晴 多雲 雨 雷V
							return '5';
						}
						else{
							#晴 多雲 雨V
							return '6';
						}
					}
					else if($fog){#霧
						#晴 多雲 霧
						if($mine){#雷
							#晴 多雲 霧 雷V
							return '7';
						}
						else{
							#晴 多雲 霧V
							return '8';
						}
					}
					else if($mine){#雷
						#晴 多雲 雷V
						return '7';
					}
					else{
						#晴 多雲V
						return '8';
					}
				}
				else if($yin){#陰
					#晴 陰
					if($rain){#雨
						#晴 陰 雨
						if($fog){#霧
							#晴 陰 雨 霧
							if($mine){#雷
								#晴 陰 雨 霧 雷V
								return '9';
							}
							else{
								#晴 陰 雨 霧V
								return '10';
							}
						}
						else if($mine){#雷
							#晴 陰 雨 雷V
							return '9';
						}
						else{
							#晴 陰 雨V
							return '10';
						}
					}
					else if($fog){#霧
						#晴 陰 霧
						if($mine){#雷
							#晴 陰 霧 雷V
							return '11';
						}
						else{
							#晴 陰 霧V
							return '12';
						}
					}
					else if($mine){#雷
						#晴 陰 雷V
						return '11';
					}
					else{
						#晴 陰V
						return '12';
					}
				}
				else if($rain){#雨
					#晴 雨
					if($fog){#霧
						#晴 雨 霧
						if($mine){#雷
							#晴 雨 霧 雷(一片雲)V
							return '13';
						}
						else{
							#晴 雨 霧(一片雲)V
							return '14';
						}
					}
					else if($mine){#雷
						#晴 雨 雷(一片雲)V
						return '13';
					}
					else{
						#晴 雨(一片雲)V
						return '14';
					}
				}
				else if($fog){#霧
					# 晴 霧
					if($mine){#雷
						# 晴 霧 雷(一片雲)V
						return '15';
					}
					else{
						# 晴 霧V
						return '16';
					}
				}
				else if($mine){#雷
					#晴 雷(一片雲)V
					return '15';
				}
				else{
					#晴V
					return '16';
				}
			}
			else if($cloudy){#多雲
				if($yin){#陰
					#多雲 陰
					if($rain){#雨
						#多雲 陰 雨
						if($fog){#霧
							#多雲 陰 雨 霧
							if($mine){#雷
								#多雲 陰 雨 霧 雷V
								return '17';
							}
							else{
								#多雲 陰 雨 霧V
								return '18';
							}
						}
						else if($mine){#雷
							#多雲 陰 雨 雷V
							return '17';
						}
						else{
							#多雲 陰 雨V
							return '18';
						}
					}
					else if($fog){#霧
						#多雲 陰 霧
						if($mine){#雷
							#多雲 陰 霧 雷V
							return '19';
						}
						else{
							#多雲 陰 霧V
							return '20';
						}
					}
					else if($mine){#雷
						#多雲 陰 雷V
						return '19';
					}
					else{
						#多雲 陰
						return '20';
					}
				}
				else if($rain){#雨
					#多雲 雨
					if($fog){#霧
						#多雲 雨 霧
						if($mine){#雷
							#多雲 雨 霧 雷V
							return '21';
						}
						else{
							#多雲 雨 霧V
							return '22';
						}
					}
					else if($mine){#雷
						#多雲 雨 雷V
						return '21';
					}
					else{
						#多雲 雨V
						return '22';
					}
				}
				else if($fog){#霧
					# 多雲 霧
					if($mine){#雷
						# 多雲 霧 雷V
						return '23';
					}
					else{
						# 多雲 霧V
						return '24';
					}
				}
				else if($mine){#雷
					#多雲 雷V
					return '23';
				}
				else{
					#多雲V
					return '24';
				}
			}
			else if($yin){#陰
				if($rain){#雨
					#陰 雨
					if($fog){#霧
						#陰 雨 霧
						if($mine){#雷
							#陰 雨 霧 雷V
							return '25';
						}
						else{
							#陰 雨 霧V
							return '26';
						}
					}
					else if($mine){#雷
						#陰 雨 雷V
						return '25';
					}
					else{
						#陰 雨V
						return '26';
					}
				}
				else if($fog){#霧
					#陰 霧
					if($mine){#雷
						#陰 霧 雷V
						return '27';
					}
					else{
						#陰 霧V
						return '28';
					}
				}
				else if($mine){#雷
					#陰 雷V
					return '27';
				}
				else{
					#陰V
					return '28';
				}
			}
			else if($rain){#雨
				if($fog){#霧
					#雨* 霧
					if($mine){#雷
						#雨 霧 雷(一片雲)V
						return '29';
					}
					else{
						#雨 霧(一片雲)V
						return '30';
					}
				}
				else if($mine){#雷
					#雨 雷(一片雲)V
					return '29';
				}
				else{
					#雨(一片雲)V
					return '30';
				}
			}
			else if($fog){#霧
				if($mine){#雷
					#霧 雷V
					return '31';
				}
				else{
					#霧V
					return '24';
				}
			}
			else if($mine){#雷(一片雲)V
				return '31';
			}
			else{
				$weatherD['ImgCode'] = '0';
			}
			#return 00;
			/*					
			if($sun){}
			if($cloudy){}
			if($yin){}
			if($rain){}
			if($fog){}
			if($mine){}
			*/
		}
		else{
			return null;
		}
	}
	
}

<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/lineMessagi/{request}', 'LineHookController@hooks');


//首頁
Route::get('/', 'TkoindexController@Tkoindex');

//公車首頁
Route::get('/Bus', 'TkoBusLineController@Busindex');
Route::get('/Bus/{id}', 'TkoBusLineController@BusLine');
//公車即時動態
Route::get('/BusCon/{id}', 'TkoBusLineController@BusConinTime');
Route::get('/reGetBusTime/{id}/{type}', 'TkoBusLineController@reGetBusTime');
Route::get('/BusConT/{id}', 'TkoBusLineController@BConTime');

//捷運首頁
Route::get('/Mrt', 'TkoMrtController@Mrtindex');
Route::get('/Mrt/{id}', 'TkoMrtController@MrtLine');
Route::get('/MrtConn/{id}/{type}', 'TkoMrtController@MrtLineConn');
//輕軌即時動態
Route::get('/LRTTime/{ID}/{type}', 'TkoMrtController@getLRTTime');

//CityBike首頁
Route::get('/Bike', 'TkoCityBikeController@CityBikeindex');
Route::get('/Bike/{id}/{type?}', 'TkoCityBikeController@CityBikeLine');
Route::get('/BikeConn/{id}', 'TkoCityBikeController@BikeCon');

//台灣鐵路 
Route::get('/TaiwanTRA', 'TaiwanTRAController@TaiwanTRAindex');
Route::get('/TaiwanTRA/TTrastationd/{id}', 'TaiwanTRAController@TaiwanTrastationd');
// Route::get('/TaiwanTRA/TTRAD/{seleStr?}/{stationID?}/{str}', 'TaiwanTRAController@TTRALineD');
Route::get('/TaiwanTRA/TRAD/{seleStr?}/{stationID?}/{str}', 'TaiwanTRAController@TRAD');
Route::get('/TaiwanTRA/Trastationd/{id}', 'TaiwanTRAController@Trastationd');

Route::get('/counties/{id?}', 'TaiwanTRAController@Counties');



Route::any('/@@123', 'TkoindexController@mysqlT');
Route::get('hello', function(){
	return 'hello: Y'; 
	#return 'ID: '.$id.' <br>dataType: '.gettype($id); 
});
Route::post('/postT', 'HomeController@postTest');
Route::get('/sysinfo', function(){
	echo phpinfo();
});
/*
Route::post('/postT', function ($id='') {
	return 'ID: '.$id; 
	#return 'ID: '.$id.' <br>dataType: '.gettype($id); 
});
*/
/*
Route::match(['get', 'post'], '/postT', function(){
	#return 'ID: '.$id.' <br>dataType: '.gettype($id); 
	if(json_decode(json_encode($id))->id=="123"){
		return 'Y';
	}
	else{
		return "--";
	}
	return "postT: Y";
});
*/


#Route::GET('/botController/{text}', 'TkoBusLineController@botM');
#Route::POST('/botController', 'TkoBusLineController@botM');

Route::GET('/botController/{retype}/{text?}/{uId?}/{uName?}/{uImgURL?}/{uTitleMessage?}', 'TkoBusLineController@botM');
Route::GET('/botUDSet/{uId?}/{uName?}/{uImgURL?}/{uTitleMessage?}', 'TkoBusLineController@botUDSet');
#Route::GET('/botController/{retype}/{text?}/{uId?}/{uName?}/{uImgURL?}/{uTitleMessage?}', function(){return '+++';});
Route::GET('/botUController/{uId}/{uName}/{uImgURL}/{uTitleMessage}', 'TkoBusLineController@botU');

#Route::GET('/botM/{text}', 'BotController@botM');
Route::POST('/botM', 'BotController@botM');


Route::get('/p2/{id}', function ($id='') {
    if($id!=null||$id!=''){
        return $id;
    }
    else{
        return '---';
    }
    // return '----';
});

Route::get('/tryget/{id?}', function ($id='') {
    if($id>=0){
        return $id.' is number';
    }
    else if($id!=''){
        return $id.' is string';
    }
    else{
        return 'Err';
    }
    // return '----';
});

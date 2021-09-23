<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/**App API */
//首頁及設定畫面取得版本資料
Route::get('/AppDataV/{Weather?}', 'AppAPIController@AppDataV');
//取的版本號查詢
Route::get('/cheVer/{sele}/{str}', 'AppAPIController@cheVer');
//氣象查詢
Route::get('/getWeather/{sele}/{chS}/{chT}', 'curlWeathersController@getWeathers');

//查詢公車即時動態
Route::get('/busConinTime/{busId}/{calss}', 'busConinCurlController@ConinTime');
//查詢捷運即時動態
Route::get('/getMRTTime/{sele}/{str}', 'mrtConinCurlController@getMRTTime');
//查詢輕軌即時動態
Route::get('/LRTTime/{sele}/{str}', 'lrtConinCurlController@getLRTTime');
//查詢YouBike即時動態
Route::get('/BikeAvailable/{sele}/{str}', 'bikeConinCurlController@getBike');
//查詢台鐵站台即時動態
Route::get('/TRALineD/{seleStr}/{stationID}', 'traConinCurlController@TRALineD');
//查詢台鐵站台今日靠站列車資訊
Route::get('/TRALineD/{seleStr}/{stationID}', 'traConinCurlController@TRALineD');






Route::post('/postT', 'AnimalController@postTest');

Route::middleware('auth:api')->group(function () {
    return '+++';
});

Route::post('animals/{animal}/postTest', 'Api\AnimalController@postTest');
 
Route::apiResource('animals', 'Api\AnimalController');


#Route::GET('/botController/{type}/{text?}/{uId?}/{uName?}/{uImgURL?}/{uTitleMessage?}', 'TkoBusLineController@botM');
Route::GET('/botController/{type}/{text?}/{uId?}/{uName?}/{uImgURL?}/{uTitleMessage?}', function(){return $type;});
#bot sele  dele  update  insert
Route::GET('/botMessageSele/{u_text}/{re_text?}/{reType}/{bImg}/{sImg?}/{oc?}/{ps?}', function(){return $type;});
Route::GET('/botMessageDele/{u_text}/{re_text?}/{reType}/{bImg}/{sImg?}/{oc?}/{ps?}', function(){return $type;});
Route::GET('/botMessaheUpdate/{u_text}/{re_text?}/{reType}/{bImg}/{sImg?}/{oc?}/{ps?}', function(){return $type;});
Route::GET('/botMessageInsert/{u_text}/{re_text?}/{reType}/{bImg}/{sImg?}/{oc?}/{ps?}', function(){return $type;});

#Route::GET('/botController/{text}', 'HomeController@botM');





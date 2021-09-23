<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class AnimalController extends Controller{
	
	public function postTest(Request $request){
		#$re=$request->input('name');
		$re=$request->input('message');
		return 'hello world';//'request.name'.$re->input('text');
	}
}

?>
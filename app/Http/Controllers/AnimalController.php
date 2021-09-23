<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimalController extends Controller{
	
	public function postTest(Request $cc){
		#$reT = $cc->input('id');
		return 'request.id: '.$cc->input('mobile');
	}
}

?>
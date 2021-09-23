<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TkoindexController extends Controller
{
    public function index()
	{
		return '私は髙雄がすきです';
	}

    public function Tkoindex()
	{
		$data = ['h'=>'私は髙雄がすきです'];
		$h = '私は髙雄がすきです';
		return view('TKOindex');//compact('h3'));,  $data
	}

   public function mysqlT(){
		$conn = mysqli_connect('localhost', '@id14884914_tkogo1219', '1989@Sweet1219');
		if(!$conn){
			die('<h3>mysqi conn error...</h3>'.mysqli_connect_error());
		}
		else{
			echo 'Sussecc.';
		}
	}
}

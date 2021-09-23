<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

#use DB;
use PDO;
use App\Http\Controllers\Controller;


use App\User;
use App\Repositories\UserRepository;

class BotController extends Controller
{
	public function botM(Request $text){
		#$this->db = new PDO('mysql:host=localhost;dbname=id14884914_tkogo;', 'id14884914_tkogo1219', '1989@Sweet1219');
		#$messages = $this->db->query("select * from botMessage where u_text='".$text."'";
		#$messages = DB::select('select * from botMessage where reType=?', ['img']);
		return '$text';
	}
}
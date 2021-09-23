<?php
	php artisan make:controller --resource NewsController

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;

	class Tko extends Controller
	{
	    //顯示所有資料
	    public function index()
	    {
	    	Route::get('/', function () {
		    	$data = ['home'=>'旅遊台灣，首選高雄！','ahref'=>'<a href="#.php">超連結</a>'];
		    	return view::make('tko',$data);
		    });
	        //
	    }

	    //新增一筆資料
	    public function create()
	    {
	        //
	    }

	    //儲存資料
	    public function store(Request $request)
	    {
	        //
	    }

	    //顯示一筆資料
	    public function show($id)
	    {
	        //
	    }

	    //編輯一筆資料
	    public function edit($id)
	    {
	        //
	    }

	    //更新一筆資料
	    public function update(Request $request, $id)
	    {
	        //
	    }

	    //刪除一筆資料
	    public function destroy($id)
	    {
	        //
	    }
	}

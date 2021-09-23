<?php
namespace Modules\Line\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;

class LineHookController extends BaseController
{
    public function hooks(Request $request)
    {
        $params = $request->all();
        logger(json_encode($params, JSON_UNESCAPED_UNICODE));
        return response('hello world', 200);
    }
}
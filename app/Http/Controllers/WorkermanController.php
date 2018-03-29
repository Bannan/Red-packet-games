<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GatewayClient\Gateway;

class WorkermanController extends Controller
{
    public function index()
    {
        return view('soket');
    }

    public function send(Request $request)
    {

        // 设置GatewayWorker服务的Register服务ip和端口
        Gateway::$registerAddress = '0.0.0.0:1238';
        $request = $request->All();
        //绑定token链接
        Gateway::bindUid($request['client_id'], $request['token']);

        Gateway::sendToAll(json_encode($request));

    }

}

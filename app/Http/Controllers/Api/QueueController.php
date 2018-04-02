<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckToken;
use App\Jobs\RedAllot;
use App\Models\User;

class QueueController extends Controller
{
    public function index(CheckToken $request)
    {
        // 查找当前参与游戏的用户
        $users = User::whereIn('api_token', $request->get('tokens'))->get();

        // 放入红包金额分配队列
        $this->dispatch(new RedAllot($users, $request->get('rid'), $request->get('type')));

        return ['message' => '已成功加入队列，等待金额处理完成。'];
    }
}

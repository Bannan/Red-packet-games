<?php

namespace App\Http\Controllers;

use App\Rules\Mobile;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    /**
     * 发送注册短信
     * @param Request $request
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'mobile' => ['required', new Mobile(), 'unique:users']
        ]);
        return send_sms_code(config('sms.templates.register'), $request->mobile, __FUNCTION__);
    }

    /**
     * 发送重置密码短信
     * @param Request $request
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|min:4',
            'mobile' => ['required', new Mobile(), 'exists:users']
        ]);
        return send_sms_code(config('sms.templates.register'), $request->mobile, __FUNCTION__);
    }
}

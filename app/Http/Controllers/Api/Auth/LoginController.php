<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 验证字段
     * @return string
     */
    public function username()
    {
        return 'mobile';
    }

    /**
     * 认证完成
     * @param Request $request
     * @param $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->fill([
            'api_token' => str_random(64),
        ])->save();
        return $user;
    }

    /**
     * 退出登录
     * @param Request $request
     * @return array
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        return ['message' => '用户已退出'];
    }

    /**
     * 发送登录响应
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Mobile;
use App\Rules\SmsCode;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /**
     * 重置会员密码
     * @param Request $request
     * @return array
     */
    public function reset(Request $request)
    {
        $data = $this->validate($request, [
            'mobile' => ['required', new Mobile, 'exists:users'],
            'sms_code' => ['required', 'min:4', new SmsCode],
            'password' => 'required|string|min:6|confirmed',
            'safety_code' => 'required|string|min:4|confirmed',
        ]);
        User::where('mobile', $request->get('mobile'))->fill([
            'password' => bcrypt($data['password']),
            'safety_code' => bcrypt($data['safety_code']),
        ])->save();

        return ['message' => '密码已重置完成'];
    }
}

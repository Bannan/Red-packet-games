<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Rules\SmsCode;
use App\Rules\Mobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 验证器
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'captcha' => 'required|captcha',
            'nickname' => 'required',
            'mobile' => ['required', 'string', new Mobile, 'unique:users'],
            'parent_id' => 'required|numeric|exists:users,id',
            'password' => 'required|string|min:6|confirmed',
            'safety_code' => 'required|string|min:4|confirmed',
            'code' => ['bail', 'required', 'string', 'min:4', new SmsCode('register')],
        ]);
    }

    /**
     * 注册用户放入数据库
     * @param array $data
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    protected function create(array $data)
    {
        return User::create([
            'nickname' => $data['nickname'],
            'mobile' => $data['mobile'],
            'parent_id' => $data['parent_id'],
            'password' => bcrypt($data['password']),
            'safety_code' => bcrypt($data['safety_code']),
            'api_token' => str_random(64),
        ]);
    }

    /**
     * 注册后
     * @param Request $request
     * @param $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return $user;
    }
}

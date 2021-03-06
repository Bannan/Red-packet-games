<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Rules\SmsCode;
use App\Rules\Mobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * 验证器
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nickname' => 'required',
            'mobile' => ['required', 'string', new Mobile, 'unique:users'],
            'parent_id' => 'required|numeric|exists:users,id',
            'password' => 'required|string|min:6|confirmed|different:safety_code',
            'safety_code' => 'required|string|min:4|confirmed',
            'sms_code' => ['bail', 'required', 'string', 'min:4', new SmsCode],
        ]);
    }

    /**
     * 注册用户放入数据库
     * @param array $data
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $parent = User::find($data['parent_id']);
            $link_ids = explode(',', $parent->link_id);
            $link = collect($link_ids)->push($data['parent_id'])->unique()->sort()->implode(',');
            $parent->update(['link_id' => trim($link, ',')]);

            return User::create([
                'nickname' => $data['nickname'],
                'mobile' => $data['mobile'],
                'parent_id' => $data['parent_id'],
                'password' => bcrypt($data['password']),
                'safety_code' => bcrypt($data['safety_code']),
                'api_token' => str_random(64),
            ]);
        });
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

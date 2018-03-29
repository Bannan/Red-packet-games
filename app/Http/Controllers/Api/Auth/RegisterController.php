<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Rules\Code;
use App\Rules\Mobile;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
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
     * @return mixed
     */
    public function captcha()
    {
        /*
        $phraseBuilder = new PhraseBuilder(3, '0123456789');
        $builder = new CaptchaBuilder(null, $phraseBuilder);
         $builder->build("100","100");
        //header('Content-type: image/jpeg');
        dd(['img'=>$builder->output(),"asd"=>123123]);
        */
        //$phraseBuilder = new PhraseBuilder(3, '0123456789');

        $builder = new CaptchaBuilder();
        $builder->build();
        $code = rand(1000, 1100);
        $builder->save("test/" . $code . '.jpg');
        //Cache::put($ip . $code, $builder->getPhrase(), 1);
        return ["img_src"=>"/test/" . $code . ".jpg", "code" => $code];
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
            'mobile' => ['required', 'string', new Mobile, 'unique:users'],
            'parent_id' => 'required|numeric|exists:users,id',
            'password' => 'required|string|min:6|confirmed',
            'safety_code' => 'required|string|min:4|confirmed',
            'code' => ['bail', 'required', 'string', 'min:4', new Code('register')],
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

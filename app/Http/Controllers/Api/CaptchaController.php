<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CaptchaController extends Controller
{
    /**
     * 生成图形验证码
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request)
    {
        $builder = new CaptchaBuilder;
        $builder->build();

        $key = sprintf('%s-%s', $request->getClientIp(), $builder->getPhrase());

        Cache::put($key, $builder->getPhrase(), 10);

        return response($builder->get(), 200, ['Content-type' => 'image/jpeg']);
    }
}

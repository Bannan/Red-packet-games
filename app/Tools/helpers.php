<?php

use App\Models\Sms;
use Overtrue\EasySms\EasySms;

if (!function_exists('send_sms_code')) {
    function send_sms_code($template, $mobile, $fn)
    {
        $ip = Request::getClientIp();
        if (Cache::has($ip . 'sms_cannot_send')) {
            return response(['errors' => ['message' => '发送过于频繁，请稍后再试。']], 422);
        }
        if ($sms_max = (int)config('sms.send_max')) {
            $num = Sms::where('mobile', $mobile)->whereDate('created_at', today())->count();
            if ($num >= $sms_max) {
                return response(['errors' => ['message' => '今天短信发送次数过多，请明天再试。']], 422);
            }
        }
        $code = random_int(10000, 99999);
        $message = ['template' => $template, 'data' => ['code' => $code]];
        /*
            if (env('APP_DEBUG')) {
                session()->put($fn, $code);
                Cache::put('sms_cannot_send', true, 1);
                Sms::create(['mobile' => $mobile, 'vars' => $message, 'result' => 'debug', 'op' => $fn]);
                return ['message' => '短信发送成功。'];
            }
        */
        try {
            $easySms = new EasySms(config('sms.send_config'));
            $res = $easySms->send($mobile, $message);
            Sms::create(['mobile' => $mobile, 'vars' => $message, 'result' => $res, 'op' => $fn]);
            $arr = head($res);
            if ($arr['status'] === 'success') {
                Cache::put($ip . $fn, $code, 10);
                Cache::put($ip . 'sms_cannot_send', true, 1);
                return ['message' => '短信发送成功。'];
            }
        } catch (\Exception $exception) {
            return response(['message' => '短信发送失败。'], 422);
        }
    }
}
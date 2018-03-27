<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CaptchaController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->method() === 'POST') {
            $validator = Validator::make($request->all(), ['captcha' => 'required|captcha']);
            if ($validator->fails()) {
                echo '<p style="color: #ff0000;">Incorrect!</p>';
            } else {
                echo '<p style="color: #00ff30;">Matched :)</p>';
            }
        }

        $form = '<form method="post" action="/api/captcha">'
            . '<input type="hidden" name="_token" value="' . csrf_token() . '">'
            . '<p><img src="/captcha" alt="captcha"></p>'
            . '<p><input type="text" name="captcha"></p>'
            . '<p><button type="submit" name="check">Check</button></p>'
            . '</form>';
        return $form;
    }
}

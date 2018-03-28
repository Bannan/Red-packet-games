<?php

namespace App\Http\Controllers;

use App\Rules\Mobile;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'mobile' => ['required', new Mobile(), 'unique:users']
        ]);
        return send_sms_code(config('sms.templates.register'), $request->mobile, __FUNCTION__);
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|min:4',
            'mobile' => ['required', new Mobile(), 'exists:users']
        ]);
        return send_sms_code(config('sms.templates.register'), $request->mobile, __FUNCTION__);
    }
}

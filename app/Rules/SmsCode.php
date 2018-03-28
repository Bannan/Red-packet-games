<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class SmsCode implements Rule
{

    /**
     * SmsCode constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $key = sprintf('%s-%s', Request::get('mobile'), $value);
        if (Cache::get($key) == $value) {
            Cache::forget($key);
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '手机验证码 错误。';
    }
}

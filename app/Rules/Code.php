<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class Code implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 验证输入的图形验证码
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function passes($attribute, $value)
    {
        $key = sprintf('%s-%s', Request::getClientIp(), $value);
        if (Cache::get($key) == $value) {
            Cache::delete($key);
            return true;
        };

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '验证码 错误。';
    }
}

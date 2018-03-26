<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Code implements Rule
{
    private $op;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(String $op)
    {
        $this->op = $op;
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
        if (session()->get($this->op) == $value) {
            session()->forget($this->op);
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
        return '验证码 错误。';
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumberMax implements Rule
{

    private $valueMax;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($valueMax)
    {
        //
        $this->valueMax=$valueMax;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        return $value<=$this->valueMax;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute phải nhỏ hơn '.$this->valueMax;
    }
}

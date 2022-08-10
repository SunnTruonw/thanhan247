<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NumberMin implements Rule
{

    private $valueMin;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($valueMin)
    {
        //
        $this->valueMin=$valueMin;
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
        return $value>=$this->valueMin;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute phải lớn hơn '.$this->valueMin;
    }
}

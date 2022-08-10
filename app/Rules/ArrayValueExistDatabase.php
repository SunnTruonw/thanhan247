<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Components\CheckExistDatabase;
class ArrayValueExistDatabase implements Rule
{

    private $model;
    private $field;
    private $fieldValue;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model,$field,$fieldValue)
    {
        //
        $this->model=$model;
        $this->field=$field;
        $this->fieldValue=$fieldValue;
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
        $checkExit=new CheckExistDatabase();
        return $checkExit->CheckArrayValueExistDatabase( $this->model,$this->field,$this->fieldValue);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute không tồn tại';
    }
}

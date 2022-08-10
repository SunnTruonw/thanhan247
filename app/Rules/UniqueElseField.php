<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueElseField implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $model;
    private $field;
    private $fieldValue;

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
        $queryResult= $this->model->where([
            [$this->field,"<>",$this->fieldValue],
            [$attribute,"=",$value]
        ])->exists();

        if($queryResult){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {

        return   " :attribute   đã tồn tại";
    }
}

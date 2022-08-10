<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Point;
class DrawPoint implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $point;
    public function __construct()
    {
        //
        $this->point=new Point();
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
       $user = auth()->guard('web')->user();

       return $this->point->sumPointCurrent($user->id)>=(int)$value&&(int)$value>0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $user = auth()->guard('web')->user();
        return ':attribute phải nhỏ  hơn số điểm bạn hiện có ' .$this->point->sumPointCurrent($user->id) . ' và > 0';
    }
}

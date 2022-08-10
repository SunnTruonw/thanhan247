<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Point;
use App\Helper\CartHelper;
class PointLessTotalValueProduct implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $point;
    private $totalPrice;
    public function __construct()
    {
        //
        $this->point=new Point();
        $cart = new CartHelper();
        $this->totalPrice =  $cart->getTotalPrice();
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
       return pointToMoney($value) <= $this->totalPrice;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $user = auth()->guard('web')->user();
        return ':attribute phải nhỏ  hơn tổng giá trị đơn hàng' .$this->totalPrice . ' và > 0';
    }
}

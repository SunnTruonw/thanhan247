<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
class CheckKeyByOrder implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $user;
    private $err;
    public function __construct()
    {
        //
        $this->user=new User();
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
        if( $this->user->where([
            'order'=>$value,
        ])->exists()){
            if($this->user->where([
                'active'=>1,
                'order'=>$value,
            ])->exists()){
                return true;
            }else{
                $this->err="STT của tài khoản đã bị khóa";
                return false;
            }
        }else{
            $this->err="STT không tồn tại";
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->err;
    }
}

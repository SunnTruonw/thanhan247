<?php

namespace App\Models\ShippingFee;

use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    protected $table = 'shipping_fees';

    protected $fillable = [
        'number_sign',
        'total_money'
    ];
}

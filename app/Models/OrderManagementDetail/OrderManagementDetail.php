<?php

namespace App\Models\OrderManagementDetail;

use App\Models\OrderManagementDetail\Traits\OrderDetailRelationship;
use Illuminate\Database\Eloquent\Model;

class OrderManagementDetail extends Model
{
    use OrderDetailRelationship;
    
    protected $table = 'order_management_details';

    protected $fillable = [
        'order_code',
        'product_title',
        'product_image',
        'product_code',
        'product_mass',
        'product_qty',
        'product_money'
    ];
}

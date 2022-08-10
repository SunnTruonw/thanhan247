<?php

namespace App\Models\OrderManagement;

use App\Models\Condition\Condition;
use App\Models\User;
use App\Models\OrderManagement\Traits\OrderManagementRelationship;
use App\Models\Traits\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Model;

class OrderManagement extends Model
{
    use OrderManagementRelationship;
    use EloquentFilterTrait;

    protected $table = 'order_managements';

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total_money',
        'user_id',
        'file',
        'shipping_fee',
        'real_money',
        'condition_id',
        'note',
        'note2',
        'payment_id',
        'shipper_id',
        'package_high',
        'package_wide',
        'package_long',
        'package_sum_mass',
        'debt',
        'refund'
    ];



    const PER_PAGE = 10;
    const FIELDS_ALLOW_QUERY = [
        'search' => [
            'attribute' => [
                'order_code'  => 'order_managements.order_code',
                'customer_name' => 'order_managements.customer_name',
            ],
            'operator' => 'like',
        ],
        'id' => [
            'attribute' => ['id' => 'order_managements.id'],
            'operator' => 'like',
        ],
        'condition_id' => [
            'attribute' => ['condition_id' => 'order_managements.condition_id'],
            'operator' => 'like',
        ],
    ];

    const ORDER_DEFAULT = ['order_managements.created_at', 'desc'];

    const UNPAID = 0;
    const PAID = 1;
    const NOT_REFUNDED = 0;
    const REFUNDED = 1;

    // public function users()
    // {
    //     $this->belongsTo(User::class, 'user_id', 'id');
    // }
}

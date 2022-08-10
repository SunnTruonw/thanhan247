<?php

namespace App\Models\Condition;

use App\Models\Condition\Traits\ConditionRelationship;
use App\Models\OrderManagement\OrderManagement;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use ConditionRelationship;

    protected $table = 'conditions';

    const ORDER_COMPLETE = 5;
    // const ORDER_BEING_TRANSPORTED= 2;
    // const ORDER_DELIVERING = 3;
    // const ORDER_DELIVERED = 4;
    const ORDER_DESTROY = 6;
    const ORDER_LOST = 7;


    public function condition()
    {
        return $this->hasMany(OrderManagement::class, 'condition_id', 'id');
    }
}

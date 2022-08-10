<?php
namespace App\Models\OrderManagementDetail\Traits;

use App\Models\OrderManagement\OrderManagement;

trait OrderDetailRelationship
{
     /**
     * Get the order associated with the payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function order()
    {
        return $this->belongsTo(OrderManagement::class, 'order_code', 'order_code');
    }
}
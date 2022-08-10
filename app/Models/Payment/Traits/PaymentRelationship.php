<?php
namespace App\Models\Payment\Traits;

use App\Models\OrderManagement\OrderManagement;

trait PaymentRelationship
{
     /**
     * Get the order associated with the payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function order()
    {
        return $this->hasMany(OrderManagement::class, 'payment_id', 'id');
    }
}
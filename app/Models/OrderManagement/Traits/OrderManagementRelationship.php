<?php
namespace App\Models\OrderManagement\Traits;

use App\Models\Condition\Condition;
use App\Models\OrderManagementDetail\OrderManagementDetail;
use App\Models\Payment\Payment;
use App\Models\Shipper\Shipper;
use App\Models\User;

trait OrderManagementRelationship
{
    /**
     * Get the user associated with the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the condition associated with the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function condition()
    {
        return $this->belongsTo(Condition::class, 'condition_id', 'id');
    }

    /**
     * Get the payment associated with the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    /**
     * Get the shipper associated with the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function shipper()
    {
        return $this->belongsTo(Shipper::class, 'shipper_id', 'id');
    }

    /**
     * Get the shipper associated with the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function orderDetail()
    {
        return $this->hasMany(OrderManagementDetail::class, 'order_code', 'order_code');
    }
}
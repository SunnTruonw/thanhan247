<?php
namespace App\Models\Shipper\Traits;

use App\Models\OrderManagement\OrderManagement;

trait ShipperRelationship
{
    /**
     * Get the order associated with the shipper
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(OrderManagement::class, 'shipper_id', 'id');
    }
}
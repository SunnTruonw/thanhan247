<?php
namespace App\Models\Condition\Traits;

use App\Models\OrderManagement\OrderManagement;

trait ConditionRelationship
{
    /**
     * Get the order associated with the codition
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(OrderManagement::class, 'condition_id', 'id');
    }
}
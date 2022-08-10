<?php

namespace App\Models\Shipper;

use App\Models\Shipper\Traits\ShipperRelationship;
use App\Models\Traits\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use ShipperRelationship;
    use EloquentFilterTrait;

    protected $table = 'shippers';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'license_plates',
        'salary',
        'delivery_order'
    ];

    const PER_PAGE = 10;
    const FIELDS_ALLOW_QUERY = [
        'search' => [
            'attribute' => [
                'email'  => 'shippers.email',
                'address' => 'shippers.address',
                'license_plates' => 'shippers.license_plates',
            ],
            'operator' => 'like',
        ],
        'id' => [
            'attribute' => ['id' => 'shippers.id'],
            'operator' => 'like',
        ],
        'name' => [
            'attribute' => ['name' => 'shippers.name'],
            'operator' => 'like',
        ],
    ];

    const ORDER_DEFAULT = ['shippers.created_at', 'desc'];
}

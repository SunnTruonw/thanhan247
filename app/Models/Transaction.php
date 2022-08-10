<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    //
    use SoftDeletes;
    protected $table = "transactions";
    protected $guarded = [];
    // các trạng thái đơn hàng
    // 1 đặt hàng thành công
    // 2 tiếp nhận đơn hàng
    // 3 Đang vận chuyển
    // 4 Hoàn thành
    // 0 Đơn hàng đã hủy
    public $listStatus = [
        1 => [
            'status' => 1,
            'name' => 'Chưa sử lý',
        ],
        2 => [
            'status' => 2,
            'name' => 'Nhận đơn',
        ],
        3 => [
            'status' => 3,
            'name' => 'Đang vận chuyển',
        ],
        4 => [
            'status' => 4,
            'name' => 'Hoàn thành',
        ],
        -1 => [
            'status' => -1,
            'name' => 'Hủy bỏ',
        ],
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, "transaction_id", "id");
    }
    public function stores()
    {
        return $this->hasMany(Store::class, "transaction_id", "id");
    }
    public function products()
    {
        return $this
            ->belongsToMany(Product::class, Order::class, 'transaction_id', 'product_id')
            ->withTimestamps();
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function setting($ht='httt')
    {
        return $this->belongsTo(Setting::class, $ht, 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function district()
    {
        return  $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id', 'id');
    }
}

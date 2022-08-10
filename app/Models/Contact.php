<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
class Contact extends Model
{
    //
    // use SoftDeletes;
    protected $table = "contacts";
    protected $guarded = [];
    // các trạng thái liên hệ
    // 1 Đã nhận được thông tin đang chờ duyệt
    // 2 Quản trị viên đã xem
    // 3
    // 4
    // 0
    public $listStatus = [
        1 => [
            'status' => 1,
            'name' => 'Chưa xử lý',
        ],
        2 => [
            'status' => 2,
            'name' => 'Hoàn thành',
        ],
        -1 => [
            'status' => -1,
            'name' => 'Hủy bỏ',
        ],
    ];
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
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

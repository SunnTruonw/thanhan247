<?php

namespace App\Models\CsvManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CsvManagement extends Model
{
    protected $table = 'csv_managements';

    protected $fillable = [
        'file_name',
        'status',
        'user_id'
    ];

    const PER_PAGE = 10;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

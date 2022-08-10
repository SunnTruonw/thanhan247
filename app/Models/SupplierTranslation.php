<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierTranslation extends Model
{
    //
    protected $table = "supplier_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}

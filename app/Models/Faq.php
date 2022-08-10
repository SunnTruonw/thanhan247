<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    //
    protected $table = "faqs";
    protected $guarded = [];
    protected $appends = ['slug_full'];
    public function category()
    {
        return $this->belongsTo(CategoryProgram::class, 'origin_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function answers()
    {
        return $this->hasMany(FaqAnswer::class, 'faq_id', 'id');
    }
    public function getSlugFullAttribute()
    {
        return makeLinkFaq('faq',$this->attributes['id'],$this->attributes['slug']);
    }
    public function follows()
    {
        return $this->hasMany(FaqFollow::class, 'faq_id', 'id');
    }
}

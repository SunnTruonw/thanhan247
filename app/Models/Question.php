<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;

class Question extends Model
{
    //
    protected $table = "questions";
    protected $guarded = [];
    protected $appends = ['slug_full', 'title', 'answer', 'name'];

    // tạo thêm thuộc tính slug_full
    public function getSlugFullAttribute()
    {
        return makeLink('question', $this->attributes['id']);
    }

    // tạo thêm thuộc tính name
    public function getNameAttribute()
    {
        //  dd($this->translationsLanguage()->first()->name);
        return optional($this->translationsLanguage()->first())->name;
    }
    // tạo thêm thuộc tính name
    public function getTitleAttribute()
    {
        //  dd($this->translationsLanguage()->first()->name);
        return optional($this->translationsLanguage()->first())->title;
    }
    // tạo thêm thuộc tính đáp án
    public function getAnswerAttribute()
    {
        //  dd($this->translationsLanguage()->first()->name);
        return optional($this->translationsLanguage()->first())->answer;
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class, 'question_id', 'id');
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function translationsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this->hasMany(QuestionTranslation::class, "question_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(QuestionTranslation::class, "question_id", "id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;
class QuestionAnswer extends Model
{
    //
    protected $table="question_answers";
    protected $guarded = [];
    protected $appends = [ 'name'];
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    public function question(){
        return $this->belongsTo(Question::class,'question_id','id');
    }

      // tạo thêm thuộc tính name
      public function getNameAttribute()
      {
          //  dd($this->translationsLanguage()->first()->name);
          return optional($this->translationsLanguage()->first())->name;
      }
    public function translationsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this->hasMany(QuestionAnswerTranslation::class, "answer_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(QuestionAnswerTranslation::class, "answer_id", "id");
    }
}

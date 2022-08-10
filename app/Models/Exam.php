<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;
class Exam extends Model
{
    protected $table = "exams";
    protected $guarded = [];
    // public $fillable =['name'];

  //  protected $appends = ['slug_full','name','slug','description','description_seo','keyword_seo','title_seo','content','language'];
    public function getSlugFullAttribute()
    {
        return makeLinkExam('exam', $this->attributes['id'], $this->getSlugAttribute());
    }

    // tạo thêm thuộc tính name
    public function getNameAttribute()
    {
        //  dd($this->translationsLanguage()->first()->name);
        return optional($this->translationsLanguage()->first())->name;
    }

    // tạo thêm thuộc tính slug
    public function getSlugAttribute()
    {
        return optional($this->translationsLanguage()->first())->slug;
    }
    // tạo thêm thuộc tính description
    public function getDescriptionAttribute()
    {
        return optional($this->translationsLanguage()->first())->description;
    }
    // tạo thêm thuộc tính description_seo
    public function getDescriptionSeoAttribute()
    {
        return optional($this->translationsLanguage()->first())->description_seo;
    }

    // tạo thêm thuộc tính keyword_seo
    public function getKeywordSeoAttribute()
    {
        return optional($this->translationsLanguage()->first())->keyword_seo;
    }

    // tạo thêm thuộc tính title_seo
    public function getTitleSeoAttribute()
    {
        return optional($this->translationsLanguage()->first())->title_seo;
    }

    // tạo thêm thuộc tính content
    public function getContentAttribute()
    {
        return optional($this->translationsLanguage()->first())->content;
    }
    // tạo thêm thuộc tính content
    public function getLanguageAttribute()
    {
        return optional($this->translationsLanguage()->first())->language;
    }

    // get category by relationship 1 - nhieu
    // 1 category_posts có nhiều post
    // 1 post có 1 category_posts
    // use belongsTo để truy xuất ngược từ post lấy data trong table category
    public function category()
    {
        return $this->belongsTo(CategoryExam::class, 'category_id', 'id');
    }

    // get category by relationship nhiều - 1
    public function getAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    // lấy câu hỏi
    public function questions()
    {
        return $this->hasMany(Question::class, 'exam_id', 'id');
    }
    // lay danh sach bai lam cua user
    public function tasks()
    {
        return $this->hasMany(Task::class, 'exam_id', 'id');
    }

    public static function getHtmlOption($parentId = "")
    {
        $data = self::all();
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }

    public function translationsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this->hasMany(ExamTranslation::class, "exam_id", "id")->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(ExamTranslation::class, "exam_id", "id");
    }
}

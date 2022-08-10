<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
class Post extends Model
{
    //use SoftDeletes;
    protected $table = "posts";
    public $parentId = "parent_id";
    protected $guarded = [];
    // public $fillable =['name'];

   // protected $appends = ['slug_full', 'name', 'slug', 'description', 'description_seo', 'keyword_seo', 'title_seo', 'content', 'language'];
    /**
     * status 1 đã đăng
     * 2 gửi duyệt
     * 3 đã duyệt
     * 4 Đã trả lại
     * 5 sửa bài viết đã trả lại
     */
   public function getSlugFullAttribute()
   {
       if(isset($this->slugL)){
           return makeLinkPost('post', $this->id, $this->slugL);
       }else{
        return makeLink('home');
       }
   }

   public function getViewAoAttribute()
   {
       return $this->view+$this->view_start;
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
        $slug=optional($this->translationsLanguage()->first())->slug;
        if(!$slug){
            $slug=optional($this->translationsLanguage(config('languages.default'))->first())->slug;
        }
        return $slug;
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
       // tạo thêm thuộc tính content 2
       public function getContent2Attribute()
       {
           return optional($this->translationsLanguage()->first())->content2;
       }
    // tạo thêm thuộc tính content
    public function getLanguageAttribute()
    {
        return optional($this->translationsLanguage()->first())->language;
    }



    // get tags by relationship nhieu-nhieu by table trung gian post_tags
    // 1 post có nhiều post_tags
    // 1 tag có nhiều post_tags
    // table trung gian post_tags chứa column post_id và tag_id
    public function tags()
    {
        return $this
            ->belongsToMany(Tag::class, PostTag::class, 'post_id', 'tag_id')
            ->withTimestamps();
    }
    public function tagsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this
            ->belongsToMany(Tag::class, PostTag::class, 'post_id', 'tag_id')
            ->withTimestamps()->where('language', '=', $language);
    }


    // get category by relationship 1 - nhieu
    // 1 category_posts có nhiều post
    // 1 post có 1 category_posts
    // use belongsTo để truy xuất ngược từ post lấy data trong table category
    public function category()
    {
        return $this->belongsTo(CategoryPost::class, 'category_id', 'id');
    }

    // get category by relationship nhiều - 1
    public function getAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    // người đăng
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    // người edit
    public function adminEdit()
    {
        return $this->belongsTo(Admin::class, 'admin_edit_id', 'id');
    }
    // người gửi duyệt
    public function adminSendDuyet()
    {
        return $this->belongsTo(Admin::class, 'admin_send_id', 'id');
    }
    // người duyệt bài
    public function adminDuyet()
    {
        return $this->belongsTo(Admin::class, 'admin_duyet_id', 'id');
    }
    // người hạ bài
    public function adminHaBai()
    {
        return $this->belongsTo(Admin::class, 'admin_habai_id', 'id');
    }
     // người trả bài
     public function adminTraBai()
     {
         return $this->belongsTo(Admin::class, 'admin_trabai_id', 'id');
     }

    // get comment by relationship nhieu-nhieu by table trung gian post_comments
    // 1 post có nhiều post_comments
    // 1 tag có nhiều post_comments
    // table trung gian post_comments chứa column post_id và tag_id
    public function comments()
    {
        return $this
            ->belongsToMany(Comment::class, PostComment::class, 'post_id', 'comment_id')
            ->withTimestamps();
    }




    public function translationsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this->hasMany(PostTranslation::class, "post_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(PostTranslation::class, "post_id", "id");
    }

    // lấy đoạn văn

    public function paragraphs()
    {
        return $this
            ->hasMany(ParagraphPost::class, 'post_id', 'id');
    }
    public function paragraphsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this
            ->hasMany(ParagraphPost::class, 'post_id', 'id')->where('language', '=', $language);
    }


    public static function mergeLanguage($selectLang=[]){
        $s='post_translations.name as nameL,
        post_translations.slug as slugL,
        post_translations.description as descriptionL,
        post_translations.description_seo as description_seoL,
        post_translations.keyword_seo as keyword_seoL,
        post_translations.title_seo as title_seoL,
        post_translations.content as contentL,
        post_translations.language as languageL
        ';
        $s2='posts.*';
        if(count($selectLang)>0){
            $s=collect($selectLang);
            $stringKey = $s->map(function ($item, $key) {
                return "post_translations." . $item." as ".$item."L";
            });
            $s=$stringKey->implode(',');
        }
        // if(count($selectMy)>0){
        //     $s2=collect($selectMy);
        //     $stringKey = $s2->map(function ($item, $key) {
        //         return "category_programs." . $item ." as ".$item;
        //     });

        //     $s2=$stringKey->implode(' ');
        // }
        return self::join('post_translations', function ($join) {
            $join->on('posts.id', '=', 'post_translations.post_id')
                ->where('post_translations.language', '=', App::getLocale());
        })
        ->select($s2,
        DB::raw($s));
    }
}

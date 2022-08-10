<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
class Product extends Model
{
    //
    //use SoftDeletes;
    protected $table = "products";
    public $parentId = "parent_id";
    // public $fillable =['name'];
    protected $guarded = [];

   // protected $appends = ['price_after_sale', 'slug_full', 'name', 'slug', 'description', 'description_seo', 'keyword_seo', 'title_seo', 'content', 'language','model','tinhtrang','baohanh','xuatsu','content1','content2','content3','content4'];
    public function getPriceAfterSaleAttribute()
    {
        if ($this->attributes['sale']) {
            return   $this->attributes['price'] * (100 - $this->attributes['sale']) / 100;
        } else {
            return $this->attributes['price'];
        }
    }
    // tạo thêm thuộc tính slug_full
    public function getSlugFullAttribute()
    {
        return makeLinkProduct('product', $this->attributes['id'], $this->getSlugAttribute());
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

    // tạo thêm thuộc tính content mô tả sản phẩm
    public function getContentAttribute()
    {
        return optional($this->translationsLanguage()->first())->content;
    }
    // tạo thêm thuộc tính content2 thông số kỹ thuật
    public function getContent2Attribute()
    {
        return optional($this->translationsLanguage()->first())->content2;
    }
    // tạo thêm thuộc tính content3 chính sách vận chuyển
    public function getContent3Attribute()
    {
        return optional($this->translationsLanguage()->first())->content3;
    }
    // tạo thêm thuộc tính content4 chính sách vận chuyển
    public function getContent4Attribute()
    {
        return optional($this->translationsLanguage()->first())->content4;
    }

    // tạo thêm thuộc tính model
    public function getModelAttribute()
    {
        return optional($this->translationsLanguage()->first())->model;
    }
    // tạo thêm thuộc tính tình trạng
    public function getTinhtrangAttribute()
    {
        return optional($this->translationsLanguage()->first())->tinhtrang;
    }

    // tạo thêm thuộc tính bảo hành
    public function getBaohanhAttribute()
    {
        return optional($this->translationsLanguage()->first())->baohanh;
    }
    // tạo thêm thuộc tính bảo hành
    public function getXuatsuAttribute()
    {
        return optional($this->translationsLanguage()->first())->xuatsu;
    }

    // tạo thêm thuộc tính content
    public function getLanguageAttribute()
    {
        return optional($this->translationsLanguage()->first())->language;
    }
    // // tạo thêm thuộc tính so sp ban dc
    // public function getNumberPayAttribute()
    // {
    //     //  dd($this);
    //     $total =  $this->stores()->whereIn('type', [2, 3])->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total;
    //     if ($total) {
    //         return $total;
    //     } else {
    //         return 0;
    //     }
    // }

    // get images by relationship 1-nhieu  1 product có nhiều images sử dụng hasMany
    public function images()
    {
        return $this->hasMany(ProductImage::class, "product_id", "id");
    }
    // get tags by relationship nhieu-nhieu by table trung gian product_tags
    // 1 product có nhiều product_tags
    // 1 tag có nhiều product_tags
    // table trung gian product_tags chứa column product_id và tag_id
    public function tags()
    {
        return $this
            ->belongsToMany(Tag::class, ProductTag::class, 'product_id', 'tag_id')
            ->withTimestamps();
    }
    public function tagsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this
            ->belongsToMany(Tag::class, ProductTag::class, 'product_id', 'tag_id')
            ->withTimestamps()->where('language', '=', $language);
    }

    // lấy thuộc tính sản phẩm
    public function attributes()
    {
        return $this
            ->belongsToMany(Attribute::class, ProductAttribute::class, 'product_id', 'attribute_id')
            ->withTimestamps();
    }
    public function attributesLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this
            ->belongsToMany(Attribute::class, ProductAttribute::class, 'product_id', 'attribute_id')
            ->withTimestamps()->where('language', '=', $language);
    }

    // get category by relationship 1 - nhieu
    // 1 category_products có nhiều product
    // 1 product có 1 category_products
    // use belongsTo để truy xuất ngược từ product lấy data trong table category
    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function stores()
    {
        return $this->hasMany(Store::class, "product_id", "id");
    }

    public function comments()
    {
        return $this
            ->belongsToMany(Comment::class, ProductComment::class, 'product_id', 'comment_id')
            ->withTimestamps();
    }

    public function getTotalProductStore($id)
    {

        return $this->find($id)->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total;
    }

    public function translationsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this->hasMany(ProductTranslation::class, "product_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(ProductTranslation::class, "product_id", "id");
    }
    public static function getHtmlOption($parentId = "")
    {
        $data = self::all();
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }

    public static function mergeLanguage($selectLang=[]){
        $s='product_translations.name as nameL,
        product_translations.slug as slugL,
        product_translations.description as descriptionL,
        product_translations.description_seo as description_seoL,
        product_translations.keyword_seo as keyword_seoL,
        product_translations.title_seo as title_seoL,
        product_translations.content as contentL,
        product_translations.language as languageL,
        product_translations.model as modelL,
        product_translations.tinhtrang as tinhtrangL,
        product_translations.baohanh as baohanhL,
        product_translations.xuatsu as xuatsuL,
        product_translations.content2 as content2L,
        product_translations.content3 as content3L,
        product_translations.content4 as content4L,
        ';
        $s2='products.*';
        if(count($selectLang)>0){
            $s=collect($selectLang);
            $stringKey = $s->map(function ($item, $key) {
                return "product_translations." . $item." as ".$item."L";
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
        return self::join('product_translations', function ($join) {
            $join->on('products.id', '=', 'product_translations.product_id')
                ->where('product_translations.language', '=', App::getLocale());
        })
        ->select($s2,
        DB::raw($s));
    }
}

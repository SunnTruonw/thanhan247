<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Models\ProductTag;
use App\Models\ProductTranslation;
use App\Models\Attribute;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Product\ValidateAddProduct;
use App\Http\Requests\Admin\Product\ValidateEditProduct;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;


use Illuminate\Support\Facades\App;

class AdminProductController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $product;
    private $categoryProduct;
    private $htmlselect;
    private $productImage;
    private $tag;
    private $productTag;
    private $productTranslation;
    private $supplier;
    private $attribute;
    private $langConfig;
    private $langDefault;

    public function __construct(
        ProductTranslation $productTranslation,
        Product $product,
        CategoryProduct $categoryProduct,
        ProductImage $productImage,
        Tag $tag,
        ProductTag $productTag,
        Attribute $attribute,
        Supplier $supplier
    ) {
        $this->product = $product;
        $this->categoryProduct = $categoryProduct;
        $this->productImage = $productImage;
        $this->tag = $tag;
        $this->productTag = $productTag;
        $this->productTranslation = $productTranslation;
        $this->attribute = $attribute;
        $this->supplier = $supplier;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    //
    public function index(Request $request)
    {
        //   dd(App::getLocale());
        $totalProduct = $this->product->all()->count();
        $data = $this->product;
        if ($request->input('category')) {
            $categoryProductId = $request->input('category');
            $idCategorySearch = $this->categoryProduct->getALlCategoryChildren($categoryProductId);
            $idCategorySearch[] = (int)($categoryProductId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryProduct->getHtmlOption($categoryProductId);
        } else {
            $htmlselect = $this->categoryProduct->getHtmlOption();
        }
        $where = [];
        $orWhere = null;
        if ($request->input('keyword')) {

            $data = $data->where(function ($query) {
                $idProTran = $this->productTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('product_id');
                // dd($idProTran);
                $query->whereIn('id', $idProTran)->orWhere([
                    ['masp', 'like', '%' . request()->input('keyword') . '%']
                ]);
            });
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            // $orWhere = ['masp', 'like', '%' . $request->input('keyword') . '%'];
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');

            switch ($key) {
                case 'hot':
                    $where[] = ['hot', '=', 1];
                    break;
                case 'no_hot':
                    $where[] = ['hot', '=', 0];
                    break;
                case 'active':
                    $where[] = ['active', '=', 1];
                    break;
                case 'no_active':
                    $where[] = ['active', '=', 0];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
        }
        //  dd($orWhere);
        if ($orWhere) {
            $data = $data->orWhere(...$orWhere);
        }
        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                case 'viewASC':
                    $orderby = [
                        'view',
                        'ASC'
                    ];
                    break;
                case 'viewDESC':
                    $orderby = [
                        'view',
                        'DESC'
                    ];
                    break;
                case 'priceASC':
                    $orderby = [
                        'price',
                        'ASC'
                    ];
                    break;
                case 'priceDESC':
                    $orderby = [
                        'price',
                        'DESC'
                    ];
                    break;
                case 'payASC':
                    $orderby = [
                        'pay',
                        'ASC'
                    ];
                    break;
                case 'payDESC':
                    $orderby = [
                        'pay',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("created_at", "DESC");
        }
        //  dd($this->product->select('*', \App\Models\Store::raw('Sum(quantity) as total')->whereRaw('products.id','stores.product_id'))->orderBy('total')->paginate(15));
        //  dd($data->get()->first()->name);
        $data = $data->paginate(15);

        return view("admin.pages.product.list",
            [
                'data' => $data,
                'totalProduct' => $totalProduct,
                'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }

    public function loadActive($id)
    {
        $product   =  $this->product->find($id);
        $active = $product->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $product->update([
            'active' => $activeUpdate,
        ]);
        // dd($updateResult);
        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $product, 'type' => 'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function loadHot($id)
    {
        $product   =  $this->product->find($id);
        $hot = $product->hot;

        if ($hot) {
            $hotUpdate = 0;
        } else {
            $hotUpdate = 1;
        }
        $updateResult =  $product->update([
            'hot' => $hotUpdate,
        ]);

        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-hot', ['data' => $product, 'type' => 'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function create(Request $request = null)
    {
        $htmlselect = $this->categoryProduct->getHtmlOption();

        $attributes = $this->attribute->where('parent_id', 0)->get();
        $supplier =$this->supplier->all();
        return view("admin.pages.product.add",
            [
                'option' => $htmlselect,
                'attributes' => $attributes,
                'supplier'=>$supplier,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddProduct $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $dataProductCreate = [
                "masp" => $request->input('masp'),
                "price" => $request->input('price') ?? 0,
                "sale" => $request->input('sale') ?? 0,
                "hot" => $request->input('hot') ?? 0,
				"noibat" => $request->input('noibat') ?? 0,
                "order" => $request->input('order') ?? null,
                // "pay"=>$request->input('pay'),
                // "number"=>$request->input('number'),
                "warranty" => $request->input('warranty') ?? 0,
                "view" => $request->input('view') ?? 0,
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "supplier_id" => $request->input('supplier_id')??0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //    dd($dataProductCreate);
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $dataUploadAvatar = $this->storageTraitUpload($request, "file", "file");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["file"] = $dataUploadAvatar["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "file2", "file");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["file2"] = $dataUploadAvatar["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "file3", "file");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["file3"] = $dataUploadAvatar["file_path"];
            }
            // dd($dataProductCreate);
            // insert database in product table
            $product = $this->product->create($dataProductCreate);
            // insert data product lang
            $dataProductTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemProductTranslation = [];
                $itemProductTranslation['name'] = $request->input('name_' . $key);
                $itemProductTranslation['slug'] = $request->input('slug_' . $key);
                $itemProductTranslation['description'] = $request->input('description_' . $key);
                $itemProductTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemProductTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemProductTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemProductTranslation['content'] = $request->input('content_' . $key);
                //add
                $itemProductTranslation['content2'] = $request->input('content2_' . $key);
                $itemProductTranslation['content3'] = $request->input('content3_' . $key);
                $itemProductTranslation['content4'] = $request->input('content4_' . $key);
                $itemProductTranslation['model'] = $request->input('model_' . $key);
                $itemProductTranslation['tinhtrang'] = $request->input('tinhtrang_' . $key);
                $itemProductTranslation['baohanh'] = $request->input('baohanh_' . $key);
                $itemProductTranslation['xuatsu'] = $request->input('xuatsu_' . $key);

                $itemProductTranslation['language'] = $key;
                $dataProductTranslation[] = $itemProductTranslation;
            }
            //    dd($dataProductTranslation);
            $productTranslation =   $product->translations()->createMany($dataProductTranslation);
            //  dd($productTranslation);
            // insert database to product_images table
            if ($request->hasFile("image")) {
                //
                $dataProductImageCreate = [];
                foreach ($request->file('image') as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, "product");
                    $dataProductImageCreate[] = [
                        "name" => $dataProductImageDetail["file_name"],
                        "image_path" => $dataProductImageDetail["file_path"]
                    ];
                }
                // insert database in product_images table by createMany
                $productImage =   $product->images()->createMany($dataProductImageCreate);
            }

            // insert attribute to product
            if ($request->has("attribute")) {
                $attribute_ids = [];
                foreach ($request->input('attribute') as $attributeItem) {
                    if ($attributeItem) {
                        $attributeInstance = $this->attribute->find($attributeItem);
                        $attribute_ids[] = $attributeInstance->id;
                    }
                }

                $attribute = $product->attributes()->attach($attribute_ids);
            }
            // insert database to product_tags table
            foreach ($this->langConfig as $key => $value) {
                if ($request->has("tags_" . $key)) {
                    $tag_ids = [];
                    foreach ($request->input('tags_' . $key) as $tagItem) {
                        $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                        $tag_ids[] = $tagInstance->id;
                    }
                    $product->tags()->attach($tag_ids, ['language' => $key]);
                }
            }

            DB::commit();
            return redirect()->route('admin.product.index')->with("alert", "Thêm sản phẩm thành công");
        } catch (\Exception $exception) {

            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.product.index')->with("error", "Thêm sản phẩm không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->product->find($id);

        $attributes = $this->attribute->where('parent_id', 0)->get();
        //   dd($data->tagsLanguage('vi')->get());
        $category_id = $data->category_id;
        $htmlselect = $this->categoryProduct->getHtmlOption($category_id);
        $supplier =$this->supplier->all();
        return view("admin.pages.product.edit", [
            'option' => $htmlselect,
            'data' => $data,
            'attributes' => $attributes,
            'supplier'=>$supplier
        ]);
    }
    public function update(ValidateEditProduct $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataProductUpdate = [
                "masp" => $request->input('masp') ?? null,
                "price" => $request->input('price') ?? 0,
                "sale" => $request->input('sale') ?? 0,
                "hot" => $request->input('hot') ?? 0,
				"noibat" => $request->input('noibat') ?? 0,
                "order" => $request->input('order') ?? null,
                // "pay"=>$request->input('pay'),
                // "number"=>$request->input('number'),
                "warranty" => $request->input('warranty') ?? 0,
                "view" => $request->input('view') ?? 0,
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "supplier_id" => $request->input('supplier_id')??0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            // dd( $dataProductUpdate);
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $path = $this->product->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataProductUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $dataUploadFile = $this->storageTraitUpload($request, "file", "file");
            if (!empty($dataUploadFile)) {
                $path = $this->product->find($id)->file;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataProductUpdate["file"] = $dataUploadFile["file_path"];
            }

            $dataUploadFile2 = $this->storageTraitUpload($request, "file2", "file");
            if (!empty($dataUploadFile2)) {
                $path = $this->product->find($id)->file2;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataProductUpdate["file2"] = $dataUploadFile2["file_path"];
            }

            $dataUploadFile3 = $this->storageTraitUpload($request, "file3", "file");
            if (!empty($dataUploadFile3)) {
                $path = $this->product->find($id)->file3;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataProductUpdate["file3"] = $dataUploadFile3["file_path"];
            }

            // insert database in product table
            $this->product->find($id)->update($dataProductUpdate);
            $product = $this->product->find($id);

            // insert data product lang
            $dataProductTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemProductTranslationUpdate = [];
                $itemProductTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemProductTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemProductTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemProductTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemProductTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemProductTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemProductTranslationUpdate['content'] = $request->input('content_' . $key);

                //add
                $itemProductTranslationUpdate['content2'] = $request->input('content2_' . $key);
                $itemProductTranslationUpdate['content3'] = $request->input('content3_' . $key);
                $itemProductTranslationUpdate['content4'] = $request->input('content4_' . $key);
                $itemProductTranslationUpdate['model'] = $request->input('model_' . $key);
                $itemProductTranslationUpdate['tinhtrang'] = $request->input('tinhtrang_' . $key);
                $itemProductTranslationUpdate['baohanh'] = $request->input('baohanh_' . $key);
                $itemProductTranslationUpdate['xuatsu'] = $request->input('xuatsu_' . $key);

                $itemProductTranslationUpdate['language'] = $key;
                //  dd($itemProductTranslationUpdate);
                //  dd($product->translations($key)->first());
                if ($product->translationsLanguage($key)->first()) {
                    $product->translationsLanguage($key)->first()->update($itemProductTranslationUpdate);
                } else {
                    $product->translationsLanguage($key)->create($itemProductTranslationUpdate);
                }
                //  $dataProductTranslationUpdate[] = $itemProductTranslationUpdate;
                //   $dataProductTranslationUpdate[] = new ProductTranslation($itemProductTranslationUpdate);
            }
            //    dd($product->translations);
            //   $productTranslation =   $product->translations()->saveMany($dataProductTranslationUpdate);
            //  $productTranslation =   $product->translations()->createMany($dataProductTranslationUpdate);

            // dd($product->translations);

            // insert attribute to product
            if ($request->has("attribute")) {
                $attribute_ids = [];
                foreach ($request->input('attribute') as $attributeItem) {
                    if ($attributeItem) {
                        $attributeInstance = $this->attribute->find($attributeItem);
                        $attribute_ids[] = $attributeInstance->id;
                    }
                }

                $attribute = $product->attributes()->sync($attribute_ids);
            }

            // insert database to product_images table
            if ($request->hasFile("image")) {
                //
                //   $product->images()->where("product_id", $id)->delete();
                $dataProductImageUpdate = [];
                foreach ($request->file('image') as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, "product");
                    $itemImage = [
                        "name" => $dataProductImageDetail["file_name"],
                        "image_path" => $dataProductImageDetail["file_path"]
                    ];
                    $dataProductImageUpdate[] = $itemImage;
                }
                // insert database in product_images table by createMany
                // dd($dataProductImageUpdate);
                $product->images()->createMany($dataProductImageUpdate);
                //  dd($product->images);
            }
            //  dd($product->images);
            // insert database to product_tags table
            $tag_ids = [];
            foreach ($this->langConfig as $key => $value) {

                if ($request->has("tags_" . $key)) {
                    foreach ($request->input('tags_' . $key) as $tagItem) {
                        $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                        $tag_ids[$tagInstance->id] = ['language' => $key];
                    }
                    //   $product->tags()->attach($tag_ids, ['language' => $key]);
                    // Các syncphương pháp chấp nhận một loạt các ID để ra trên bảng trung gian. Bất kỳ ID nào không nằm trong mảng đã cho sẽ bị xóa khỏi bảng trung gian.
                }
            }
            // dd($tag_ids);
            $product->tags()->sync($tag_ids);
            //  dd($product->tags);
            // end update tag

            DB::commit();
            return redirect()->route('admin.product.index')->with("alert", "Sửa sản phẩm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.product.index')->with("error", "Sửa sản phẩm không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->product, $id);
    }

    public function destroyFile($id, $field)
    {
        return  $this->deleteFileTrait($this->product, $id, $field);
    }

    public function destroyProductImage($id)
    {
        return $this->deleteImageTrait($this->productImage, $id);
    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.product')), config('excel_database.product.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path = request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.product')), $path);
    }
}

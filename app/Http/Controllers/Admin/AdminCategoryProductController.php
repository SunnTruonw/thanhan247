<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\CategoryProductTranslation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;


use App\Traits\StorageImageTrait;
use App\Http\Requests\Admin\CategoryProduct\ValidateEditCategoryProduct;
use App\Http\Requests\Admin\CategoryProduct\ValidateAddCategoryProduct;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Facades\Storage;

//use PDF;
class AdminCategoryProductController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;
    private $categoryProduct;
    private $langConfig;
    private $langDefault;
    private $categoryProductTranslation;
    public function __construct(CategoryProduct $categoryProduct, CategoryProductTranslation $categoryProductTranslation)
    {
        $this->categoryProduct = $categoryProduct;
        $this->categoryProductTranslation = $categoryProductTranslation;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    //

    public function index(Request $request)
    {
        $parentBr=null;
        if($request->has('parent_id')){

            if($request->input('parent_id')){
                $parentBr=$this->categoryProduct->mergeLanguage(['name','slug'])->find($request->input('parent_id'));
                //$data = $this->categoryGalaxy->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            }
            $data=$this->categoryProduct->getALlModelAdminCategoryChildren($request->input('parent_id'));
        }else{
          //  $data = $this->categoryGalaxy->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);
              $data=$this->categoryProduct->getALlModelAdminCategoryChildren(0);
        }
       // dd($data);
        return view("admin.pages.categoryproduct.list",
            [
                'data' => $data,
                'parentBr'=>$parentBr,
            ]
        );
    }
    public function create(Request $request)
    {
        //    dd($request->query());
        if ($request->has("parent_id")) {
            $htmlselect = CategoryProduct::getHtmlOptionAddWithParent($request->parent_id);
        } else {
            $htmlselect = $this->categoryProduct->getHtmlOption();
        }

        return view("admin.pages.categoryproduct.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddCategoryProduct $request)
    {
        try {
            DB::beginTransaction();
            $dataCategoryProductCreate = [
                //  "name" =>  $request->name,
                //   "slug" =>  $request->slug,
                //   "description" => $request->input('description'),
                //   "description_seo" => $request->input('description_seo'),
                //    "title_seo" => $request->input('title_seo'),
                //    "content" => $request->input('content'),
                "active" => $request->active,
                'order' => $request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUploadIcon = $this->storageTraitUpload($request, "icon_path", "category-product");
            if (!empty($dataUploadIcon)) {
                $dataCategoryProductCreate["icon_path"] = $dataUploadIcon["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category-product");
            if (!empty($dataUploadAvatar)) {
                $dataCategoryProductCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $categoryProduct = $this->categoryProduct->create($dataCategoryProductCreate);

            // dd($categoryProduct);
            // insert data product lang
            $dataCategoryProductTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemCategoryProductTranslation = [];
                $itemCategoryProductTranslation['name'] = $request->input('name_' . $key);
                $itemCategoryProductTranslation['slug'] = $request->input('slug_' . $key);
                $itemCategoryProductTranslation['description'] = $request->input('description_' . $key);
                $itemCategoryProductTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemCategoryProductTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemCategoryProductTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemCategoryProductTranslation['content'] = $request->input('content_' . $key);
                $itemCategoryProductTranslation['language'] = $key;
                $dataCategoryProductTranslation[] = $itemCategoryProductTranslation;
            }
            //  dd($categoryProduct->translations());
            $categoryProductTranslation =   $categoryProduct->translations()->createMany($dataCategoryProductTranslation);
            //  dd($categoryProductTranslation);
            DB::commit();
            return redirect()->route("admin.categoryproduct.index", ['parent_id' => $request->parent_id])->with("alert", "Thêm danh mục sản phẩm thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categoryproduct.index', ['parent_id' => $request->parent_id])->with("error", "Thêm danh mục sản phẩm không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->categoryProduct->find($id);
        $parentId = $data->parent_id;
        $htmlselect = CategoryProduct::getHtmlOptionEdit($parentId, $id);
        return view("admin.pages.categoryproduct.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditCategoryProduct $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataCategoryProductUpdate = [
                "active" => $request->active,
                'order' => $request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //  dd($dataCategoryProductUpdate);
            $dataUpdateIcon = $this->storageTraitUpload($request, "icon_path", "category-product");
            if (!empty($dataUpdateIcon)) {
                $path = $this->categoryProduct->find($id)->icon_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryProductUpdate["icon_path"] = $dataUpdateIcon["file_path"];
            }
            $dataUpdateAvatar = $this->storageTraitUpload($request, "avatar_path", "category-product");
            if (!empty($dataUpdateAvatar)) {
                $path = $this->categoryProduct->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryProductUpdate["avatar_path"] = $dataUpdateAvatar["file_path"];
            }
            $this->categoryProduct->find($id)->update($dataCategoryProductUpdate);
            $categoryProduct = $this->categoryProduct->find($id);
            $dataCategoryProductTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemCategoryProductTranslationUpdate = [];
                $itemCategoryProductTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemCategoryProductTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemCategoryProductTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemCategoryProductTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemCategoryProductTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemCategoryProductTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemCategoryProductTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemCategoryProductTranslationUpdate['language'] = $key;
                //  dd($itemProductTranslationUpdate);
                //  dd($product->translations($key)->first());
                if ($categoryProduct->translationsLanguage($key)->first()) {
                    $categoryProduct->translationsLanguage($key)->first()->update($itemCategoryProductTranslationUpdate);
                } else {
                    $categoryProduct->translationsLanguage($key)->create($itemCategoryProductTranslationUpdate);
                }


                //  $dataProductTranslationUpdate[] = $itemProductTranslationUpdate;
                //   $dataProductTranslationUpdate[] = new ProductTranslation($itemProductTranslationUpdate);
            }
            DB::commit();
            return redirect()->route("admin.categoryproduct.index", ['parent_id' => $request->parent_id])->with("alert", "Sửa danh mục sản phẩm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categoryproduct.index', ['parent_id' => $request->parent_id])->with("error", "Sửa danh mục sản phẩm không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->categoryProduct, $id);
    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.categoryProduct')), config('excel_database.categoryProduct.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path = request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.categoryProduct')), $path);
    }
    public function loadOrder($id, $order)
    {
        $data = $this->categoryProduct->find($id);

        try {
            DB::beginTransaction();



            DB::commit();
            return response()->json([
                "code" => 200,
                "html" => view()->render(),
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {

            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}

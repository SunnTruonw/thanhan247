<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CategoryProgram;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Http\Requests\Admin\CategoryProgram\ValidateEditCategoryProgram;
use App\Http\Requests\Admin\CategoryProgram\ValidateAddCategoryProgram;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Collection;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;
use Illuminate\Support\Facades\Storage;
class AdminCategoryProgramController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $categoryProgram;
    private $langConfig;
    private $langDefault;

    public function __construct(CategoryProgram $categoryProgram)
    {
        $this->categoryProgram = $categoryProgram;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    //
    public function index(Request $request)
    {
        $parentBr=null;
        if($request->has('parent_id')){
            $data = $this->categoryProgram->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            if($request->input('parent_id')){
                $parentBr=$this->categoryProgram->find($request->input('parent_id'));
            }
        }else{
            $data = $this->categoryProgram->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);
        }

        return view(
            "admin.pages.categoryprogram.list",
            [
                'data' => $data,
                'parentBr'=>$parentBr,
            ]
        );
    }
    public function create(Request $request )
    {
        if($request->has("parent_id")){
            $htmlselect = $this->categoryProgram->getHtmlOptionAddWithParent($request->parent_id);
        }else{
            $htmlselect = $this->categoryProgram->getHtmlOption();
        }
        return view("admin.pages.categoryprogram.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }

    public function store(ValidateAddCategoryProgram $request)
    {
        try {
            DB::beginTransaction();
            $dataCategoryProgramCreate = [
                //  "name" =>  $request->name,
                //   "slug" =>  $request->slug,
                //   "description" => $request->input('description'),
                //   "description_seo" => $request->input('description_seo'),
                //    "title_seo" => $request->input('title_seo'),
                //    "content" => $request->input('content'),
                "active" => $request->active,
                'order'=>$request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUploadIcon = $this->storageTraitUpload($request, "icon_path", "category-program");
            if (!empty($dataUploadIcon)) {
                $dataCategoryProgramCreate["icon_path"] = $dataUploadIcon["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category-program");
            if (!empty($dataUploadAvatar)) {
                $dataCategoryProgramCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
           // dd($dataCategoryProgramCreate);

            $categoryProgram = $this->categoryProgram->create($dataCategoryProgramCreate);

            // dd($categoryProgram);
            // insert data product lang
            $dataCategoryProgramTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemCategoryProgramTranslation = [];
                $itemCategoryProgramTranslation['name'] = $request->input('name_' . $key);
                $itemCategoryProgramTranslation['slug'] = $request->input('slug_' . $key);
                $itemCategoryProgramTranslation['description'] = $request->input('description_' . $key);
                $itemCategoryProgramTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemCategoryProgramTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemCategoryProgramTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemCategoryProgramTranslation['content'] = $request->input('content_' . $key);
                $itemCategoryProgramTranslation['language'] = $key;
                $dataCategoryProgramTranslation[] = $itemCategoryProgramTranslation;
            }
             // dd($categoryProgram->translations());

            $categoryProgramTranslation =   $categoryProgram->translations()->createMany($dataCategoryProgramTranslation);
             // dd($categoryProgramTranslation);
            DB::commit();
            return redirect()->route("admin.categoryprogram.index", ['parent_id' => $request->parent_id])->with("alert", "Thêm danh mục  thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categoryprogram.index', ['parent_id' => $request->parent_id])->with("error", "Thêm danh mục  không thành công");
        }
    }

    public function edit($id)
    {
        $data = $this->categoryProgram->find($id);
        $parentId = $data->parent_id;
        $htmlselect = CategoryProgram::getHtmlOptionEdit($parentId,$id);
        return view("admin.pages.categoryprogram.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }

    public function update(ValidateEditCategoryProgram $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataCategoryProgramUpdate = [
                "active" => $request->active,
                'order'=>$request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUpdateIcon = $this->storageTraitUpload($request, "icon_path", "category-program");
            if (!empty($dataUpdateIcon)) {
                $path = $this->categoryProgram->find($id)->icon_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryProgramUpdate["icon_path"] = $dataUpdateIcon["file_path"];
            }

            $dataUpdateAvatar = $this->storageTraitUpload($request, "avatar_path", "category-program");
            if (!empty($dataUpdateAvatar)) {
                $path = $this->categoryProgram->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryProgramUpdate["avatar_path"] = $dataUpdateAvatar["file_path"];
            }
            //  dd($dataCategoryProgramUpdate);
            $this->categoryProgram->find($id)->update($dataCategoryProgramUpdate);

            $categoryProgram = $this->categoryProgram->find($id);

            $dataCategoryProgramTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemCategoryProgramTranslationUpdate = [];
                $itemCategoryProgramTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemCategoryProgramTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemCategoryProgramTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemCategoryProgramTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemCategoryProgramTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemCategoryProgramTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemCategoryProgramTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemCategoryProgramTranslationUpdate['language'] = $key;
                //  dd($itemPostTranslationUpdate);
                //  dd($Post->translations($key)->first());
                if($categoryProgram->translationsLanguage($key)->first()){
                    $categoryProgram->translationsLanguage($key)->first()->update($itemCategoryProgramTranslationUpdate);
                }else{
                    $categoryProgram->translationsLanguage($key)->create($itemCategoryProgramTranslationUpdate);
                }

              //  $dataPostTranslationUpdate[] = $itemPostTranslationUpdate;
           //   $dataPostTranslationUpdate[] = new PostTranslation($itemPostTranslationUpdate);
            }
            DB::commit();
            return redirect()->route("admin.categoryprogram.index",['parent_id' => $request->parent_id])->with("alert", "Sửa danh mục bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categoryprogram.index',['parent_id' => $request->parent_id])->with("error", "Sửa danh mục bài viết không thành công");
        }
    }

    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->categoryProgram, $id);
    }
    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.categoryprogram')), config('excel_database.categoryprogram.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path =request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.categoryprogram')), $path);
    }
}

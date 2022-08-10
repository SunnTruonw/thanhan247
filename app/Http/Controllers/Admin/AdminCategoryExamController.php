<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// model
use App\Models\CategoryExam;
// debug
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// validate
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\CategoryExam\ValidateEditCategoryExam;
use App\Http\Requests\Admin\CategoryExam\ValidateAddCategoryExam;
// trait
use App\Traits\DeleteRecordTrait;
use App\Traits\StorageImageTrait;
// support
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class AdminCategoryExamController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;
    private $categoryExam;
    private $langConfig;
    private $langDefault;

    public function __construct(CategoryExam $categoryExam)
    {
        $this->categoryExam = $categoryExam;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    //
    public function index(Request $request)
    {

        $parentBr=null;
        if($request->has('parent_id')){
            $data = $this->categoryExam->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            if($request->input('parent_id')){
                $parentBr=$this->categoryExam->find($request->input('parent_id'));
            }
        }else{
            $data = $this->categoryExam->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);
        }

        return view("admin.pages.categoryexam.list",
            [
                'data' => $data,
                'parentBr'=>$parentBr,
            ]
        );
    }
    public function create(Request $request )
    {
        if($request->has("parent_id")){
            $htmlselect = $this->categoryExam->getHtmlOptionAddWithParent($request->parent_id);
        }else{
            $htmlselect = $this->categoryExam->getHtmlOption();
        }
        return view("admin.pages.categoryexam.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddCategoryExam $request)
    {
        try {
            DB::beginTransaction();
            $dataCategoryExamCreate = [
                "active" => $request->active,
                'order'=>$request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUploadIcon = $this->storageTraitUpload($request, "icon_path", "category-exam");
            if (!empty($dataUploadIcon)) {
                $dataCategoryExamCreate["icon_path"] = $dataUploadIcon["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category-exam");
            if (!empty($dataUploadAvatar)) {
                $dataCategoryExamCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $categoryExam = $this->categoryExam->create($dataCategoryExamCreate);

           // dd($categoryProduct);
            // insert data product lang
            $dataCategoryExamTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemCategoryExamTranslation = [];
                $itemCategoryExamTranslation['name'] = $request->input('name_' . $key);
                $itemCategoryExamTranslation['slug'] = $request->input('slug_' . $key);
                $itemCategoryExamTranslation['description'] = $request->input('description_' . $key);
                $itemCategoryExamTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemCategoryExamTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemCategoryExamTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemCategoryExamTranslation['content'] = $request->input('content_' . $key);
                $itemCategoryExamTranslation['language'] = $key;
                $dataCategoryExamTranslation[] = $itemCategoryExamTranslation;
            }
            //  dd($categoryProduct->translations());
            $categoryExamTranslation =   $categoryExam->translations()->createMany($dataCategoryExamTranslation);
            //  dd($categoryProductTranslation);
            DB::commit();
            return redirect()->route("admin.categoryexam.index", ['parent_id' => $request->parent_id])->with("alert", "Thêm danh mục exam thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categoryexam.index', ['parent_id' => $request->parent_id])->with("error", "Thêm danh mục exam không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->categoryExam->find($id);
        $parentId = $data->parent_id;
        $htmlselect = CategoryExam::getHtmlOptionEdit($parentId,$id);
        return view("admin.pages.categoryexam.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditCategoryExam $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataCategoryExamUpdate = [
                "active" => $request->active,
                'order'=>$request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //  dd($dataCategoryExamUpdate);
            $dataUpdateIcon = $this->storageTraitUpload($request, "icon_path", "category-post");
            if (!empty($dataUpdateIcon)) {
                $path = $this->categoryExam->find($id)->icon_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryExamUpdate["icon_path"] = $dataUpdateIcon["file_path"];
            }
            $dataUpdateAvatar = $this->storageTraitUpload($request, "avatar_path", "category-post");
            if (!empty($dataUpdateAvatar)) {
                $path = $this->categoryExam->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryExamUpdate["avatar_path"] = $dataUpdateAvatar["file_path"];
            }
            $this->categoryExam->find($id)->update($dataCategoryExamUpdate);
            $categoryExam = $this->categoryExam->find($id);
            $dataCategoryExamTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemCategoryExamTranslationUpdate = [];
                $itemCategoryExamTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemCategoryExamTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemCategoryExamTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemCategoryExamTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemCategoryExamTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemCategoryExamTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemCategoryExamTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemCategoryExamTranslationUpdate['language'] = $key;
                //  dd($itemPostTranslationUpdate);
                //  dd($Post->translations($key)->first());
                if($categoryExam->translationsLanguage($key)->first()){
                    $categoryExam->translationsLanguage($key)->first()->update($itemCategoryExamTranslationUpdate);
                }else{
                    $categoryExam->translationsLanguage($key)->create($itemCategoryExamTranslationUpdate);
                }

              //  $dataPostTranslationUpdate[] = $itemPostTranslationUpdate;
           //   $dataPostTranslationUpdate[] = new PostTranslation($itemPostTranslationUpdate);
            }
            DB::commit();
            return redirect()->route("admin.categoryexam.index",['parent_id' => $request->parent_id])->with("alert", "Sửa danh mục bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categoryexam.index',['parent_id' => $request->parent_id])->with("error", "Sửa danh mục bài viết không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->categoryExam, $id);
    }

}

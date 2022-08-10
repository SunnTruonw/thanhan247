<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Http\Requests\Admin\CategoryPost\ValidateEditCategoryPost;
use App\Http\Requests\Admin\CategoryPost\ValidateAddCategoryPost;
use App\Traits\DeleteRecordTrait;
use App\Traits\ParagraphTrait;

use Illuminate\Support\Collection;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;
use Illuminate\Support\Facades\Storage;


use App\Models\ParagraphCategoryPost;
use App\Models\ParagraphCategoryPostTranslation;

class AdminCategoryPostController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait, ParagraphTrait;
    private $categoryPost;
    private $langConfig;
    private $langDefault;

    private $paragraphCategoryPost;
    private $paragraphCategoryPostTransltion;
    private $typeParagraph;
    private $configParagraph;

    public function __construct(
        CategoryPost $categoryPost,
        ParagraphCategoryPostTranslation $paragraphCategoryPostTransltion,
        ParagraphCategoryPost $paragraphCategoryPost
    ) {
        $this->categoryPost = $categoryPost;
        $this->paragraphCategoryPostTransltion = $paragraphCategoryPostTransltion;
        $this->paragraphCategoryPost = $paragraphCategoryPost;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
        $this->typeParagraph = config('paragraph.category_posts');
        $this->configParagraph = config('paragraph.category_posts');
    }
    //
    public function index(Request $request)
    {
        $parentBr=null;
        if($request->has('parent_id')){

            if($request->input('parent_id')){
                $parentBr=$this->categoryPost->mergeLanguage(['name','slug'])->find($request->input('parent_id'));
                //$data = $this->categoryGalaxy->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            }
            $data=$this->categoryPost->getALlModelAdminCategoryChildren($request->input('parent_id'));
        }else{
          //  $data = $this->categoryGalaxy->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);
              $data=$this->categoryPost->getALlModelAdminCategoryChildren(0);
        }
       // dd($data);
        return view("admin.pages.categorypost.list",
            [
                'data' => $data,
                'parentBr'=>$parentBr,
            ]
        );
    }
    public function create(Request $request)
    {
        if ($request->has("parent_id")) {
            $htmlselect = $this->categoryPost->getHtmlOptionAddWithParent($request->parent_id);
        } else {
            $htmlselect = $this->categoryPost->getHtmlOption();
        }

        return view(
            "admin.pages.categorypost.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddCategoryPost $request)
    {
        try {
            DB::beginTransaction();
            $dataCategoryPostCreate = [
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

            $dataUploadIcon = $this->storageTraitUpload($request, "icon_path", "category-post");
            if (!empty($dataUploadIcon)) {
                $dataCategoryPostCreate["icon_path"] = $dataUploadIcon["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category-post");
            if (!empty($dataUploadAvatar)) {
                $dataCategoryPostCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $categoryPost = $this->categoryPost->create($dataCategoryPostCreate);

            // dd($categoryProduct);
            // insert data product lang
            $dataCategoryPostTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemCategoryPostTranslation = [];
                $itemCategoryPostTranslation['name'] = $request->input('name_' . $key);
                $itemCategoryPostTranslation['slug'] = $request->input('slug_' . $key);
                $itemCategoryPostTranslation['description'] = $request->input('description_' . $key);
                $itemCategoryPostTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemCategoryPostTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemCategoryPostTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemCategoryPostTranslation['content'] = $request->input('content_' . $key);
                $itemCategoryPostTranslation['language'] = $key;
                $dataCategoryPostTranslation[] = $itemCategoryPostTranslation;
            }
            //  dd($categoryProduct->translations());
            $categoryPostTranslation =   $categoryPost->translations()->createMany($dataCategoryPostTranslation);
            //  dd($categoryProductTranslation);

            if ($request->has('typeParagraph')) {
                $dataParagraphCreate = [];
                foreach ($request->input('typeParagraph') as $key => $typeParagraph) {
                    if ($typeParagraph) {
                        $dataParagraphCreateItem = [];
                        $dataParagraphCreateItem = [
                            "active" => $request->input('activeParagraph')[$key],
                            "type" => $typeParagraph,
                            "parent_id" => $request->input('parentIdParagraph')[$key] ?? 0,
                            "order" => $request->input('orderParagraph')[$key] ?? 0,
                            "admin_id" => auth()->guard('admin')->id()
                        ];

                        //  dd(count($request->image_path_paragraph));
                        //dd($request->hasFile('image_path_paragraph[0]'));
                        $dataUploadParagraphAvatar = $this->storageTraitUploadMutipleArray($request, "image_path_paragraph", $key, "category_post");
                        if (!empty($dataUploadParagraphAvatar)) {
                            $dataParagraphCreateItem["image_path"] = $dataUploadParagraphAvatar["file_path"];
                        }
                        $dataParagraphCreate[] = $dataParagraphCreateItem;
                        $paragraph = $categoryPost->paragraphs()->create(
                            $dataParagraphCreateItem
                        );

                        // insert data paragraph lang
                        $dataParagraphTranslation = [];
                        //  dd($this->langConfig);
                        foreach ($this->langConfig as $keyL => $valueL) {
                            $itemParagraphTranslation = [];
                            $itemParagraphTranslation['name'] = $request->input('nameParagraph_' . $keyL)[$key];
                            $itemParagraphTranslation['value'] = $request->input('valueParagraph_' . $keyL)[$key];
                            $itemParagraphTranslation['language'] = $keyL;
                            $dataParagraphTranslation[] = $itemParagraphTranslation;
                        }
                        // dd($dataParagraphTranslation);
                        $paragraphTranslation =   $paragraph->translations()->createMany($dataParagraphTranslation);
                        //  dd($paragraphTranslation);
                    }
                }
            }
            DB::commit();
            return redirect()->route("admin.categorypost.index", ['parent_id' => $request->parent_id])->with("alert", "Thêm danh mục bài viết thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categorypost.index', ['parent_id' => $request->parent_id])->with("error", "Thêm danh mục bài viết không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->categoryPost->find($id);
        $parentId = $data->parent_id;
        $htmlselect = CategoryPost::getHtmlOptionEdit($parentId, $id);
        return view("admin.pages.categorypost.edit", [
            'option' => $htmlselect,
            'data' => $data,
            'configParagraph' => $this->configParagraph
        ]);
    }
    public function update(ValidateEditCategoryPost $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataCategoryPostUpdate = [
                "active" => $request->active,
                'order' => $request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //  dd($dataCategoryPostUpdate);
            $dataUpdateIcon = $this->storageTraitUpload($request, "icon_path", "category-post");
            if (!empty($dataUpdateIcon)) {
                $path = $this->categoryPost->find($id)->icon_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryPostUpdate["icon_path"] = $dataUpdateIcon["file_path"];
            }
            $dataUpdateAvatar = $this->storageTraitUpload($request, "avatar_path", "category-post");
            if (!empty($dataUpdateAvatar)) {
                $path = $this->categoryPost->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataCategoryPostUpdate["avatar_path"] = $dataUpdateAvatar["file_path"];
            }
            $this->categoryPost->find($id)->update($dataCategoryPostUpdate);
            $categoryPost = $this->categoryPost->find($id);
            $dataCategoryPostTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemCategoryPostTranslationUpdate = [];
                $itemCategoryPostTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemCategoryPostTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemCategoryPostTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemCategoryPostTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemCategoryPostTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemCategoryPostTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemCategoryPostTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemCategoryPostTranslationUpdate['language'] = $key;
                //  dd($itemPostTranslationUpdate);
                //  dd($Post->translations($key)->first());
                if ($categoryPost->translationsLanguage($key)->first()) {
                    $categoryPost->translationsLanguage($key)->first()->update($itemCategoryPostTranslationUpdate);
                } else {
                    $categoryPost->translationsLanguage($key)->create($itemCategoryPostTranslationUpdate);
                }

                //  $dataPostTranslationUpdate[] = $itemPostTranslationUpdate;
                //   $dataPostTranslationUpdate[] = new PostTranslation($itemPostTranslationUpdate);
            }
            DB::commit();
            return redirect()->route("admin.categorypost.index", ['parent_id' => $request->parent_id])->with("alert", "Sửa danh mục bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categorypost.index', ['parent_id' => $request->parent_id])->with("error", "Sửa danh mục bài viết không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->categoryPost, $id);
    }
    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.categoryPost')), config('excel_database.categoryPost.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path = request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.categoryPost')), $path);
    }



    // thêm sửa xóa đoạn văn
    public function loadParagraphCategoryPost(Request $request)
    {
        return $this->loadParagraph($request, $this->configParagraph);
    }

    public function loadParentParagraphCategoryPost($id, Request $request)
    {
        return $this->loadParentParagraph($this->categoryPost, $this->paragraphCategoryPost, $id, $request);
    }

    public function loadCreateParagraphCategoryPost($id)
    {
        return  $this->loadCreateParagraph($this->categoryPost, $id, $this->configParagraph);
    }
    public function loadEditParagraphCategoryPost($id, Request $request)
    {

        return   $this->loadEditParagraph($this->paragraphCategoryPost, $this->configParagraph, $id);
    }

    public function storeParagraphCategoryPost(Request $request, $id)
    {
        return $this->storeParagraph($this->categoryPost, $this->configParagraph, $id,  $request);
    }
    public function updateParagraphCategoryPost(Request $request, $id)
    {
        return $this->updateParagraph($this->paragraphCategoryPost, $this->configParagraph, $id,  $request);
    }
    public function destroyParagraphCategoryPost($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->paragraphCategoryPost, $id);
    }
    // end thêm sửa xóa đoạn văn



}

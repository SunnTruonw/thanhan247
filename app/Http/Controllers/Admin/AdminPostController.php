<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\CategoryPost;
use App\Models\Tag;
use App\Models\PostTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Traits\ParagraphTrait;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Post\ValidateAddPost;
use App\Http\Requests\Admin\Post\ValidateEditPost;

use App\Models\ParagraphPost;
use App\Models\ParagraphPostTranslation;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;


class AdminPostController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait, ParagraphTrait;
    private $post;
    private $categoryPost;
    private $htmlselect;
    private $tag;
    private $postTag;
    private $paragraphPost;
    private $paragraphPostTransltion;
    private $langConfig;
    private $langDefault;
    private $typeParagraph;
    private $configParagraph;
    public function __construct(
        Post $post,
        CategoryPost $categoryPost,
        Tag $tag,
        PostTag $postTag,
        ParagraphPostTranslation $paragraphPostTransltion,
        ParagraphPost $paragraphPost,
        PostTranslation $postTranslation
    ) {
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->tag = $tag;
        $this->postTag = $postTag;
        $this->postTranslation = $postTranslation;
        $this->paragraphPostTransltion = $paragraphPostTransltion;
        $this->paragraphPost = $paragraphPost;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
        $this->typeParagraph = config('paragraph.posts');
        $this->configParagraph = config('paragraph.posts');
    }
    //
    public function index(Request $request)
    {
        $data = $this->post;
        if ($request->input('category')) {
            $categoryPostId = $request->input('category');
            $idCategorySearch = $this->categoryPost->getALlCategoryChildren($categoryPostId);
            $idCategorySearch[] = (int)($categoryPostId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryPost->getHtmlOption($categoryPostId);
        } else {
            $htmlselect = $this->categoryPost->getHtmlOption();
        }
        $where = [];
        if ($request->input('keyword')) {
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $data = $data->where(function ($query) {
                $idPostTran = $this->postTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('post_id');
                // dd($idProTran);
                $query->whereIn('id', $idPostTran);
            });
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');
            switch ($key) {
                case 'hot':
                    $where[] = ['hot', '=', 1];
                    break;
                case 'noHot':
                    $where[] = ['hot', '=', 0];
                    break;
                default:
                    break;
            }
        }
        if ($request->has('fill_status') && $request->input('fill_status')) {
            $key = $request->input('fill_status');
            switch ($key) {
                case '1':
                    $where[] = ['status', '=', 1];
                    break;
                case '2':
                    $where[] = ['status', '=', 2];
                    break;
                case '3':
                    $where[] = ['status', '=', 3];
                    break;
                case '4':
                    $where[] = ['status', '=', 4];
                    break;
                default:
                    break;
            }
        }
        if ($request->has('fill_active') && $request->input('fill_active')) {
            $key = $request->input('fill_active');
            switch ($key) {
                case '2':
                    $where[] = ['active', '=', 0];
                    break;
                case '1':
                    $where[] = ['active', '=', 1];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
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
        $data = $data->paginate(15);

        return view(
            "admin.pages.post.list",
            [
                'data' => $data,
                'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
                'fill_status' => $request->input('fill_status') ? $request->input('fill_status') : "",
                'fill_active' => $request->input('fill_active') ? $request->input('fill_active') : "",
            ]
        );
    }

    public function listSelf(Request $request)
    {
        $user=auth()->guard('admin')->user();

        $data = $user->posts();
        if ($request->input('category')) {
            $categoryPostId = $request->input('category');
            $idCategorySearch = $this->categoryPost->getALlCategoryChildren($categoryPostId);
            $idCategorySearch[] = (int)($categoryPostId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryPost->getHtmlOption($categoryPostId);
        } else {
            $htmlselect = $this->categoryPost->getHtmlOption();
        }
        $where = [];
        if ($request->input('keyword')) {
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $data = $data->where(function ($query) {
                $idPostTran = $this->postTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('post_id');
                // dd($idProTran);
                $query->whereIn('id', $idPostTran);
            });
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');
            switch ($key) {
                case 'hot':
                    $where[] = ['hot', '=', 1];
                    break;
                case 'noHot':
                    $where[] = ['hot', '=', 0];
                    break;
                default:
                    break;
            }
        }
        if ($request->has('fill_status') && $request->input('fill_status')) {
            $key = $request->input('fill_status');
            switch ($key) {
                case '1':
                    $where[] = ['status', '=', 1];
                    break;
                case '2':
                    $where[] = ['status', '=', 2];
                    break;
                case '3':
                    $where[] = ['status', '=', 3];
                    break;
                case '4':
                    $where[] = ['status', '=', 4];
                    break;
                default:
                    break;
            }
        }
        if ($request->has('fill_active') && $request->input('fill_active')) {
            $key = $request->input('fill_active');
            switch ($key) {
                case '2':
                    $where[] = ['active', '=', 0];
                    break;
                case '1':
                    $where[] = ['active', '=', 1];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
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
        $data = $data->paginate(15);

        return view("admin.pages.post.list-self",
            [
                'data' => $data,
                'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
                'fill_status' => $request->input('fill_status') ? $request->input('fill_status') : "",
                'fill_active' => $request->input('fill_active') ? $request->input('fill_active') : "",
            ]
        );
    }


    public function create(Request $request = null)
    {
        $htmlselect = $this->categoryPost->getHtmlOption();
        return view(
            "admin.pages.post.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddPost $request)
    {

        // dd($request->all());
        try {
            DB::beginTransaction();
            $dataPostCreate = [
                //  "name" => $request->input('name'),
                //  "slug" => $request->input('slug'),
                "hot" =>  0,
                "view" => $request->input('view') ?? 0,
                "file_down" => 0,
                //  "description" => $request->input('description'),
                //  "description_seo" => $request->input('description_seo'),
                //  "title_seo" => $request->input('title_seo'),
                //   "content" => $request->input('content'),
                "nhan" => $request->input('nhan') ?? 0,
                "view_start" => $request->input('view_start') ?? 0,
                "order" =>  0,
                'status' => 1,
                "active" => 1,
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            if($request->has('created_at')&&$request->input('created_at')){
                $dataPostCreate['created_at']=$request->created_at;
            }

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "post");
            if (!empty($dataUploadAvatar)) {
                $dataPostCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "file_path", "post");
            if (!empty($dataUploadAvatar)) {
                $dataPostCreate["file_path"] = $dataUploadAvatar["file_path"];
                $dataPostCreate["file_size"] = $dataUploadAvatar["file_size"];
            }
            // insert database in posts table
            $post = $this->post->create($dataPostCreate);

            //dd($post);
            // insert data product lang
            $dataPostTranslation = [];

            //  dd($this->langConfig);
            foreach ($this->langConfig as $key => $value) {
                $itemPostTranslation = [];
                $itemPostTranslation['name'] = $request->input('name_' . $key);
                $itemPostTranslation['slug'] = $request->input('slug_' . $key);
                $itemPostTranslation['description'] = $request->input('description_' . $key);
                $itemPostTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemPostTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemPostTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemPostTranslation['content'] = $request->input('content_' . $key);
                $itemPostTranslation['content2'] = $request->input('content2_' . $key);
                $itemPostTranslation['language'] = $key;
                //  dd($itemPostTranslation);
                if($request->input('name_' . $key)&&$request->input('slug_' . $key)){
                    $dataPostTranslation[] = $itemPostTranslation;
                }
            }
            // dd($dataPostTranslation);
            // dd($post->translations());
            $postTranslation =   $post->translations()->createMany($dataPostTranslation);
            // dd($postTranslation);
            // insert database to post_tags table

            foreach ($this->langConfig as $key => $value) {
                if ($request->has("tags_" . $key)) {
                    $tag_ids = [];
                    foreach ($request->input('tags_' . $key) as $tagItem) {
                        $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                        $tag_ids[] = $tagInstance->id;
                    }
                    $post->tags()->attach($tag_ids, ['language' => $key]);
                }
            }

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
                        $dataUploadParagraphAvatar = $this->storageTraitUploadMutipleArray($request, "image_path_paragraph", $key, "post");
                        if (!empty($dataUploadParagraphAvatar)) {
                            $dataParagraphCreateItem["image_path"] = $dataUploadParagraphAvatar["file_path"];
                        }
                        $dataParagraphCreate[] = $dataParagraphCreateItem;
                        $paragraph = $post->paragraphs()->create(
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
            return redirect()->route('admin.post.listSelf')->with("alert", "Thêm bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.post.listSelf')->with("error", "Thêm bài viết không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->post->find($id);

        // $admin = \Auth::guard()->user();

        // if (!$admin->can('post-edit', $data)) {
        //     return abort(401);
        // }


        $category_id = $data->category_id;
        $htmlselect = $this->categoryPost->getHtmlOption($category_id);
        return view("admin.pages.post.edit", [
            'option' => $htmlselect,
            'data' => $data,
            'configParagraph' => $this->configParagraph
        ]);
    }

    public function update(ValidateEditPost $request, $id)
    {
        // $post = $this->post->find($id);
        // $admin = \Auth::guard()->user();
        // if (!$admin->can('post-edit', $post)) {
        //     return abort(401);
        // }


        try {
            DB::beginTransaction();
            $dataPostUpdate = [
                //  "name" => $request->input('name'),
                //   "slug" => $request->input('slug'),
                "hot" => $request->input('hot') ?? 0,
                "order" => $request->input('order') ?? 0,
                // "view" => $request->input('view'),
                // "description" => $request->input('description'),
                //  "description_seo" => $request->input('description_seo'),
                //  "title_seo" => $request->input('title_seo'),
                // "content" => $request->input('content'),
                "nhan" => $request->input('nhan') ?? 0,
                "view_start" => $request->input('view_start') ?? 0,
                // "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_edit_id" => auth()->guard('admin')->id(),
            ];
            if($request->has('created_at')&&$request->input('created_at')){
                $dataPostUpdate['created_at']=$request->created_at;
            }
            if($this->post->find($id)->status==4){
                $dataPostUpdate['status']=5;
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "post");
            if (!empty($dataUploadAvatar)) {
                $path = $this->post->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataPostUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $dataUploadAvatar = $this->storageTraitUpload($request, "file_path", "post");
            if (!empty($dataUploadAvatar)) {
                $path = $this->post->find($id)->file_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataPostUpdate["file_path"] = $dataUploadAvatar["file_path"];
            }

            // insert database in post table
            $this->post->find($id)->update($dataPostUpdate);
            $post = $this->post->find($id);

            // insert data product lang
            $dataPostTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemPostTranslationUpdate = [];
                $itemPostTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemPostTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemPostTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemPostTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemPostTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemPostTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemPostTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemPostTranslationUpdate['content2'] = $request->input('content2_' . $key);
                $itemPostTranslationUpdate['language'] = $key;
                if($request->input('name_' . $key)&&$request->input('slug_' . $key)){
                    if ($post->translationsLanguage($key)->first()) {
                        $post->translationsLanguage($key)->first()->update($itemPostTranslationUpdate);
                    } else {
                        $post->translationsLanguage($key)->create($itemPostTranslationUpdate);
                    }
                }else{
                    if ($post->translationsLanguage($key)->first()) {
                        $post->translationsLanguage($key)->first()->delete();
                    }
                }
            }

            // insert database to post_tags table

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
            $post->tags()->sync($tag_ids);

            DB::commit();
            return redirect()->route('admin.post.listSelf')->with("alert", "sửa bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.post.listSelf')->with("error", "Sửa bài viết không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->post, $id);
    }

    public function destroyFile($id, $field)
    {
        return  $this->deleteFileTrait($this->post, $id, $field);
    }

    public function loadActive($id)
    {
        $post   =  $this->post->find($id);
        $active = $post->active;
        $status=$post->status;
        if($status==3){
            if ($active) {
                $activeUpdate = 0;
            } else {
                $activeUpdate = 1;
            }
            $updateResult =  $post->update([
                'active' => $activeUpdate,
                "admin_habai_id" => auth()->guard('admin')->id(),
            ]);
            $post   =  $this->post->find($id);
            if ($updateResult) {
                return response()->json([
                    "code" => 200,
                    "html" => view('admin.components.load-change-status', ['data' => $post, 'type' => 'bài viết'])->render(),
                    "message" => "success"
                ], 200);
            } else {
                return response()->json([
                    "code" => 500,
                    "message" => "fail"
                ], 500);
            }
        }

    }
    public function loadHot($id)
    {
        $post   =  $this->post->find($id);
        $hot = $post->hot;

        if ($hot) {
            $hotUpdate = 0;
        } else {
            $hotUpdate = 1;
        }
        $updateResult =  $post->update([
            'hot' => $hotUpdate,
        ]);

        $post   =  $this->post->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-hot', ['data' => $post, 'type' => 'bài viết'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function guiDuyet($id)
    {
        $post   =  $this->post->find($id);
        $status = $post->status;

        if ($status==1||$status==5) {
            $statusUpdate = 2;
            $updateResult =  $post->update([
                'status' => $statusUpdate,
                'admin_send_id' => auth()->guard('admin')->id(),
            ]);
        }

        $post   =  $this->post->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $post])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function traBai($id)
    {
        $post   =  $this->post->find($id);
        $status = $post->status;

        $statusUpdate = 4;

        $updateResult =  $post->update([
            'status' => $statusUpdate,
            'admin_trabai_id' => auth()->guard('admin')->id(),
        ]);

        $post   =  $this->post->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $post])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function duyet($id)
    {
        $post   =  $this->post->find($id);
        $status = $post->status;

        if ($status==2) {
            $statusUpdate = 3;
            $updateResult =  $post->update([
                'status' => $statusUpdate,
                'admin_duyet_id' => auth()->guard('admin')->id(),
            ]);
        }

        $post   =  $this->post->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status', ['data' => $post])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.post')), config('excel_database.post.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path = request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.post')), $path);
    }



    // thêm sửa xóa đoạn văn
    public function loadParagraphPost(Request $request)
    {
        return $this->loadParagraph($request, $this->configParagraph);
    }

    public function loadParentParagraphPost($id, Request $request)
    {
        return $this->loadParentParagraph($this->post, $this->paragraphPost, $id, $request);
    }

    public function loadCreateParagraphPost($id)
    {
        return  $this->loadCreateParagraph($this->post, $id, $this->configParagraph);
    }
    public function loadEditParagraphPost($id, Request $request)
    {

        return   $this->loadEditParagraph($this->paragraphPost, $this->configParagraph, $id);
    }

    public function storeParagraphPost(Request $request, $id)
    {
        return $this->storeParagraph($this->post, $this->configParagraph, $id,  $request);
    }
    public function updateParagraphPost(Request $request, $id)
    {
        return $this->updateParagraph($this->paragraphPost, $this->configParagraph, $id,  $request);
    }
    public function destroyParagraphPost($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->paragraphPost, $id);
    }
    // end thêm sửa xóa đoạn văn


}

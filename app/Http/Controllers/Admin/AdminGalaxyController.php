<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//model
use App\Models\Galaxy;
use App\Models\CategoryGalaxy;
use App\Models\GalaxyTranslation;
// support
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
//validate
use App\Http\Requests\Admin\Galaxy\ValidateAddGalaxy;
use App\Http\Requests\Admin\Galaxy\ValidateEditGalaxy;
//trait
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;

class AdminGalaxyController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;
    private $galaxy;
    private $categoryGalaxy;
    private $htmlselect;

    private $langConfig;
    private $langDefault;

    public function __construct(
        Galaxy $galaxy,
        CategoryGalaxy $categoryGalaxy,
        GalaxyTranslation $galaxyTranslation
    ) {
        $this->galaxy = $galaxy;
        $this->categoryGalaxy = $categoryGalaxy;
        $this->galaxyTranslation = $galaxyTranslation;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    //
    public function index(Request $request)
    {
        $data = $this->galaxy;
        if ($request->input('category')) {
            $categoryGalaxyId = $request->input('category');
            $idCategorySearch = $this->categoryGalaxy->getALlCategoryChildren($categoryGalaxyId);
            $idCategorySearch[] = (int)($categoryGalaxyId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryGalaxy->getHtmlOption($categoryGalaxyId);
        } else {
            $htmlselect = $this->categoryGalaxy->getHtmlOption();
        }
        $where = [];
        if ($request->input('keyword')) {
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $data = $data->where(function ($query) {
                $idGalaxyTran = $this->galaxyTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('galaxy_id');
                // dd($idProTran);
                $query->whereIn('id', $idGalaxyTran);
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
            "admin.pages.galaxy.list",
            [
                'data' => $data,
                'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }


    public function create(Request $request = null)
    {
        $htmlselect = $this->categoryGalaxy->getHtmlOption();
        return view(
            "admin.pages.galaxy.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddGalaxy $request)
    {
        try {
            DB::beginTransaction();
            $dataGalaxyCreate = [
                "hot" => $request->input('hot') ?? 0,
                "view" => $request->input('view') ?? 0,
                "order" => $request->input('order') ?? 0,
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "galaxy");
            if (!empty($dataUploadAvatar)) {
                $dataGalaxyCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in galaxys table
            $galaxy = $this->galaxy->create($dataGalaxyCreate);
            // dd($galaxy);
            // insert data product lang
            $dataGalaxyTranslation = [];
            //  dd($this->langConfig);
            foreach ($this->langConfig as $key => $value) {
                $itemGalaxyTranslation = [];
                $itemGalaxyTranslation['name'] = $request->input('name_' . $key);
                $itemGalaxyTranslation['slug'] = $request->input('slug_' . $key);
                $itemGalaxyTranslation['description'] = $request->input('description_' . $key);
                $itemGalaxyTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemGalaxyTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemGalaxyTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemGalaxyTranslation['content'] = $request->input('content_' . $key);
                $itemGalaxyTranslation['language'] = $key;
                //  dd($itemGalaxyTranslation);
                $dataGalaxyTranslation[] = $itemGalaxyTranslation;
            }
            // dd($dataGalaxyTranslation);
            // dd($galaxy->translations());
            $galaxyTranslation =   $galaxy->translations()->createMany($dataGalaxyTranslation);

            DB::commit();
            return redirect()->route('admin.galaxy.index')->with("alert", "Thêm galaxy thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.galaxy.index')->with("error", "Thêm galaxy không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->galaxy->find($id);
        $category_id = $data->category_id;
        $htmlselect = $this->categoryGalaxy->getHtmlOption($category_id);
        return view("admin.pages.galaxy.edit", [
            'option' => $htmlselect,
            'data' => $data,
        ]);
    }

    public function update(ValidateEditGalaxy $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataGalaxyUpdate = [
                "order" => $request->input('order') ?? 0,
                "hot" => $request->input('hot') ?? 0,
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id(),
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "galaxy");
            if (!empty($dataUploadAvatar)) {
                $path = $this->galaxy->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataGalaxyUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            // insert database in galaxy table
            $this->galaxy->find($id)->update($dataGalaxyUpdate);
            $galaxy = $this->galaxy->find($id);

            // insert data product lang
            $dataGalaxyTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemGalaxyTranslationUpdate = [];
                $itemGalaxyTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemGalaxyTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemGalaxyTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemGalaxyTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemGalaxyTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemGalaxyTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemGalaxyTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemGalaxyTranslationUpdate['language'] = $key;

                if ($galaxy->translationsLanguage($key)->first()) {
                    $galaxy->translationsLanguage($key)->first()->update($itemGalaxyTranslationUpdate);
                } else {
                    $galaxy->translationsLanguage($key)->create($itemGalaxyTranslationUpdate);
                }
            }
            DB::commit();
            return redirect()->route('admin.galaxy.index')->with("alert", "sửa galaxy thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.galaxy.index')->with("error", "Sửa galaxy không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->galaxy, $id);
    }



    public function loadActive($id)
    {
        $galaxy   =  $this->galaxy->find($id);
        $active = $galaxy->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $galaxy->update([
            'active' => $activeUpdate,
        ]);
        $galaxy   =  $this->galaxy->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $galaxy, 'type' => 'bài viết'])->render(),
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
        $galaxy   =  $this->galaxy->find($id);
        $hot = $galaxy->hot;

        if ($hot) {
            $hotUpdate = 0;
        } else {
            $hotUpdate = 1;
        }
        $updateResult =  $galaxy->update([
            'hot' => $hotUpdate,
        ]);

        $galaxy   =  $this->galaxy->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-hot', ['data' => $galaxy, 'type' => 'Galaxy'])->render(),
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

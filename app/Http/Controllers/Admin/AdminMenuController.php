<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\Menu\ValidateAddMenu;
use App\Http\Requests\Admin\Menu\ValidateEditMenu;
use Illuminate\Support\Facades\Storage;
class AdminMenuController extends Controller
{
    //
    use DeleteRecordTrait,StorageImageTrait;
    private $menu;
    private $langConfig;
    private $langDefault;
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    public function index(Request $request)
    {

        $parentBr=null;
        if($request->has('parent_id')){
            $data = $this->menu->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            if($request->input('parent_id')){
                $parentBr=$this->menu->find($request->input('parent_id'));
            }
        }else{
            $data = $this->menu->where('parent_id', 0)->orderBy("created_at", "desc")->paginate(15);
        }

        return view(
            "admin.pages.menu.list",
            [
                'data' => $data,
                'parentBr'=>$parentBr,
            ]
        );
    }
    public function create(Request $request )
    {
        if($request->has("parent_id")){
            $htmlselect = $this->menu->getHtmlOptionAddWithParent($request->parent_id);
        }else{
            $htmlselect = $this->menu->getHtmlOption();
        }
        return view(
            "admin.pages.menu.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddMenu $request)
    {
        try {
            DB::beginTransaction();
            $dataMenuCreate = [
                "active" => $request->active,
                'order'=>$request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "menu");

            if (!empty($dataUploadAvatar)) {
                $dataMenuCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            $menu = $this->menu->create($dataMenuCreate);


            // insert data product lang
            $dataMenuTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemMenuTranslation = [];
                $itemMenuTranslation['name'] = $request->input('name_' . $key);
                $itemMenuTranslation['slug'] = $request->input('slug_' . $key);
                $itemMenuTranslation['language'] = $key;
                $dataMenuTranslation[] = $itemMenuTranslation;
            }
            //  dd($menu->translations());
            $menuTranslation =   $menu->translations()->createMany($dataMenuTranslation);
            //  dd($menuTranslation);
            DB::commit();
            return redirect()->route("admin.menu.index", ['parent_id' => $request->parent_id])->with("alert", "Thêm menu thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.menu.index', ['parent_id' => $request->parent_id])->with("error", "Thêm menu không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->menu->find($id);
        $parentId = $data->parent_id;
        $htmlselect = Menu::getHtmlOptionEdit($parentId,$id);
        return view("admin.pages.menu.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditMenu $request, $id)
    {


        try {
            DB::beginTransaction();
            $dataMenuUpdate = [
                "active" => $request->active,
                'order'=>$request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];



            $dataUpdateAvatar = $this->storageTraitUpload($request, "avatar_path", "menu");
            if (!empty($dataUpdateAvatar)) {
                $path = $this->menu->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataMenuUpdate["avatar_path"] = $dataUpdateAvatar["file_path"];
            }
            //  dd($dataMenuUpdate);
            $this->menu->find($id)->update($dataMenuUpdate);
            $menu = $this->menu->find($id);
            //  dd($menu);
            $dataMenuTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemMenuTranslationUpdate = [];
                $itemMenuTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemMenuTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemMenuTranslationUpdate['language'] = $key;
                if($menu->translationsLanguage($key)->first()){
                    $menu->translationsLanguage($key)->first()->update($itemMenuTranslationUpdate);
                }else{
                    $menu->translationsLanguage($key)->create($itemMenuTranslationUpdate);
                }
            }

            DB::commit();
            return redirect()->route("admin.menu.index",['parent_id' => $request->parent_id])->with("alert", "Sửa menu thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.menu.index',['parent_id' => $request->parent_id])->with("error", "Sửa menu không thành công");
        }


    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->menu, $id);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\SettingTranslation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\Setting\ValidateAddSetting;
use App\Http\Requests\Admin\Setting\ValidateEditSetting;
use Illuminate\Support\Facades\Storage;
class AdminSettingController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $setting;
    private $settingTranslation;
    private $langConfig;
    private $langDefault;
    public function __construct(Setting $setting,SettingTranslation $settingTranslation)
    {
        $this->setting = $setting;
        $this->settingTranslation = $settingTranslation;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    public function index(Request $request)
    {

        $parentBr=null;
        if($request->has('parent_id')){

            if($request->input('parent_id')){
                $parentBr=$this->setting->mergeLanguage(['name','slug'])->find($request->input('parent_id'));
                //$data = $this->categoryGalaxy->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            }
            $data=$this->setting->getALlModelAdminCategoryChildren($request->input('parent_id'));
        }else{
          //  $data = $this->categoryGalaxy->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);
              $data=$this->setting->getALlModelAdminCategoryChildren(0);
        }
       // dd($data);
        return view("admin.pages.setting.list",
            [
                'data' => $data,
                'parentBr'=>$parentBr,
            ]
        );

    }
    public function create(Request $request )
    {
        if($request->has("parent_id")){
            $htmlselect = $this->setting->getHtmlOptionAddWithParent($request->parent_id);
        }else{
            $htmlselect = $this->setting->getHtmlOption();
        }
        return view(
            "admin.pages.setting.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddSetting $request)
    {
        try {
            DB::beginTransaction();
            $dataSettingCreate = [
                "active" => $request->active,
                'order'=>$request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //   dd($dataSettingCreate);

            // $dataUploadAvatar = $this->storageTraitUpload($request, "image_path", "setting");
            // if (!empty($dataUploadAvatar)) {
            //     $dataSettingCreate["image_path"] = $dataUploadAvatar["file_path"];
            // }

            // $dataUploadFile = $this->storageTraitUpload($request, "file", "files");
            // if (!empty($dataUploadFile)) {
            //     $dataSettingCreate["file"] = $dataUploadFile["file_path"];
            // }

            $setting = $this->setting->create($dataSettingCreate);
            // dd($setting);
            // insert data product lang
            $dataSettingTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemSettingTranslation = [];
                $itemSettingTranslation['name'] = $request->input('name_' . $key);
                $itemSettingTranslation['slug'] = $request->input('slug_' . $key);
                $itemSettingTranslation['description'] = $request->input('description_' . $key);
                $itemSettingTranslation['value'] = $request->input('value_' . $key);
                $itemSettingTranslation['language'] = $key;

                $dataUploadAvatar = $this->storageTraitUpload($request, "image_path_". $key, "setting");
                if (!empty($dataUploadAvatar)) {
                    $itemSettingTranslation["image_path"] = $dataUploadAvatar["file_path"];
                }

                $dataUploadFile = $this->storageTraitUpload($request, "file_". $key, "files");
                if (!empty($dataUploadFile)) {
                    $itemSettingTranslation["file"] = $dataUploadFile["file_path"];
                }

                $dataSettingTranslation[] = $itemSettingTranslation;
            }
            //  dd($setting->translations());
            $settingTranslation =   $setting->translations()->createMany($dataSettingTranslation);
            //  dd($settingTranslation);
            DB::commit();
            return redirect()->route("admin.setting.index", ['parent_id' => $request->parent_id])->with("alert", "Thêm nội dung thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.setting.index', ['parent_id' => $request->parent_id])->with("error", "Thêm nội dung không thành công");
        }


    }
    public function edit($id)
    {
        $data = $this->setting->find($id);
        $parentId = $data->parent_id;
        $htmlselect = Setting::getHtmlOptionEdit($parentId, $id);
        return view("admin.pages.setting.edit", [
            'option' => $htmlselect,
            'data' => $data,
        ]);
    }
    public function update(ValidateEditSetting $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataSettingUpdate = [
                "active" => $request->active,
                'order'=>$request->order,
                "parent_id" => $request->parent_id ? $request->parent_id : 0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //  dd($dataCategoryPostUpdate);

            // $dataUpdateAvatar = $this->storageTraitUpload($request, "image_path", "setting");
            // if (!empty($dataUpdateAvatar)) {
            //     $path = $this->setting->find($id)->image_path;
            //     if ($path) {
            //         Storage::delete($this->makePathDelete($path));
            //     }
            //     $dataSettingUpdate["image_path"] = $dataUpdateAvatar["file_path"];
            // }

            // $dataUpdateFile = $this->storageTraitUpload($request, "file", "files");
            // if (!empty($dataUpdateFile)) {
            //     $file = $this->setting->find($id)->file;
            //     if ($file) {
            //         Storage::delete($this->makePathDelete($file));
            //     }
            //     $dataSettingUpdate["file"] = $dataUpdateFile["file_path"];
            // }

            $this->setting->find($id)->update($dataSettingUpdate);
            $setting = $this->setting->find($id);
            $dataSettingTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemSettingTranslationUpdate = [];
                $itemSettingTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemSettingTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemSettingTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemSettingTranslationUpdate['value'] = $request->input('value_' . $key);
                $itemSettingTranslationUpdate['language'] = $key;


                $dataUpdateAvatar = $this->storageTraitUpload($request, "image_path_". $key, "setting");
                if (!empty($dataUpdateAvatar)) {
                    // $path = $this->setting->find($id)->image_path;
                    // if ($path) {
                    //     Storage::delete($this->makePathDelete($path));
                    // }
                    $itemSettingTranslationUpdate["image_path"] = $dataUpdateAvatar["file_path"];
                }

                $dataUpdateFile = $this->storageTraitUpload($request, "file_". $key, "files");
                if (!empty($dataUpdateFile)) {
                    // $file = $this->setting->find($id)->file;
                    // if ($file) {
                    //     Storage::delete($this->makePathDelete($file));
                    // }
                    $itemSettingTranslationUpdate["file"] = $dataUpdateFile["file_path"];
                }


                if($setting->translationsLanguage($key)->first()){
                    $setting->translationsLanguage($key)->first()->update($itemSettingTranslationUpdate);
                }else{
                    $setting->translationsLanguage($key)->create($itemSettingTranslationUpdate);
                }
            }
            DB::commit();
            return redirect()->route("admin.setting.index",['parent_id' => $request->parent_id])->with("alert", "Sửa nội dung thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.setting.index',['parent_id' => $request->parent_id])->with("error", "Sửa nội dung không thành công");
        }
    }

    public function deleteFile($id,$field)
    {
        $data = $this->settingTranslation->find($id);
        if($data){
            $data->update([
                $field=>null
            ]);
            return back()->with('alert','Xóa file thành công');
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->setting, $id);
    }
}

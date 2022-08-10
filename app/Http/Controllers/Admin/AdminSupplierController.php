<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\Supplier\ValidateAddSupplier;
use App\Http\Requests\Admin\Supplier\ValidateEditSupplier;
use Illuminate\Support\Facades\Storage;
class AdminSupplierController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $supplier;
    private $langConfig;
    private $langDefault;
    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    public function index(Request $request)
    {

        $data = $this->supplier->orderBy("created_at", "desc")->paginate(15);

        return view(
            "admin.pages.supplier.list",
            [
                'data' => $data
            ]
        );

    }
    public function create(Request $request )
    {
        return view("admin.pages.supplier.add",
            [
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddSupplier $request)
    {
        try {
            DB::beginTransaction();
            $dataSupplierCreate = [
                "fax" => $request->fax,
                "phone" => $request->phone,
                "email" => $request->email,
                "website" => $request->website,

                "active" => $request->active,
                'order'=>$request->order,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "logo_path", "supplier");
            if (!empty($dataUploadAvatar)) {
                $dataSupplierCreate["logo_path"] = $dataUploadAvatar["file_path"];
            }
          //  dd($dataSupplierCreate);
            $supplier = $this->supplier->create($dataSupplierCreate);
            // dd($supplier);
            // insert data product lang
            $dataSupplierTranslation = [];
            foreach ($this->langConfig as $key => $value) {
                $itemSupplierTranslation = [];
                $itemSupplierTranslation['name'] = $request->input('name_' . $key);
                //  $itemSupplierTranslation['description'] = $request->input('description_' . $key);
                $itemSupplierTranslation['language'] = $key;
                $dataSupplierTranslation[] = $itemSupplierTranslation;
            }
            //  dd($supplier->translations());
            $supplierTranslation =   $supplier->translations()->createMany($dataSupplierTranslation);
            //  dd($supplierTranslation);
            DB::commit();
            return redirect()->route("admin.supplier.index")->with("alert", "Thêm nhà cung cấp thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.supplier.index')->with("error", "Thêm nhà cung cấp không thành công");
        }


    }
    public function edit($id)
    {
        $data = $this->supplier->find($id);
        return view("admin.pages.supplier.edit", [
            'data' => $data
        ]);
    }
    public function update(ValidateEditSupplier $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataSupplierUpdate = [
                "fax" => $request->fax,
                "phone" => $request->phone,
                "email" => $request->email,
                "website" => $request->website,
                "active" => $request->active,
                'order'=>$request->order,
                "admin_id" => auth()->guard('admin')->id()
            ];
            //  dd($dataCategoryPostUpdate);

            $dataUpdateAvatar = $this->storageTraitUpload($request, "logo_path", "supplier");
            if (!empty($dataUpdateAvatar)) {
                $path = $this->supplier->find($id)->image_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataSupplierUpdate["logo_path"] = $dataUpdateAvatar["file_path"];
            }
            // dd($dataSupplierUpdate);
            $this->supplier->find($id)->update($dataSupplierUpdate);

            $supplier = $this->supplier->find($id);

            $dataSupplierTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemSupplierTranslationUpdate = [];
                $itemSupplierTranslationUpdate['name'] = $request->input('name_' . $key);
              //  $itemSupplierTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemSupplierTranslationUpdate['language'] = $key;
                if($supplier->translationsLanguage($key)->first()){
                    $supplier->translationsLanguage($key)->first()->update($itemSupplierTranslationUpdate);
                }else{
                    $supplierTranslation=   $supplier->translationsLanguage($key)->create($itemSupplierTranslationUpdate);
                    dd($supplierTranslation);
                }
            }
            DB::commit();
            return redirect()->route("admin.supplier.index")->with("alert", "Sửa nhà cung cấp thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.supplier.index')->with("error", "Sửa nhà cung cấp không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->supplier, $id);
    }


    public function loadActive($id)
    {
        $supplier   =  $this->supplier->find($id);
        $active = $supplier->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $supplier->update([
            'active' => $activeUpdate,
        ]);
        $supplier   =  $this->supplier->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $supplier,'type'=>'slider'])->render(),
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

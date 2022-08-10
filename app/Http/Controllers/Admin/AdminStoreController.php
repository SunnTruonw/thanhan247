<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\Store\ValidateAddStore;
use App\Http\Requests\Admin\Store\ValidateEditStore;
use App\Models\Product;
use App\Models\Transaction;

class AdminStoreController extends Controller
{
    //
    use DeleteRecordTrait;
    private $store;
    private $product;
    private $transaction;
    private $typeStore;
    public function __construct(Store $store, Product $product, Transaction $transaction)
    {
        $this->store = $store;
        $this->product = $product;
        $this->transaction = $transaction;
        $this->typeStore = config('point.typeStore');
    }
    public function index()
    {
        $data = $this->store->where('active',1)->orderBy("created_at", "desc")->paginate(15);
        return view("admin.pages.store.list",
            [
                'data' => $data,
                'typeStore'=>$this->typeStore,
            ]
        );
    }


    public function create(Request $request)
    {
        if (false !== array_search($request->type, [1, 3])) {
            return view(
                "admin.pages.store.add",
                [
                    'request' => $request,
                ]
            );
        } else {
            return;
        }
    }
    public function store(ValidateAddStore $request)
    {
        if (false === array_search($request->type, [1, 3])) {
            return;
        }
        try {
            DB::beginTransaction();
            $masp = $request->input('masp');
            $product = $this->product->where([
                'masp' => $masp,
            ])->first();
            $dataStoreCreate = [
                "active" => $request->input('active'),
                "type" => $request->input('type'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            if ($request->type == 1) {
                $dataStoreCreate['quantity']=$request->input('quantity') ?? null;
                $dataStoreCreate['product_id']=$product->id;
                $store = $this->store->create($dataStoreCreate);
            }
            if ($request->type == 3) {
                //   dd($request->input('transaction_code'));
                $transaction = $this->transaction->where([
                    'code' => $request->input('transaction_code'),
                ])->first();

                // cập nhập admin xuất kho
                //   dd($listDataStoreCreate);
                foreach ($transaction->stores as $store) {
                    $store->update([
                        "admin_id" => auth()->guard('admin')->id(),
                        "type" => 3
                    ]);
                }
                //    dd($transaction->stores );
                // cập nhập transaction sang trạng thái vận chuyển
                $transaction->update([
                    'status' => 3,
                ]);
                //  dd($transaction->status);
            }
            //  dd($dataStoreCreate);

            DB::commit();
            return redirect()->route("admin.store.create", ['type' => $request->input('type') ?? 0])->with("alert", "Thêm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route("admin.store.create", ['type' => $request->input('type') ?? 0])->with("error", "Thêm không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->store->find($id);
        return view("admin.pages.store.edit", [
            'data' => $data
        ]);
    }
    public function update(ValidateEditStore $request, $id)
    {
        $store=$this->store->find($id);
      //  dd($store);
        if($store->type==1){
            $product=$this->product->where([
                'masp'=>$request->input('masp'),
            ])->first();
            $store->update([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
                'active' => $request->input('active'),
            ]);
            return redirect()->route("admin.store.index")->with("alert", "Sửa  thành công");
        }
    }
    public function destroy($id)
    {
        $store=$this->find($id);
        if($store->type==1){
            return $this->deleteCategoryRecusiveTrait($this->store, $id);
        }

    }
}

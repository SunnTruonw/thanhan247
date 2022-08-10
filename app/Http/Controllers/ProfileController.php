<?php

namespace App\Http\Controllers;

use App\Http\Requests\Frontend\UpdatePasswordRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Point;
use App\Models\Product;
use App\Traits\StorageImageTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Frontend\ValidateAddUser;
use App\Http\Requests\Frontend\ValidateEditUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Frontend\ValidateDrawPoint;
use App\Models\Bank;
use App\Models\Transaction;
use App\Traits\PointTrait;

class ProfileController extends Controller
{
    //
    use StorageImageTrait, PointTrait;
    private $user;
    private $point;
    private $product;
    private $typePoint;
    private $rose;
    private $typePay;
    private $datePay;
    private $bank;
    public function __construct(User $user, Point $point, Bank $bank, Transaction $transaction, Product $product)
    {

        $this->user = $user;
        $this->point = $point;
        $this->bank = $bank;
        $this->typePoint = config('point.typePoint');

        $this->transaction = $transaction;
        $this->listStatus = $this->transaction->listStatus;
        $this->product = $product;
    }
    public function index(Request $request)
    {
        $user = auth()->guard('web')->user();

        $sumPointCurrent = $this->point->sumPointCurrent($user->id);
        $sumEachType=$this->point->sumEachType($user->id);
        $point=$user->points()->latest()->paginate(50);


        return view('frontend.pages.profile.profile', [
            'user' => $user,
            'sumPointCurrent' => $sumPointCurrent,
            'typePoint' => $this->typePoint,
            'data'=>$point,
            'sumEachType'=>$sumEachType
        ]);
    }


    public function history(Request $request)
    {
        $user = auth()->guard()->user();
        // dd($user);
        $data = $user->transactions()->paginate(1);
        $transactionGroupByStatus = $user->transactions()->select($this->transaction->raw('count(status) as total'), 'status')->groupBy('status')->get();
        $totalTransaction = $this->transaction->all()->count();
        //   dd( $transactionGroupByStatus);
        $dataTransactionGroupByStatus = $this->listStatus;
        foreach ($transactionGroupByStatus as $item) {
            $dataTransactionGroupByStatus[$item->status]['total'] = $item->total;
        }

        //   dd($data);
        //  $sumEachType = $this->point->sumEachType($user->id);
        //   $sumPointCurrent = $this->point->sumPointCurrent($user->id);

        return view('frontend.pages.profile.profile-history', [
            'dataTransactionGroupByStatus' => $dataTransactionGroupByStatus,
            'totalTransaction' => $totalTransaction,
            'user' => $user,
            'data' => $data,
            'listStatus' => $this->listStatus,
        ]);
    }


    public function editInfo()
    {
        $user = auth()->guard('web')->user();
        // $banks = $this->bank->get();
        return view('frontend.pages.profile.profile-edit-info', ['data' => $user, 'user' => $user]);
    }
    // Quản lý đơn hàng
    public function manageInfo(){
        
    }
    public function updateInfo($id, ValidateEditUser $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->find($id);
            $dataUserUpdate = [
                "name" => $request->input('name'),
                "email" => $request->input('email'),
                "username" => $request->input('username'),
                "phone" => $request->input('phone'),
                "date_birth" => $request->input('date_birth'),
                "address" => $request->input('address'),
                //  "hktt" => $request->input('hktt'),
                // "cmt" => $request->input('cmt'),
                // "stk" => $request->input('stk'),
                // "ctk" => $request->input('ctk'),
                //  "bank_id" => $request->input('bank_id'),
                // "bank_branch" => $request->input('bank_branch'),
                "sex" => $request->input('sex'),
                // "active" => $request->input('active'),
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $dataUserUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            if ($request->has('password')&&$request->input('password')) {
                $dataUserUpdate['password'] = Hash::make($request->input('password'));
            }
            // dd($dataUserUpdate);
            // insert database in product table
            $this->user->find($id)->update($dataUserUpdate);
            $user = $this->user->find($id);

            DB::commit();
            return redirect()->route('profile.editInfo', ['user' => $user])->with("alert", "Thay đổi thông tin thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.editInfo', ['user' => $user])->with("error", "Thay đổi thông tin không thành công");
        }
    }
    
    public function changePassword() 
    {
        $user = auth()->guard()->user();

        return view('frontend.pages.change_password.index')->with([
            'user' => $user,
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $account = auth()->user();
        if ( Hash::check($request['current_password'], $account->password) ) {
            $account->update(['password' => bcrypt($request['password'])]);

            return redirect()->back()->with('message', 'Đổi mật khẩu thành công!');
        }
        return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng!');
    }
}

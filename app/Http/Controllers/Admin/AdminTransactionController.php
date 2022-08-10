<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Traits\DeleteRecordTrait;
use PDF;
use App\Traits\PointTrait;

class AdminTransactionController extends Controller
{
    //
    use DeleteRecordTrait, PointTrait;
    private  $transaction;
    private $unit;
    private $listStatus;
    private $typePoint;
    private $rose;
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->unit = "đ";
        $this->listStatus = $this->transaction->listStatus;
        $this->typePoint = config('point.typePoint');
        $this->rose = config('point.rose');
    }
    public function index(Request $request)
    {
        //thống kê giao dịch
        $transactionGroupByStatus = $this->transaction->select($this->transaction->raw('count(status) as total'), 'status')->groupBy('status')->get();
        $totalTransaction = $this->transaction->get()->count();

        $dataTransactionGroupByStatus = $this->listStatus;
        foreach ($transactionGroupByStatus as $item) {
            $dataTransactionGroupByStatus[$item->status]['total'] = $item->total;
        }
        //    dd($dataTransactionGroupByStatus);

        $transactions = $this->transaction;
        $where = [];
        $orWhere = null;
        if ($request->has('keyword') && $request->input('keyword')) {

            $transactions = $transactions->where(function ($query) {
                $query->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->orWhere([
                    ['code', 'like', '%' . request()->input('keyword') . '%']
                ]);
            });
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            // $orWhere = ['code', 'like', '%' . $request->input('keyword') . '%'];
        }
        if ($request->has('status') && $request->input('status')) {
            $where[] = ['status', $request->input('status')];
        }
        if ($where) {
            $transactions = $transactions->where($where);
        }
        if ($orWhere) {
            $transactions = $transactions->orWhere(...$orWhere);
        }
        $orderby = [];
        if ($request->has('order_with') && $request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby[] = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby[] = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                case 'statusASC':
                    $orderby[] = ['status', 'ASC'];
                    $orderby[] = ['created_at', 'DESC'];
                    break;
                case 'statusDESC':
                    $orderby[] = ['status', 'DESC'];
                    $orderby[] = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby[]  = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            foreach ($orderby as $or) {
                $transactions = $transactions->orderBy(...$or);
            }
        } else {
            $transactions = $transactions->orderBy("created_at", "DESC");
        }

        $transactions =  $transactions->paginate(15);
        return view('admin.pages.transaction.index', [
            'data' => $transactions,
            'dataTransactionGroupByStatus' => $dataTransactionGroupByStatus,
            'totalTransaction' => $totalTransaction,
            'listStatus' => $this->listStatus,
            'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
            'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
            'statusCurrent' => $request->input('status') ? $request->input('status') : "",
        ]);
    }
    public function loadNextStepStatus(Request $request)
    {
        $id = $request->id;
        $transaction = $this->transaction->find($id);
        $status = $transaction->status;

        $dataUpdate = [];
        switch ($status) {
            case -1:
                break;
            case 1:
                $status += 1;
                break;
            case 2:
                $status += 1;
                break;
            case 3:
                $status += 1;
                break;
            case 4:
                break;
            default:
                break;
        }
        $dataUpdate['status']=$status;
        $transaction->update($dataUpdate);
        return response()->json([
            'code' => 200,
            'htmlStatus' => view('admin.components.status', [
                'dataStatus' => $transaction,
                'listStatus' => $this->listStatus,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }
    public function loadTransactionDetail($id)
    {
        $orders = $this->transaction->find($id)->orders()->get();
        return response()->json([
            'code' => 200,
            'htmlTransactionDetail' => view('admin.components.transaction-detail', [
                'orders' => $orders,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->transaction, $id);
    }

    public function loadThanhtoan($id)
    {
        $transaction   =  $this->transaction->find($id);
        $thanhtoan = $transaction->thanhtoan;

        if ($thanhtoan) {
            $thanhtoanUpdate = 0;
        } else {
            $thanhtoanUpdate = 1;
        }
        $updateResult =  $transaction->update([
            'thanhtoan' => $thanhtoanUpdate,
        ]);

        $transaction   =  $this->transaction->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-thanhtoan', ['data' => $transaction])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }


    public function show($id)
    {
        $transactions = $this->transaction->find($id);
        return view('admin.pages.transaction.show', [
            'data' => $transactions,
            "unit" => $this->unit,
        ]);
    }
    public function exportPdfTransactionDetail($id)
    {

        $transactions = $this->transaction->find($id);
        $unit = $this->unit;
        $data = $transactions;
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadView("admin.pages.transaction.show-pdf", compact('data'), compact('unit'));

        return $pdf->download("transaction.pdf");
    }
}

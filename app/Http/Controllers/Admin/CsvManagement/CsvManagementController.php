<?php

namespace App\Http\Controllers\Admin\CsvManagement;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\CsvManagement\CsvManagement;
use Illuminate\Http\Request;

class CsvManagementController extends Controller
{
    protected $model, $condition, $shipper;
    private $listStatus;

    public function __construct(CsvManagement $model, Contact $contact)
    {
        $this->model = $model;
        $this->contact = $contact;
        $this->listStatus = $this->contact->listStatus;
    }

    public function index(Request $request)
    {
        $params = request()->all();

        // dd($params['status']);
        $orders = $this->model
            ->when(isset($params['customer_name']), function ($query) use ($params) {
                $query->join('users', 'csv_managements.user_id', 'users.id')
                    ->where('username', 'LIKE', '%' . $params['customer_name'] . '%');
            })
            ->when($params, function ($query) use ($params) {
                if (isset($params['start_date']) && isset($params['end_date'])) {
                    $query->whereBetween('created_at', [$params['start_date'], $params['end_date']]);
                } else {
                    $query->when(isset($params['start_date']), function ($q) use ($params) {
                        $q->where('created_at', '>=', $params['start_date']);
                    })
                        ->when(isset($params['end_date']), function ($q) use ($params) {
                            $q->where('created_at', '<=', $params['end_date']);
                        });
                }
            });
        if (isset($params['status']) && $params['status']) {
            $orders = $this->model->where('status', $params['status']);
        }

        $orders = $orders->paginate(30);
        // dd($orders);
        // dd($this->listStatus);
        return view('admin.pages.csv-management.index')->with([
            'orders' => $orders,
            'listStatus' => $this->listStatus,
            'statusCurrent' => $request->input('status') ? $request->input('status') : "",
        ]);
    }



    private function searchOrder($params)
    {
        $select = ['csv_managements.*'];
        $query = $this->model;

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $query = $query->whereBetween('collection_date', [$params['start_date'], $params['end_date']]);
        } else {
            $query = $query->when(isset($params['start_date']), function ($q) use ($params) {
                $q->where('collection_date', '>=', $params['start_date']);
            })
                ->when(isset($params['end_date']), function ($q) use ($params) {
                    $q->where('collection_date', '<=', $params['end_date']);
                });
        }

        return $query->select($select);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->model->findOrFail($id);

        return view('admin.pages.csv-management.show')->with([
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $csvorder = $this->model->find($id);
        $status = $csvorder->status;
        switch ($status) {
            case -1:
                break;
            case 1:
                $status += 1;
                break;
            case 2:
                break;
            default:
                break;
        }
        $csvorder->update([
            'status' => $status,
        ]);
        return response()->json([
            'code' => 200,
            'htmlStatus' => view('admin.components.status', [
                'dataStatus' => $csvorder,
                'listStatus' => $this->listStatus,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->model, $id);
    }
}

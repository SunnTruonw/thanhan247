<?php

namespace App\Http\Controllers\Frontend\SearchOrder;

use App\Http\Controllers\Controller;
use App\Models\OrderManagement\OrderManagement;
use Illuminate\Http\Request;

class SearchOrderController extends Controller
{
    protected $model;

    public function __construct(OrderManagement $model)
    {
        $this->model = $model;
    }

    /**
     * Search order
     * 
     * @return view
     */
    public function index()
    {
        try {
            $params = explode(',', str_replace(' ', '', request()['order_code']));
            $orders = $this->model
                        ->whereIn('order_code', $params)
                        ->handleSort()
                        ->paginate($this->model::PER_PAGE)
                        ->appends(request()->query());
                        
            return view('frontend.pages.search_order.index')->with([
                'orders' => $orders
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            \Log::error($th->getMessage());
        }
    }
}

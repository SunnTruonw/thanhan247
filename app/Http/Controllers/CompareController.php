<?php

namespace App\Http\Controllers;

use App\Helper\CompareHelper;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Setting;

class CompareController extends Controller
{
    //

    private $product;



    private $compare;
    private $setting;
    private $attribute;
    private $unit;
    public function __construct(
        Product $product,
        Setting $setting,
        Attribute $attribute
    ) {
        $this->product = $product;
        $this->setting = $setting;
        $this->unit = "đ";
        $this->attribute = $attribute;
    }
    public function list()
    {
        //  dd($this->city->get());
        $this->compare = new CompareHelper();
        $compare = $this->compare->compareItems;
        $totalQuantity =  $this->compare->getTotalQuantity();

        $data = collect($compare)->map(function ($item, $key) {
            $it =  $this->product->find($item['id']);
            if ($it) {
                return  $it;
            }
        })->filter(function ($value, $key) {
            return $value != null;
        })->reverse();
        //dd($data);
        $attributes = $this->attribute->where([
            ['active', 1],
            ['parent_id', 0]
        ])->orderby('order')->orderByDesc('created_at')->get();
        //  dd($attributes);

        return view('frontend.pages.compare', [
            'data' => $data,
            'totalQuantity' => $totalQuantity,
            'unit' => $this->unit,
            'attribute' => $attributes,
        ]);
    }

    public function add($id)
    {
        $this->compare = new CompareHelper();

        $product = $this->product->find($id);

        $this->compare->add($product);
        $totalQuantity=  $this->compare->totalQuantity;
        return response()->json([
            'code' => 200,
            'messange' => 'success',
            'totalQuantity'=>$totalQuantity,
        ], 200);
    }
    public function addAndRedirect($id)
    {
        $this->compare = new CompareHelper();
        $product = $this->product->find($id);
        $this->compare->add($product);
        return redirect()->route("compare.list");
    }
    public function remove($id)
    {
        $this->compare = new CompareHelper();

        $this->compare->remove($id);
        // dd($this->compare);
        $compare=  $this->compare->compareItems;
        $totalQuantity =  $this->compare->getTotalQuantity();
        $data = collect($compare)->map(function ($item, $key) {
            $it =  $this->product->find($item['id']);
            if ($it) {
                return  $it;
            }
        })->filter(function ($value, $key) {
            return $value != null;
        })->reverse();
        //dd($data);
        $attributes = $this->attribute->where([
            ['active', 1],
            ['parent_id', 0]
        ])->orderby('order')->orderByDesc('created_at')->get();

        return response()->json([
            'code' => 200,
            'html' => view('frontend.components.compare-component', [
                'data' => $data,
                'unit' => $this->unit,
                'attribute' => $attributes,
            ])->render(),
            'totalQuantity' => $totalQuantity,
            'messange' => 'success'
        ], 200);
    }
    public function update($id, Request $request)
    {
    }
    public function clear()
    {
        $this->compare = new CompareHelper();
        $this->compare->clear();
        $compare=  $this->compare->compareItems;
        $totalQuantity =  $this->compare->getTotalQuantity();
        $data = collect($compare)->map(function ($item, $key) {
            $it =  $this->product->find($item['id']);
            if ($it) {
                return  $it;
            }
        })->filter(function ($value, $key) {
            return $value != null;
        })->reverse();
        //dd($data);
        $attributes = $this->attribute->where([
            ['active', 1],
            ['parent_id', 0]
        ])->orderby('order')->orderByDesc('created_at')->get();

        return response()->json([
            'code' => 200,
            'html' => view('frontend.components.compare-component', [
                'data' => $data,
                'unit' => $this->unit,
                'attribute' => $attributes,
            ])->render(),
            'totalQuantity' => $totalQuantity,
            'messange' => 'success'
        ], 200);
    }
}

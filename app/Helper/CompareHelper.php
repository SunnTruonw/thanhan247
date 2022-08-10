<?php

namespace App\Helper;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Session;
class CompareHelper
{
    public $compareItems = [];
    public $totalQuantity = 0;

    public function __construct()
    {
        // session()->flush();
      //  session()->forget('compare');
        $this->compareItems = session()->has('compare') ? session('compare') : [];
        //   $this->compareItems = Session::has('compare') ? Session::session('compare') : [];
        $this->totalQuantity = $this->getTotalQuantity();
    }
    public function add($product, $quantity = 1)
    {
        if (isset($this->compareItems[$product->id])) {

        } else {
            $compareItem = [
                'id' => $product->id,
                'price' => $product->price,
                'sale' => $product->sale,
                'name' => $product->name,
                'avatar_path' => $product->avatar_path,
            ];

            $this->compareItems[$product->id] = $compareItem;
            $this->totalQuantity = $this->getTotalQuantity();
        }
        session(['compare' => $this->compareItems]);
    }
    public function remove($id)
    {
        if (isset($this->compareItems[$id])) {
            unset($this->compareItems[$id]);
            $this->totalQuantity = $this->getTotalQuantity();
        }
        // Session::put('compare' , $this->compareItems);
        session(['compare' => $this->compareItems]);
    }
    public function update($id, $quantity)
    {

    }
    public function clear()
    {
        $this->compareItems = [];
        session()->forget('compare');
    }



    public function getTotalQuantity()
    {
        return count($this->compareItems);
    }


}

<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;
use App\Helper\AddressHelper;

class AddressController extends Controller
{
    //
    private $cart;
    private $city;
    private $district;
    private $commune;
    public function __construct(City $city, District $district, Commune $commune)
    {
        $this->city = $city;
        $this->district = $district;
        $this->commune = $commune;
    }
    public function getDistricts(Request $request, $id)
    {
        $cityId = $request->id;
        $address = new AddressHelper();
        $data = $this->city->find($id)->districts()->whereIn('id', [1, 2, 3, 4, 5, 6, 7, 9, 19, 268, 8, 21])->orderby('name')->get();

        // foreach ($data as $key => $district) {
        //     if ($district->id !== 4 && $district->id !== 268 && $district->id !== 8) {
        //         $data[] = $district;
        //     }
        // }

        $districts = $address->districts($data, $id);
        return response()->json([
            "code" => 200,
            'data' => $districts,
            "message" => "success"
        ], 200);
    }
    public function getCommunes(Request $request, $id)
    {
        $districtId = $request->districtId;
        //     dd($districtId);
        $address = new AddressHelper();
        // if ($id == 8) {
        //     $data = $this->district->find($id)->communes()->whereNotIn('id', [334, 328])->orderby('name')->get();
        // } else if ($id == 268) {
        //     $data = $this->district->find($id)->communes()->whereNotIn('id', [9568, 9571])->orderby('name')->get();
        // } else if ($id == 21) {
        //     $data = $this->district->find($id)->communes()->whereNotIn('id', 595)->orderby('name')->get();
        // } else {
        //     $data = $this->district->find($id)->communes()->orderby('name')->get();
        // }
        $data = $this->district->find($id)->communes()->orderby('name')->get();
        // if ($id == 8) {

        // } else if ($id == 268) {
        //     $data = $this->district->find($id)->communes()->whereNotIn('id', [9568, 9571])->orderby('name')->get();
        // } else if ($id == 21) {
        //     $data = $this->district->find($id)->communes()->whereNotIn('id', 595)->orderby('name')->get();
        // } else {
        //     $data = $this->district->find($id)->communes()->orderby('name')->get();
        // }

        // $data=$this->district->find($id)->join('communes', 'districts.id', '=', 'communes.district_id')->get();
        // dd($data);


        $communes = $address->communes($data, $id);
        //   dd($communes);
        return response()->json([
            "code" => 200,
            'data' => $communes,
            "message" => "success"
        ], 200);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //
    protected $table="points";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'origin_id', 'id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'origin_id', 'id');
    }
    // lấy tổng số điểm mỗi kiểu
    // lấy danh sách hoa hồng được hưởng từ các thành viên
    public function sumEachType($userId)
    {
        return  $this->where([
            'user_id' => $userId,
        ])->select('type', Point::raw('SUM(point) as total'))->groupBy('type')->get();
    }

      // lấy tổng số điểm mỗi kiểu
    // lấy danh sách hoa hồng được hưởng từ các thành viên kiểu hoa hồng 8 gộp với 3
    public function sumEachTypeFrontend($userId)
    {
        $data =  $this->where([
            'user_id' => $userId,
        ])->select('type', Point::raw('SUM(point) as total'))->groupBy('type')->get()->toArray();
        $arr3=null;
        $arr8=null;
      //  dd($data);
        foreach ($data as $key => $value) {
           if($value['type']==3){
            $arr3=$key;
           }elseif($value['type']==8){
            $arr8=$key;
           }
        }
      //  dd($arr8);

        if($arr8!==null){
            if($arr3!==null){
                $data[$arr3]['total']+=$data[$arr8]['total'];

                unset($data[$arr8]);
            }else{
                $data[$arr8]['type']=3;
            }
        }
     //   dd($data[$arr3]['total']);
        return  $data ;
    }
     // lấy số điểm hiện có
    public function sumPointCurrent($userId)
    {
        $t=$this->where([
            'user_id' => $userId,
        ])->select(Point::raw('SUM(point) as total'))->first()->total;
        return $t?$t:0;
    }
    public function pointInfo()
    {
        $type = $this->attributes['type'];
        $listType = config('point.typePoint');
        $result = [
            'type' => config('point.typePoint')[$type]['name'],
            'url' => '',
            'name' => config('point.typePoint')[$type]['name'],
        ];
        $result['name'] = config('point.typePoint')[$type]['name'];
        switch ($type) {
            case '2':
                $product = $this->product;

                if ($product) {
                    $result['url'] = route('product.detail', ['slug' => optional($product)->slug, 'id' => optional($product)->id]);
                    $result['name'] = $product->name;
                }

                break;
            default:
                # code...
                break;
        }
        return $result;
    }
}

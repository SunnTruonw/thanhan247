<?php

namespace App\Traits;

use App\Models\Point;
use FontLib\TrueType\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
trait PointTrait
{

    private $data = [];
    /*
     store image upload and return null || array
     @param
     $request type Request, data input
     $fieldName type string, name of field input file
     $folderName type string; name of folder store
     return array
     [
         "file_name","file_path"
     ]
    */
    // lấy tổng số điểm mỗi kiểu
    // lấy danh sách hoa hồng được hưởng từ các thành viên

    public function getSumEachType($user)
    {
        $point = new Point();
        return  $point->where([
            'user_id' => $user->id,
        ])->select('type', Point::raw('SUM(point) as total'))->groupBy('type')->get();
    }
    // lấy số điểm hiện có
    public function getSumPointCurrent($user)
    {
        $point = new Point();
        return $point->where([
            'user_id' => $user->id,
        ])->select(Point::raw('SUM(point) as total'))->first()->total;
    }
    // lấy số điểm hiện có
    public function getListUser20()
    {
        $user = auth()->guard('web')->user();
        $i = 1;
        $this->data = [];
        $data = [];
        $userLoop = [$user];
        // dd($userLoop->childs()->first()->childs()->first()->childs()->first()->childs()->first());
        $data =  $this->getListUser20Recusive($userLoop, 1);
        //  $data=collect($data);
        // dd($data->orderby('created_at'));
        return $data;
    }
    public function getListUser20Recusive($userLoop, $i = 1, $imax = 20)
    {

        if ($i <= $imax) {
            if ($userLoop) {
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $list = $loopItem->childs()->get()->toArray();
                        foreach ($list as $item) {
                            $item['level'] = $i;
                            array_push($this->data, $item);
                        }
                    }
                }
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $this->getListUser20Recusive($loopItem->childs, $i + 1);
                    }
                }
            }
        }
        return $this->data;
    }

    public function getListUser20Recusive2($userLoop, $i = 1, $imax = 20)
    {

        if ($i <= $imax) {
            if ($userLoop) {
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $list = $loopItem->childs()->get();
                        foreach ($list as $item) {
                            $item->level = $i;
                            array_push($this->data, $item);
                        }
                    }
                }
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $this->getListUser20Recusive($loopItem->childs, $i + 1);
                    }
                }
            }
        }
        return $this->data;
    }

    public function addPointTo7($user)
    {
        $j = 1;
        $userLoop = $user;
        while ($j <= 7) {
            if ($userLoop->parent_id2 != 0) {
               // dd($userLoop->parent2()->first());
                if($userLoop->parent2()->first()->active==1){
                    $userLoop->parent2()->first()->points()->create([
                        'type' => $this->typePoint[3]['type'],
                        'point' => $this->typePoint['pointReward'],
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                }
                $userLoop = $userLoop->parent2()->first();
            } else {
                break;
            }
            $j++;
        }
    }
    public function addPointTo20($user,$total)
    {
        // thêm số điểm cây 20 lớp
        $total=(float)$total;
        $totalPoint=moneyToPoint($total);

        $i = 1;
        $userLoop = $user;
        $typePoint = config('point.typePoint');
        $rose = config('point.rose');
        while ($i <= 20) {
            if ($userLoop->parent_id != 0) {
                if($userLoop->parent()->first()->active==1){
                    $userLoop->parent()->first()->points()->create([
                        'type' => $typePoint[2]['type'],
                        'point' => $rose[$i]['percent']*$totalPoint/100,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                }
                $userLoop = $userLoop->parent()->first();
            } else {
                break;
            }
            $i++;
        }
    }
}

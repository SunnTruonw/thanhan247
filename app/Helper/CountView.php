<?php

namespace App\Helper;

class CountView
{
    public function __construct()
    {
    }

    // Đếm view
    // Tăng 1 nếu địa chỉ ip chưa tùng truy cập || truy cập sau 1h
    // paramt
    // $model Model database cần tăng view
    // $column tên cột tăng
    // $key type 'product'|| 'post'
    // $id id của product|| post đang truy cập
    //
    public function countView($model, $column, $key, $id)
    {
        $ipaddress      = $this->getClientIp();
        $timeNow        = time();
        $throttleTime   = 60*60;
        $key            = $key."_".md5($ipaddress)."_".$id;
      //  check xem đã vào chưa
        if(session()->exists($key)){
            $timeBefore=session()->get($key);
            // check xem từ lần truy cập trước đến lần truy cập này đã vượt thời gian cho phép tăng view chưa
            if($timeBefore+ $throttleTime>$timeNow){
                return false;
            }
        }
        // đặt lại mốc thời gian truy cập là thời điểm hiện tại
        session()->put($key,$timeNow);
        $model->where('id',$id)->increment('view',1);
    }

    public function getClientIp()
    {

        // $ipaddress = '';
        // if (getenv('HTTP_CLIENT_IP'))
        //     $ipaddress = getenv('HTTP_CLIENT_IP');
        // else if(getenv('HTTP_X_FORWARDED_FOR'))
        //     $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        // else if(getenv('HTTP_X_FORWARDED'))
        //     $ipaddress = getenv('HTTP_X_FORWARDED');
        // else if(getenv('HTTP_FORWARDED_FOR'))
        //     $ipaddress = getenv('HTTP_FORWARDED_FOR');
        // else if(getenv('HTTP_FORWARDED'))
        //    $ipaddress = getenv('HTTP_FORWARDED');
        // else if(getenv('REMOTE_ADDR'))
        //     $ipaddress = getenv('REMOTE_ADDR');
        // else
        //     $ipaddress = 'UNKNOWN';
        // return $ipaddress;

        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

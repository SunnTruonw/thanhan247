<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExcelExportsDatabasePay implements FromArray,WithHeadings
{
    private $model;
    private $excelfile;
    private $selectField;
    private $title;
    private $titleField;
    private $start;
    private $end;
    public function __construct($start,$end)
    {
        $this->start=$start;
        $this->end=$end;
        $nameModel ='\App\Models\Pay';
        $this->model= new $nameModel;
        $this->selectField="*";
        $this->title=true;
        $this->titleField= [
            "id" => "ID",
            "username"=>  "Username",
            "point"=> "Số điểm",
            "name" => "Họ tên",
            "phone"=> "Số điện thoại",
            "address" => "Địa chỉ",
            "date_birth" => "Ngày sinh",
            "hktt" => "HKTT",
            "cmt" => "CMT",
            "stk" =>  "STK",
            "ctk" =>  "CTK",
            "bank" =>  "Tên ngân hàng",
            "bank_branch" =>  "Chi nhánh ngân hàng",
            "sex" =>  "Giới tính",
        ];
    }

    public function array(): array
    {
        $data=[];
       // dd($this->start,$this->end);
        $pay=$this->model->whereBetween('created_at',[$this->start,$this->end])->where(['status'=>1])->select($this->selectField)->get();
       if($pay->count()>0){
        foreach ($pay as $value) {
            $item=[];
            $item['id']=$value->id;
            $item['username']=$value->user->username?$value->user->username:'Chưa cập nhập';
            $item['point']=$value->point;
            $item['name']=$value->user->name?$value->user->name:'Chưa cập nhập';
            $item['phone']=$value->user->phone?$value->user->phone:'Chưa cập nhập';
            $item['address']=$value->user->address?$value->user->address:'Chưa cập nhập';
            $item['date_birth']=$value->user->date_birth?$value->user->date_birth:'Chưa cập nhập';
            $item['hktt']=$value->user->hktt?$value->user->hktt:'Chưa cập nhập';
            $item['cmt']=$value->user->cmt?$value->user->cmt:'Chưa cập nhập';
            $item['stk']=$value->user->stk?$value->user->stk:'Chưa cập nhập';
            $item['ctk']=$value->user->ctk?$value->user->ctk:'Chưa cập nhập';

            $item['bank']=$value->user->bank_id?$value->user->bank->name:'Chưa cập nhập';
            $item['bank_branch']=$value->user->bank_branch?$value->user->bank_branch:'Chưa cập nhập';
            $item['sex']=$value->user->sex==1?"Name":($value->user->sex===0?"Nữ":'Chưa cập nhập');
            array_push($data,$item);
        }
       }

       // dd($data);
        return $data;
    }
    // add title for file export
     public function headings(): array
     {
         if($this->title){
             return $this->titleField;
         }
         else{
             return [];
         }
     }
}

<?php
namespace App\Components;
class CheckExistDatabase{
    public function CheckExistFieldDatabase($model,$field,$fieldValue){
        if($model->where($field,$fieldValue)->count()){
            return true;
        }else{
            return false;
        }
    }

    // use collection helper contains() trả về true nếu $value tồn tại trong colection
    public function CheckArrayValueExistDatabase($data,$field,$fieldValueArray){
        foreach($fieldValueArray as $key=>$value){
          if(!$data->contains($field, $value)){
            return false;
          }
        }
        return true;
    }
}

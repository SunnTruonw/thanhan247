<?php

namespace App\Components;

class Recusive
{
    private $htmlselect;
    private $arrID;
    private $menu = [];
    private $i = 0;
    public function __construct()
    {
        # code...
        $this->htmlselect = "";
        $this->arrID = [];
    }
    // get category đệ quy
    // return <option>
    // @param $data : type colection
    // @param $id : integer id
    // @param $htmlselect : string chuỗi sẽ được trả về
    // @param $data : type string
    // exx output
    //   <option>cate1</option>
    //   <option>-cate1.1</option>
    //   <option>--cate1.1.1</option>
    //   <option>-cate1.2</option>
    //   <option>--cate1.2.1</option>
    //   <option>cate2</option>
    //   <option>-cate2.1</option>
    //   <option>cate3</option>
    public  function categoryRecusive($data, $id, $parentKey, $parentId = "", $startString = "", $text = "", $idCurrent = null)
    {

        foreach ($data as $value) {

            # code...
            if ($value[$parentKey] == $id) {
                if (!empty($parentId) && $value['id'] == $parentId) {
                    $startString .= "<option value='" . $value['id'] . "' " . 'selected ' . ($idCurrent == $value['id'] ? 'disabled' : '') . ">" . $text . $value["name"] . "</option>";
                } else {
                    $startString .= "<option value='" . $value['id'] . "' " . ($idCurrent == $value['id'] ? 'disabled' : '') . " >" . $text . $value["name"] . "</option>";
                }

                $startString .= $this->categoryRecusive($data, $value["id"], $parentKey, $parentId, "", $text . "---", $idCurrent);
            }
        }

        return $startString;
    }
    // function return arr
    // lấy toàn bộ ID đệ quy con của 1 id cha
    // tham số $data dữ liệu truyền vào
    // id là id của phần tử cần lấy child
    public  function categoryRecusiveAllChild($data, $id, $limit = null)
    {
       // dd($this->i);
       $k=$limit-1;
        if ($limit!==null) {
            foreach ($data as $value) {
                if ($k>=0) {
                    if ($value['parent_id'] == $id) {
                        $this->arrID[] = $value['id'];
                      //  echo $k;
                        $this->categoryRecusiveAllChild($data, $value["id"],$k);
                    }
                }else{
                    break;
                }
            }
        }else{
            foreach ($data as $value) {
                # code...
                if ($value['parent_id'] == $id) {
                    $this->arrID[] = $value['id'];
                    $this->categoryRecusiveAllChild($data, $value["id"]);
                }
            }
        }

        return $this->arrID;
    }

    // function return arr ['file'=>value,'child'=>[]]
    // lấy toàn bộ ID đệ quy con của 1 id cha
    // tham số $data dữ liệu truyền vào
    // id là id của phần tử cần lấy child
    public  function categoryModelRecusiveAllChild($data, $id,  $limit = null, $result = [])
    {
        // dd($this->i);
        $k = $limit - 1;
        $colect = $data->where('parent_id', $id);

        if ($colect->count() > 0) {
            ($data->forget(...$colect->keys()));
        }
        if ($limit !== null) {
            foreach ($colect as $value) {
                $child = $data->where('parent_id', $value->id);
                $value = $value->toArray();
                if ($k >= 0) {
                    $value['child'] = $this->categoryModelRecusiveAllChild($data, $value["id"], $k, []);
                    $result[] = $value;
                    //  echo $k;
                } else {
                    break;
                }
            }
        } else {
            foreach ($colect as $value) {
                # code...
                $child = $data->where('parent_id', $value->id);
                $value = $value->toArray();
                $value['child'] = $this->categoryModelRecusiveAllChild($data, $value["id"], null, []);
                $result[] = $value;
            }
        }



        return $result;
    }


    // function return arr
    // lấy toàn bộ ID đệ quy là cha của 1 id cha
    // tham số $data dữ liệu truyền vào
    // id là id của phần tử cần lấy child
    public  function categoryRecusiveAllParent($data, $id)
    {
        foreach ($data as $value) {
            # code...
            if ($value['id'] == $id && $value['parent_id'] != 0) {
                array_unshift($this->arrID, $value['parent_id']);
                //  $this->arrID[] = $value['parent_id'];
                $this->categoryRecusiveAllParent($data, $value["parent_id"]);
            }
        }
        return $this->arrID;
    }
}

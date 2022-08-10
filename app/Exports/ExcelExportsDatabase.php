<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExcelExportsDatabase implements FromCollection,WithHeadings
{
    private $model;
    private $excelfile;
    private $selectField;
    private $title;
    private $titleField;
    public function __construct($data)
    {
        $nameModel =$data['model'];
        $this->model= new $nameModel;
        $this->excelfile =$data['excelfile'];
        $this->selectField=$data['selectField'];
        $this->title=$data['title'];
        $this->titleField=$data['titleField'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return $this->model->select($this->selectField)->get();
    }
    // add title for file export
    public function headings(): array
    {
        if($this->title){
            return $this->selectField;
        }
        else{
            return [];
        }
    }
}

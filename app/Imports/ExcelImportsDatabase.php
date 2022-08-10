<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;
class ExcelImportsDatabase implements ToCollection
{

    private $model;
    private $excelfile;
    private $selectField;
    private $importField;
    private $totalField;
    private $fieldError;
    private $fieldSuccess;
    public function __construct($data)
    {
        $nameModel =$data['model'];
        $this->model= new $nameModel;
        $this->excelfile =$data['excelfile'];
        $this->selectField=$data['selectField'];
        $this->importField=$data['importField'];
        $this->totalField=0;
        $this->fieldError=[];
        $this->fieldSuccess=[];
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
       // dd($collection);
        foreach ($collection as $row)
        {
            $rowImport=[];
            foreach ($this->importField as $key=>$value){
                $rowImport[$value]= $row[$key];
            }
          //  dd($rowImport);

        //   try {


        //     } catch (\Exception $exception) {
        //         Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());

        //     }
            $this->model->create($rowImport);
        }
    }
}

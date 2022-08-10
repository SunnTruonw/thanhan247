<?php

namespace App\Services;

use App\Exceptions\GeneralException;

class CsvService
{
    protected $encodingFrom = 'utf-8';
    
    protected $encodingTo = 'SJIS-win';

    /**
     * Parse data from csv file
     *
     * @param string  $filePath  Path of Csv file
     * @param Array   $parrams   Parram of fields
     * @param boolean $hasUnique Return has unique or not
     *
     * @return $parsedDatas
     */
    public  function parseCsv($filePath, array $parrams, $hasUnique = true)
    {
        try {
            $file = fopen($filePath, "r");
            $titleData = fgetcsv($file);
            mb_convert_variables($this->getEncodingFrom(), $this->getEncodingTo(), $titleData);
            if (array_values($parrams) != array_values($titleData)) { 
                throw new GeneralException(trans('exceptions.backend.file.import_csv.fail'));
                \Log::error('Import Csv Fail for Reason: Title header Not Match');
            }
            
            while ($line = fgetcsv($file)) {
                $data[] = $line;
            }
            mb_convert_variables($this->getEncodingFrom(), $this->getEncodingTo(), $data);

            foreach ($parrams as $key => $value) {
                $posArr[$key] = array_search($value, $titleData);
            }

            $parsedDatas = [];
            foreach ($data as $row) {
                foreach ($posArr as $column => $posValue) {
                    $parsedData[$column] = trim($row[$posValue]) == '' ? null : trim($row[$posValue]);
                }
                if (array_filter($parsedData)) {
                    $parsedDatas[] = $parsedData;
                }
            }
            fclose($file);
            return $hasUnique ? $this->superUnique($parsedDatas) : $parsedDatas;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new GeneralException(trans('exceptions.backend.file.import_csv.fail'));
        }
    }


    private function convertCsvencodingDefault($string)
    {
        return mb_convert_variables('utf-8', 'SJIS-win', $titleData);
    }

    /**
     * Recursive array unique for multiarrays
     *
     * @param array $array Array
     *
     * @return array
     */
    function superUnique($array)
    {
        return array_map("unserialize", array_unique(array_map("serialize", $array)));
    }

    /**
     * Convert encoding fields
     *
     * @param array $data Data
     *
     * @return array
     */
    public function convertEncodingFields($data)
    {
        try {
            $newItem = array();
            foreach ($data as $item) {
                $newItem[] = mb_convert_encoding($item, 'SJIS-win', 'UTF-8');
            }
            return $newItem;
        } catch (Exception $ex) {
            \Log::error($ex);
        }
    }

    public function getEncodingFrom() {
        return $this->encodingFrom;
    }
    
    public function getEncodingTo() {
        return $this->encodingTo;
    }
}
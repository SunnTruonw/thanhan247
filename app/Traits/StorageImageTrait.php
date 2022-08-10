<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
trait StorageImageTrait
{
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
    public function storageTraitUpload($request, $fieldName, $folderName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->$fieldName;
            return $this->handleFile($file,$folderName);
        } else {
            return null;
        }
    }

    // lấy theo mảng
    // $i là chỉ số mảng file
    public function storageTraitUploadMutipleArray($request, $fieldName, $i, $folderName)
    {
        if ($request->hasFile($fieldName)) {
            if (count($request->$fieldName) >= $i + 1) {
                $file = $request->$fieldName[$i];
                return $this->handleFile($file,$folderName);
            }
        } else {
            return null;
        }
    }

    /*
     store image multiple upload and return null || array
     @param
     $file type Request->file(), data input
     $folderName type string; name of folder store
     return array
     [
         "file_name","file_path"
     ]
    */


    public function storageTraitUploadMutiple($file, $folderName)
    {
        return $this->handleFile($file,$folderName);
    }

    // kieemr tra su ton tai file
    public function checkFile($filePath)
    {
        $isExists = Storage::exists($filePath);
        return $isExists;
    }

    // convert link file to file goc trong storage
    public function makePathOrigin($path){
        $path = Str::after($path, '/storage');
        return 'public'.$path;
    }
    public function handleFile($file,$folderName){
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNamNotExtension =pathinfo($fileNameOrigin, PATHINFO_FILENAME);
        $fileExtension =$file->getClientOriginalExtension();
        //   $fileNameHash = Str::random(20) . "." . $file->getClientOriginalExtension();
        $fileNameHash =$fileNameOrigin;
        // file size tinh theo kb
        $fileSize = ceil($file->getSize());
        $i=1;
        $filePathCheck="public/" . $folderName . "/" . auth()->id()."/".$fileNameOrigin;

        while($this->checkFile($filePathCheck)){
            $fileNameHash = $fileNamNotExtension."_".$i.".".$fileExtension;
            $filePathCheck="public/" . $folderName . "/" . auth()->id()."/".$fileNameHash;
            $i++;
        }
        $filePath = $file->storeAs("public/" . $folderName . "/" . auth()->id(), $fileNameHash);
        $dataUploadTrait = [
            "file_name" => $fileNamNotExtension,
            "file_path" => Storage::url($filePath),
            "file_size"=> $fileSize,
        ];
        return $dataUploadTrait;
    }
}

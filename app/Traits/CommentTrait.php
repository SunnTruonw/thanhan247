<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
trait CommentTrait
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

    public function addComment($request, $fieldName, $folderName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->$fieldName;
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = Str::random(20) . "." . $file->getClientOriginalExtension();
            $filePath = $file->storeAs("public/" . $folderName . "/" . auth()->id(), $fileNameHash);
            $dataUploadTrait = [
                "file_name" => $fileNameOrigin,
                "file_path" => Storage::url($filePath),
            ];
            return $dataUploadTrait;
        } else {
            return null;
        }
    }

}

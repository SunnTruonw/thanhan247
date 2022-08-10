<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use App\Components\Recusive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 *
 */
trait DeleteRecordTrait
{
    public function deleteTrait($model, $id)
    {
        try {
            $data = $model->find($id);
            $data->delete();
            return response()->json([
                "code" => 200,
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function deleteFileTrait($model, $id, $field)
    {
        try {
            $item = $model->find($id);
            $path = $item->$field;
            if ($path) {
                Storage::delete($this->makePathDelete($path));
                $dataUpdate[$field] = null;
                $item->update($dataUpdate);
            }
            return response()->json([
                "code" => 200,
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function deleteCategoryRecusiveTrait($model, $id)
    {
        try {
            $recusive = new Recusive();
            $data = $model->get();
            $arrId = $recusive->categoryRecusiveAllChild($data, $id);
            array_push($arrId, $id);
            $model->destroy($arrId);
            return response()->json([
                "code" => 200,
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function deleteImageTrait($model, $id)
    {
        try {
            $path = $model->find($id)->image_path;
            Storage::delete($this->makePathDelete($path));

            //  dd(Storage::delete('public/product/7/jxiPJ1DNjul20uaE2AOG.jpg'));
            $model->find($id)->delete();
            return response()->json([
                "code" => 200,
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function makePathDelete($path)
    {
        $path = Str::after($path, '/storage');
        return 'public' . $path;
    }
}

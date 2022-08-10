<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Components\CheckExistDatabase;
use App\Models\CategoryProduct;

class AdminAjaxController extends Controller
{
    //
    private $categoryProduct;
    public function __construct(CategoryProduct $categoryProduct)
    {
        $this->categoryProduct = $categoryProduct;
    }
    public function getStrSlug(Request $request, $modelName)
    {
        switch ($modelName) {
            case 'categoryproduct':
                $model = $this->categoryProduct;
                break;
            default:
                $model = null;
                break;
        }
        if ($model !== null) {
            $checkExist = new CheckExistDatabase();
            $resultSlug = Str::slug($request->str);
            while ($checkExist->CheckExistFieldDatabase($this->categoryProduct, "slug", $resultSlug)) {
                $ran = random_int(1000, 10000);
                $resultSlug .= "-t" . $ran;
            }
        } else {
            return response()->json([
                "code" => 500,
                "resultSlug" => "",
                "message" => "fail"
            ], 500);
        }

        return response()->json([
            "code" => 200,
            "resultSlug" => $resultSlug,
            "message" => "success"
        ], 200);
    }
}

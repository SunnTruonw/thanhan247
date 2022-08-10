<?php

namespace App\Traits;


use App\Components\Recusive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 *
 */
trait ParagraphTrait
{
    // thêm paragraph trong add
    public function loadParagraph($request, $config)
    {
        $dataView = ['i' => $request->i];
        $dataView['configParagraph'] = $config;
        return response()->json([
            "code" => 200,
            "html" =>  view('admin.components.paragraph.add-paragraph', $dataView)->render(),
            "message" => "success"
        ], 200);
    }

    // load đoạn văn cha khi chọn kiểu đoạn văn
    public function loadParentParagraph($model, $modelParagraph, $id, $request)
    {
        if ($request->has('type') && $request->input('type')) {
            $item = $model->find($id);
            $htmlselect = $modelParagraph->getHtmlOption($item->paragraphs()->where('type', $request->input('type'))->get());
            return response()->json([
                "code" => 200,
                "html" =>  $htmlselect,
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }

    // load view tạo mới đoạn văn ajax
    public function loadCreateParagraph($model, $id, $config)
    {
        $dataView = [];
        $dataView['type'] = $config['type'];
        $item = $model->find($id);

        // dd($paragraph->program()->get());
        $dataView['urlStore'] = route($config['routeStore'], ['id' => $item->id]);
        $dataView['routeLoadParagraphType'] = route($config['routeLoadParent'], ['id' => $item->id]);
        // $dataView['htmlselect'] = $this->paragraph->getHtmlOption($program->paragraphs);

        if ($item) {
            return response()->json([
                "code" => 200,
                "html" =>  view('admin.components.paragraph.add-ajax-paragraph', $dataView)->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }

    // load view edit đoạn văn
    public function loadEditParagraph($modelParagraph, $config, $id)
    {
        $dataView = [];
        $dataView['type'] = $config['type'];
        $paragraph = $modelParagraph->find($id);
        // dd($paragraph->program()->get());
        $dataView['data'] = $paragraph;
        $dataView['urlUpload'] = route($config['routeUpdate'], ['id' => $paragraph->id]);
        $nameRelation = $config['nameRelation'];

        $dataView['routeLoadParagraphType'] = route($config['routeLoadParent'], ['id' => $paragraph->$nameRelation->id]);
        //  dd($paragraph->$nameRelation->paragraphs);
        //  dd($modelParagraph->where('type', $paragraph->type)->get());
        $dataView['htmlselect'] = $paragraph->getHtmlOptionEdit($paragraph->$nameRelation->paragraphs()
            ->where('type', $paragraph->type)->get(), '', $paragraph->id);

        if ($paragraph) {
            return response()->json([
                "code" => 200,
                "html" =>  view('admin.components.paragraph.edit-paragraph', $dataView)->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }

    public function storeParagraph($model, $config, $id, $request)
    {

        $rule = [
            "orderParagraphAdd" => "nullable|numeric",
            "parentIdParagraphAdd" => "nullable|numeric",
            "image_path_paragraph_add.*" => "mimes:jpeg,jpg,png,svg|nullable|file|max:3000",
            "activeParagraphAdd" => "required|numeric",
            "typeParagraphAdd" => "required",
        ];
        $langConfig = config('languages.supported');
        $langDefault = config('languages.default');
        foreach ($langConfig as $key => $value) {
            $arrConlai = $langConfig;
            unset($arrConlai[$key]);
            $keyConlai = array_keys($arrConlai);
            $keyConlai = collect($keyConlai);
            $rule['nameParagraphAdd_' . $key] = "required|min:3|max:250";
        }

        $validator = Validator::make($request->all(), $rule);

        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $item = $model->find($id);

                if ($request->has('typeParagraphAdd') && $request->input('typeParagraphAdd')) {
                    $dataParagraphCreateItem = [];
                    $dataParagraphCreateItem = [
                        "active" => $request->input('activeParagraphAdd'),
                        "type" => $request->input('typeParagraphAdd'),
                        "parent_id" => $request->input('parentIdParagraphAdd') ?? 0,
                        "order" => $request->input('orderParagraphAdd') ?? 0,
                        "admin_id" => auth()->guard('admin')->id()
                    ];

                    //  dd(count($request->image_path_paragraph));
                    //dd($request->hasFile('image_path_paragraph[0]'));
                    $dataUploadParagraphAvatar = $this->storageTraitUpload($request, "image_path_paragraph_add", "program");
                    if (!empty($dataUploadParagraphAvatar)) {
                        $dataParagraphCreateItem["image_path"] = $dataUploadParagraphAvatar["file_path"];
                    }
                    $paragraph = $item->paragraphs()->create(
                        $dataParagraphCreateItem
                    );
                    // insert data paragraph lang
                    $dataParagraphTranslation = [];
                    //  dd($this->langConfig);
                    foreach ($this->langConfig as $keyL => $valueL) {
                        $itemParagraphTranslation = [];
                        $itemParagraphTranslation['name'] = $request->input('nameParagraphAdd_' . $keyL);
                        $itemParagraphTranslation['value'] = $request->input('valueParagraphAdd_' . $keyL);
                        $itemParagraphTranslation['language'] = $keyL;
                        //  dd($itemTranslation);
                        $dataParagraphTranslation[] = $itemParagraphTranslation;
                    }
                    // dd($dataParagraphTranslation);
                    $paragraphTranslation =   $paragraph->translations()->createMany($dataParagraphTranslation);
                    //  dd($paragraphTranslation);

                    //  $program->paragraphs()->attach($paragraph->id);

                    //  dd($program->paragraphs);

                    //dd($dataParagraphCreateItem);
                    //   $tagInstance = $this->paragraph->firstOrCreate($dataParagraphCreateItem);
                }


                DB::commit();
                $nameRelation = $config['nameRelation'];
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.paragraph.load-list-paragraph', [
                        'data' => $paragraph->$nameRelation,
                        'configParagraph' => $config,
                    ])->render(),
                    'messange' => 'success'
                ], 200);
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    'code' => 500,
                    'messange' => 'error'
                ], 500);
            }
        } else {
            return response()->json([
                'code' => 200,
                'htmlErrorValidate' => view('admin.components.load-error-ajax', [
                    "errors" => $validator->errors()
                ])->render(),
                'messange' => 'success',
                'validate' => true
            ], 200);
        }
    }

    public function updateParagraph($modelParagraph, $config, $id, $request)
    {
        $rule = [
            "typeParagraphEdit" => "required",
            "activeParagraphEdit" => "required|numeric",
            "parentIdParagraphEdit" => "nullable|numeric",
            "orderParagraphEdit" => "nullable|numeric",
            "image_path_paragraph_edit.*" => "mimes:jpeg,jpg,png,svg|nullable|file|max:3000",
        ];
        $langConfig = config('languages.supported');
        $langDefault = config('languages.default');
        foreach ($langConfig as $key => $value) {
            $arrConlai = $langConfig;
            unset($arrConlai[$key]);
            $keyConlai = array_keys($arrConlai);
            $keyConlai = collect($keyConlai);
            $rule['nameParagraphEdit_' . $key] = "required";
        }

        $validator = Validator::make($request->all(), $rule);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $dataParagraphUpdate = [
                    "active" => $request->input('activeParagraphEdit'),
                    "type" => $request->input('typeParagraphEdit'),
                    "parent_id" => $request->input('parentIdParagraphEdit') ?? 0,
                    "order" => $request->input('orderParagraphEdit') ?? 0,
                    "admin_id" => auth()->guard('admin')->id()
                ];

                $dataUploadImage = $this->storageTraitUpload($request, "image_path_paragraph_edit", "paragraph");
                //  dd($dataUploadImage);
                if (!empty($dataUploadImage)) {
                    $path = $modelParagraph->find($id)->image_path;
                    if ($path) {
                        Storage::delete($this->makePathDelete($path));
                    }
                    $dataParagraphUpdate["image_path"] = $dataUploadImage["file_path"];
                }
                //  dd($dataParagraphUpdate);
                // insert database in paragraph table
                $modelParagraph->find($id)->update($dataParagraphUpdate);
                $paragraph = $modelParagraph->find($id);
                //  dd($paragraph->type);
                // insert data product lang
                $dataParagraphTranslationUpdate = [];
                foreach ($this->langConfig as $key => $value) {
                    $itemParagraphTranslationUpdate = [];
                    $itemParagraphTranslationUpdate['name'] = $request->input('nameParagraphEdit_' . $key);
                    $itemParagraphTranslationUpdate['value'] = $request->input('valueParagraphEdit_' . $key);

                    $itemParagraphTranslationUpdate['language'] = $key;

                    if ($paragraph->translationsLanguage($key)->first()) {
                        $paragraph->translationsLanguage($key)->first()->update($itemParagraphTranslationUpdate);
                    } else {
                        $paragraph->translationsLanguage($key)->create($itemParagraphTranslationUpdate);
                    }
                }

                $listIdChild = $paragraph->getALlCategoryChildren($paragraph->id);
                $paragraph->whereIn('id', $listIdChild)->update(['type' => $paragraph->type]);
                //  dd($paragraph->program()->get());
                DB::commit();
                $nameRelation = $config['nameRelation'];
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.paragraph.load-list-paragraph', [
                        'data' => $paragraph->$nameRelation,
                        'configParagraph' => $config,
                    ])->render(),
                    'messange' => 'success'
                ], 200);
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    'code' => 500,
                    'messange' => 'error'
                ], 500);
            }
        } else {
            return response()->json([
                'code' => 200,
                'htmlErrorValidate' => view('admin.components.load-error-ajax', [
                    "errors" => $validator->errors()
                ])->render(),
                'messange' => 'success',
                'validate' => true
            ], 200);
        }
    }
}

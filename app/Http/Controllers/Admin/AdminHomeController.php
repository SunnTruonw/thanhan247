<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Post;
use App\Models\User;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;

use App\Models\Setting;
use App\Models\Slider;
use App\Models\Menu;
use App\Models\Attribute;
use App\Models\CategoryGalaxy;
use App\Models\CategoryProgram;
use App\Models\Program;
use App\Models\CategoryExam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminHomeController extends Controller
{
    //
    private $transaction;
    private $user;
    private $product;
    private $post;
    private $listStatus;
    private $contact;
    private $categoryPost;
    private $categoryProduct;
    private $categoryProgram;
    private $categoryGalaxy;
    private $program;
    private $setting;
    private $slider;
    private $menu;
    private $attribute;
    private $categoryExam;
    public function __construct(
        Transaction $transaction,
        User $user,
        Post $post,
        Product $product,
        Contact $contact,
        CategoryPost $categoryPost,
        CategoryProduct $categoryProduct,
        CategoryProgram $categoryProgram,
        Program $program,
        Setting $setting,
        Slider $slider,
        Menu $menu,
        Attribute $attribute,
        CategoryGalaxy $categoryGalaxy,
        CategoryExam $categoryExam
    ) {
        $this->middleware('auth:admin');
        $this->transaction = $transaction;
        $this->listStatus = $this->transaction->listStatus;
        $this->user = $user;
        $this->post = $post;
        $this->product = $product;
        $this->contact = $contact;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
        $this->setting = $setting;
        $this->slider = $slider;
        $this->menu = $menu;
        $this->attribute = $attribute;
        $this->categoryProgram = $categoryProgram;
        $this->program = $program;
        $this->categoryGalaxy = $categoryGalaxy;
        $this->categoryExam = $categoryExam;
    }

    public function index()
    {
        $totalTransaction = $this->transaction->count();
        $totalMember = $this->user->count();
        $totalProduct = $this->product->count();
        $totalPost = $this->post->count();
        $countTransaction = [];
        // lấy số giao dịch đã bị hủy bỏ
        $countTransaction['-1'] = $this->transaction->where([
            ['status', '=', '-1'],
        ])->count();
        // lấy số lượng đơn hàng đã đặt hàng thành công
        $countTransaction['1'] = $this->transaction->where([
            ['status', '=', '1'],
        ])->count();
        // lấy số giao dịch đã tiếp nhận
        $countTransaction['2'] = $this->transaction->where([
            ['status', '=', '2'],
        ])->count();
        // lấy số giao dịch đang vận chuyển
        $countTransaction['3'] = $this->transaction->where([
            ['status', '=', '3'],
        ])->count();
        // lấy số giao dịch đã hoàn thành
        $countTransaction['4'] = $this->transaction->where([
            ['status', '=', '4'],
        ])->count();

        // lấy 20 giao dịch mới nhất chưa được xử lý
        // trạng thái là 1 2 3
        $newTransaction = $this->transaction->whereIn('status', [1, 2, 3])->orderByDesc('created_at')->limit(20)->get();
        $topPayProduct = $this->product->orderByDesc('pay')->get();

        // lấy số contact
        $countContact = $this->contact->count();


        // lấy bài viết mới nhất
        $listCategoryPost = $this->categoryPost->getALlCategoryChildrenAndSelf(21);
        //  dd($listCategoryPost);
        $postNews = $this->post->whereIn('category_id', $listCategoryPost)->orderBy('created_at')->limit(10)->get();

        $listCategoryProduct = $this->categoryProduct->getALlCategoryChildrenAndSelf(7);
        // dd($listCategoryProduct);
        $productNews = $this->product->whereIn('category_id', $listCategoryProduct)->orderBy('created_at')->limit(10)->get();

        // dd($postNews);
        //  dd($countContact);

        $postDaduyet=$this->post->where('status',3)->latest()->limit(20)->get();
        $postChoDuyet=$this->post->where('status',2)->latest()->limit(20)->get();
        $postTraLai=$this->post->where('status',4)->latest()->limit(20)->get();

        return view("admin/pages/index", [
            'totalTransaction' => $totalTransaction,
            'totalMember' => $totalMember,
            'totalProduct' => $totalProduct,
            'totalPost' => $totalPost,
            'countTransaction' => $countTransaction,
            'newTransaction' => $newTransaction,
            'topPayProduct' => $topPayProduct,
            'listStatus' => $this->listStatus,
            'countContact' => $countContact,
            'postNews' => $postNews,
            'productNews' => $productNews,
            'postDaduyet'=>$postDaduyet,
            'postChoDuyet'=>$postChoDuyet,
            'postTraLai'=>$postTraLai,
        ]);
    }

    public function loadOrderVeryModel($table, $id, Request $request)
    {

        switch ($table) {
            case 'sliders':
                $model = $this->slider;
                break;
            case 'settings':
                $model = $this->setting;
                break;
            case 'category_products':
                $model = $this->categoryProduct;
                break;
            case 'category_posts':
                $model = $this->categoryPost;
                break;
            case 'posts':
                $model = $this->post;
                break;
            case 'products':
                $model = $this->product;
                break;
            case 'category_programs':
                $model = $this->categoryProgram;
                break;
            case 'programs':
                $model = $this->program;
                break;
            case 'menus':
                $model = $this->menu;
                break;
            case 'attributes':
                $model = $this->attribute;
                break;
            case 'category_galaxies':
                $model = $this->categoryGalaxy;
                break;
            case 'category_exams':
                $model = $this->categoryExam;
                break;
            default:
                $model = null;
                break;
        }
        //   dd($model);
        if ($model) {
            try {
                DB::beginTransaction();

                $dataUpdate = [
                    "order" => $request->input('order'),
                    "admin_id" => auth()->guard('admin')->id()
                ];
                $model->find($id)->update($dataUpdate);
                DB::commit();
                return response()->json([
                    "code" => 200,
                    "html" => 'Sửa số thứ tự thành công',
                    "message" => "success"
                ], 200);
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    "code" => 500,
                    "message" => "fail"
                ], 500);
            }
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}

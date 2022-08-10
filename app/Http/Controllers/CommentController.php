<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;

class CommentController extends Controller
{
    //

    use StorageImageTrait, DeleteRecordTrait;
    private $product;
    private $productComment;
    private $post;
    private $comment;
    private $postComment;

    public function __construct(Product $product, ProductComment $productComment, Post $post, Comment $comment, PostComment $postComment)
    {
        $this->product = $product;
        $this->productComment = $productComment;
        $this->post = $post;
        $this->comment = $comment;
        $this->postComment = $postComment;
    }

    public function store($type, $id, Request $request)
    {

        //  dd( $id);
        switch ($type) {
            case 'product':
                $commentOf = $this->product->find($id);

                break;
            case 'post':
                $commentOf = $this->post->find($id);

                break;
            default:
                return;
                break;
        }
        try {
            DB::beginTransaction();
            $dataCommentCreate = [
                "content" => $request->input('content'),
                "like" => $request->input('like') ?? 0,
                "share" => $request->input('share') ?? 0,
                "parent_id" => $request->input('parent_id') ?? 0,
                'user_id' => auth()->check() ? auth()->user()->id : 0,
            ];
            $dataUploadImage = $this->storageTraitUpload($request, "image_path", "comment");
            if (!empty($dataUploadImage)) {
                $dataCommentCreate["image_path"] = $dataUploadImage["file_path"];
            }
          //  dd($dataCommentCreate);
          // insert database in comments table by createMany
            $commentOf->comments()->create($dataCommentCreate);

            DB::commit();
            return "thành công";
            return redirect()->route('admin.product.create')->with("alert", "Thêm sản phẩm thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.product.create')->with("error", "Thêm sản phẩm không thành công");
            return "thất b";
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Models\Product;
use App\Models\Comment;
class CommentController extends Controller
{
    public function authLogin(){
        if(Auth::id()){
            return \redirect('dashboard');
        }else{
            return \redirect('admin')->send();
        }
    }

    public function allComment(){
        //comment_parent = 0 là cmt của người dùng
        $allComment = Comment::with('product')
            ->where('comment_parent','=',0)->orderby('comment_status','ASC')->get(); // comment chưa được duyệt lên trước

        //coment_parent != 0 là reply của admin
        $commentReply = Comment::where('comment_parent','!=',0)->get();
        return view('admin.comment.allComment')->with(compact('allComment','commentReply'));
    }
    public function approvalComment(Request $req){
        Comment::find($req->commentId)->update(['comment_status'=>$req->commentStatus]);
    }

    public function replyComment(Request  $req){
        $comment = new Comment();
        $comment->comment_name = "Admin"; // admin trả lời comment
        $comment->product_id = $req->productId; // cái comment admin trả lời thuộc product
        $comment->comment_parent = $req->commentId; // cái comment mà admin trả lời
        $comment->comment_status = 1; // được hiển thị
        $comment->comment_content = $req->replyContent; // nội dung trả lời của admin
        //lưu lại
        $comment->save();
    }

   public function deleteComment($commentId){
        //xóa commnet mà admin trả lời luôn
        Comment::where('comment_parent',$commentId);
        Comment::find($commentId)->delete();

       return \redirect()->back()->with('Deleted comment successfully!');
    }



    ///end ADMIN PAGES

    public function loadComment(Request $req){
        //luoon nhớ phải khi không thấy data load ra thì xem lại mình có quên hàm get() để lấy dữ liệu không
        //comment_parent = 0 là cmt của người dùng
        $commentByProduct = Comment::where('product_id',$req->productId)
            ->where('comment_status',1)->where('comment_parent','=',0)->get();

        //coment_parent != 0 là reply của admin
        $commentReply = Comment::where('comment_parent','!=',0)->get();
        $output ='';
        foreach ($commentByProduct as $key => $comment){

                $output .= '  <div class="flex-w flex-t p-b-68">
                                            <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                <img src="'.url('/public/frontend2/images/avatar-01.jpg').'" alt="AVATAR">
                                            </div>

                                            <div class="size-207">
                                                <div class="flex-w flex-sb-m p-b-17">
													<span class="mtext-107 cl2 p-r-20">
														'.$comment->comment_name.'  '.$comment->comment_date.'
													</span>

                                                    <span class="fs-18 cl11">
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star-half"></i>
													</span>
                                                </div>

                                                <p class="stext-102 cl6">
                                                     '.$comment->comment_content.'
                                                </p>
                                            </div>
                                        </div>';

            //vòng này để select coi cmt của người dùng này có admin reply không
                foreach ($commentReply as $a =>$reply) {
                    if($reply->comment_parent == $comment->comment_id){
                        $output .= '
                   <div class="flex-w flex-t p-b-68" style="margin-left: 55px;margin-top: -50px;">
                                            <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                <img src="'. url('public/frontend/images/admin2.jpg') .'" alt="AVATAR">
                                            </div>

                                            <div class="size-207">
                                                <div class="flex-w flex-sb-m p-b-17">
													<span class="mtext-107 cl2 p-r-20">
														@Admin  '. $reply->comment_date .'
													</span>
                                                </div>

                                                <p class="stext-102 cl6">
                                                   '.$reply->comment_content.'
                                                </p>
                                            </div>

                                        </div>';
                    }
                }


        }
        echo $output;
    }



    public function sendComment(Request $req){
        $comment = new Comment();
        $comment->comment_name = $req->commentName; //tên người bình luận
        $comment->comment_content = $req->commentContent; // nội dung bình luận
        $comment->product_id = $req->productId; //Sản phẩm bình luận
        $comment->comment_status = 0; // bình luận đang chờ duyệt
        $comment->comment_parent = 0; // cái này cho bằng 0 , dùng để cho admin tl comment, admin tl comment thì cần có commentid để lưu vào thì mới biết admin trả comment nào
        // không cần ngày vì đã set kiểu timestamps tự động lấy ngày giời hiện tại khi thêm rồi
        $comment->save(); //lưu lại
    }
}

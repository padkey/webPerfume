<?php

namespace App\Http\Controllers;

use DB;
use App\Models\CatePost;
use App\Models\Post;
//sử dung session
use Illuminate\Database\Eloquent\Model;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Auth;

class PostController extends Controller
{
    public function authLogin(){
        $adminId = Auth::id();
        if($adminId){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function allPost(){

        $allPost = Post::with('catePost')->orderby('post_id','DESC')->paginate(10);
        return view('admin.post.allPost')->with(compact('allPost'));
    }
    public function addPost(){
        $allCategoryPost = CatePost::orderby('category_post_id','DESC')->get();
        return view('admin.post.addPost')->with(compact('allCategoryPost'));
    }
    public function savePost(Request $req){
            $post = new Post();
            $post->post_title = $req->postTitle;
            $post->post_slug = $req->postSlug;
            $post->post_des = $req->postDes;
            $post->post_content = $req->postContent;
            $post->post_meta_des =$req->metaDes;
            $post->post_meta_keywords = $req->metaKeywords;
            $post->post_status = $req->postStatus;
            $post->cate_post_id = $req->categoryPostId;
            $getImage = $req->file('postImage');
            if($getImage){
                $getFullName = $getImage->getClientOriginalName();
                $getName = current(explode('.',$getFullName));
                $newName = $getName.rand(0,99).'.'.$getImage->getClientOriginalExtension();

                $getImage->move('public/uploads/posts',$newName);

                $post->post_image = $newName;
                $post->save();

            }
        return \redirect()->back()->with('message','Added Post successfully!');
    }
    public function editPost($postId){
        $editPost = Post::find($postId);
        $allCategoryPost = CatePost::orderby('category_post_id','DESC')->get();

        return view('admin.post.editPost')->with(compact('editPost','allCategoryPost'));
    }
    public function updatePost(Request $req){
        $post =  Post::find($req->postId);
        $post->post_title = $req->postTitle;
        $post->post_slug = $req->postSlug;
        $post->post_des = $req->postDes;
        $post->post_content = $req->postContent;
        $post->post_meta_des =$req->metaDes;
        $post->post_meta_keywords = $req->metaKeywords;
        $post->cate_post_id = $req->categoryPostId;
        $getImage = $req->file('postImage');
        if($getImage){
            //xóa ảnh cũ đi
            $oldImage = $post->post_image;
            unlink('public/uploads/posts/'.$oldImage);

            //cập nhật ảnh mới
            $getFullName = $getImage->getClientOriginalName();
            $getName = current(explode('.',$getFullName));
            $newName = $getName.rand(0,99).'.'.$getImage->getClientOriginalExtension();

            $getImage->move('public/uploads/posts',$newName);

            $post->post_image = $newName;


        }
        $post->save();
        return \redirect()->back()->with('message','Updated Post successfully!');
    }
    public function unactivePost($postId){
            Post::find($postId)->update(['post_status'=>0]);
            return \redirect()->back()->with('message','unactived Post successfully');
    }
    public function activePost($postId){
        Post::find($postId)->update(['post_status'=>1]);
        return \redirect()->back()->with('message','Actived Post successfully');
    }
    public function deletePost($postId){
            $post = Post::find($postId);

            $postImage = $post->post_image;
            //xóa hình trong source
        unlink('public/uploads/posts/'.$postImage);
        //xóa bài viết
            $post->delete();
            return \redirect()->back()->with('message','Deleted post successfully');
    }

    // =========================== END ADMIN PAGE ===============================

    public function listPostByCate(Request $req,$categoryPostSlug){

        //lấy ra danh mục để điền vào seo
        $catePost = CatePost::where('category_post_slug',$categoryPostSlug)->first();
        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = $catePost->category_post_des; // là mô tả ngắn gọn về trang
        $metaKeywords =  $catePost->category_post_slug;  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = $catePost->category_post_name; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        $shareImage = url('/public/frontend/images/blog.jpg'); //hình ảnh hiện ra ở bài viết mình share trên fb
        // ----------- End Seo -----------\\

        $allPostByCate = Post::with('catePost')
            ->where('post_status',1)
            ->where('cate_post_id',$catePost->category_post_id)
            ->orderBy('post_id','Desc')
            ->paginate(5);
        return view('pages.post.listPostByCate')->with(compact('shareImage','metaDes','metaKeywords','metaTitle','urlCanonical','allPostByCate'));

    }

    public function postDetail(Request $req,$postSlug){

        $postDetail = Post::with('catePost')->where('post_slug',$postSlug)->first();
        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = $postDetail->post_meta_des;
        $metaKeywords =  $postDetail->post_meta_keywords;  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = $postDetail->post_title; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        $shareImage = url('/public/uploads/posts/'.$postDetail->post_image);
        // ----------- End Seo -----------\\

        //cập nhật lượt xem cho bài viết
        $postDetail->post_views = $postDetail->post_views +1;
        $postDetail->save();
        $postRelated = Post::where('cate_post_id',$postDetail->cate_post_id)
            ->where('post_status',1)
            ->whereNotIn('post_slug',[$postDetail->post_slug])
            ->get();

        return view('pages.post.postDetail')->with(compact('shareImage','postRelated','metaDes','metaKeywords','metaTitle','urlCanonical','postDetail'));
}


}

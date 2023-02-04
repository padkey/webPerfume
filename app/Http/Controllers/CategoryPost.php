<?php

namespace App\Http\Controllers;

use DB;
use App\Models\CatePost;
//sử dung session
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Auth;

class CategoryPost extends Controller
{
    public function authLogin(){
        $adminId = Auth::id();
        if($adminId){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function addCategoryPost(){
        return view('admin.categoryPost.addCategoryPost');
    }
    public function saveCategoryPost(Request $req){
        $this->authLogin();
        $categoryPost = new CatePost();
        $categoryPost->category_post_name = $req->categoryName;
        $categoryPost->category_post_des = $req->categoryDes;
       $categoryPost->category_post_slug = $req->categorySlug;
        $categoryPost->category_post_status = $req->categoryStatus;
         $categoryPost->meta_keywords = $req->metaKeywords;
        $categoryPost->save();
        return \redirect()->back()->with('message','Added category post successfully');
    }
    public function allCategoryPost(){
        $this->authLogin();
        $allCategoryPost = CatePost::orderby('category_post_id','DESC')->paginate(5);

        return view('admin.categoryPost.allCategoryPost')->with(compact('allCategoryPost'));
    }
    public function editCategoryPost($categoryPostId){
        $this->authLogin();
        $categoryPost = CatePost::find($categoryPostId);

        return view('admin.categoryPost.editCategoryPost')->with(compact('categoryPost'));
    }
    public function updateCategoryPost(Request $req){
        $categoryPost =  CatePost::find($req->categoryId);
        $categoryPost->category_post_name = $req->categoryName;
        $categoryPost->category_post_des = $req->categoryDes;
        $categoryPost->category_post_slug = $req->categorySlug;
        $categoryPost->meta_keywords = $req->metaKeywords;
        $categoryPost->save();
        return \redirect('allCategoryPost')->with('message','Updated category post successfully');

    }
    public function unactiveCategoryPost($categoryId){
        $this->authLogin();
        // điều kiện là $categoryId = category_id trong datebase , nếu bằng thì ta update nó
        CatePost::find($categoryId)->update(['category_post_status'=>0]);
        Session::put('message',' Category post unactivation successful');
        return Redirect('allCategoryPost');
    }
    public function activeCategoryPost($categoryId){
        $this->authLogin();
        // điều kiện là $categoryId
        CatePost::find($categoryId)->update(['category_post_status'=>1]);
        Session::put('message','Category post actived successfully');
        return Redirect('allCategoryPost');
    }
    public function deleteCategoryPost($categoryId){
        CatePost::find($categoryId)->delete();
        Session::put('message','Deleted Category Post successfully');
        return Redirect('allCategoryPost');
    }
    public function categoryPost(){

    }
}

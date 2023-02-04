<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatePost extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['category_post_name','category_post_des','category_post_slug','category_post_status'];
    protected $primaryKey = 'category_post_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_category_post';

    //một danh mục chứa nhiều bài viết
    public function post(){
        return $this->hasMany('App\Models\Post');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['post_title','post_views','post_des','post_content','post_meta_des','post_meta_keywords','post_status','post_image','cate_post_id','post_slug'];
    protected $primaryKey = 'post_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_posts';
    public function catePost(){
        return $this->belongsTo('App\Models\CatePost','cate_post_id');
    }
}

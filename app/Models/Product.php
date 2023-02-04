<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   public $timestamps = false;
   protected $fillable = ['product_name','product_views','product_tags','product_quantity','product_cost','product_price','product_slug','category_id','brand_id','product_des','product_content','product_image','product_status'];
   protected $primaryKey = 'product_id';
   protected $table = 'tbl_product';

   //một sản phảm có nhiều comment
   public function comment(){
       return $this->hasMany('App\Models\Comment');
   }
   //một sản phẩm chỉ thuộc về 1 category
    public function category(){
       return $this->belongsTo('App\Models\Category','category_id');
       //category_id này là ở trong tbl_product so sánh với khóa chính với tbl_category
    }
    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
}

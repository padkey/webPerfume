<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   public $timestamps = false;
   protected $fillable = ['product_name','product_quantity','product_price','product_slug','category_id','brand_id','product_des','product_content','product_image','product_status'];
   protected $primaryKey = 'product_id';
   protected $table = 'tbl_product';
}

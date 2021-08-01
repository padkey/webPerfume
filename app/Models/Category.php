<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $fillable = ['category_name','category_des','category_slug','meta_keywords','category_status'];
    protected $primaryKey = 'category_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_category_product';
}

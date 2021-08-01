<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false;
    protected $fillable = ['brand_name','brand_des','brand_status'];
    protected $primaryKey = 'brand_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_brand';
}

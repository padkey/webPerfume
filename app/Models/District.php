<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //use HasFactory;
    public $timestamps = false;
    protected $fillable = ['district_name','type','province_id'];
    protected $primaryKey = 'district_id';
    protected $table = 'tbl_district';
}

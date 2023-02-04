<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    public $timestamps = false;
    protected $fillable = ['ward_name','type','district_id'];
    protected $primaryKey ='ward_id';
    protected $table = 'tbl_ward';
}

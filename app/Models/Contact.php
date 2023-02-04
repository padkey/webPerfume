<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['info_address','info_phone','info_map','info_logo','info_fanpage'];
    protected $primaryKey = 'info_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_information';
}

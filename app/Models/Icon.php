<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['icon_name','icon_image','icon_link'];
    protected $primaryKey = 'icon_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_icons';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['video_title','video_des','video_link','video_slug','video_image'];
    protected $primaryKey = 'video_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_videos';
}

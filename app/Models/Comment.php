<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $timestamps = false;  // phải thêm dòng này vào không là lỗi unnoknow updated_at
    protected $fillable = ['comment_name','comment_content','product_id','comment_date','comment_status','comment_parent'];
    protected $primaryKey = 'comment_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_comment';
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
}

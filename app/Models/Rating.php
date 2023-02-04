<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['rating','product_id'];
    protected $primaryKey = 'rating_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_rating';
}

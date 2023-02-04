<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['order_date','sales','profit','quantity','total_order'];
    protected $primaryKey = 'statistical_id'; // set khóa chính, mặc định nó hiểu là id
    protected $table = 'tbl_statistical';
}

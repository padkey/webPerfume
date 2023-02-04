<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['order_status_id','order_status_name'];
    protected $primaryKey = 'order_status_id';
    protected $table = 'tbl_order_status';

}

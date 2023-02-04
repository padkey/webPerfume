<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable= ['customer_id','order_amount','shipping_id','shipping_method_code','payment_method_code','order_status','order_code','order_date','created_at'];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';

    public function orderStatus(){
        return $this->belongsTo('App\Models\OrderStatus','order_status');
    }
}

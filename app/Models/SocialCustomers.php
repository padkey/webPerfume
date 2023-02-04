<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialCustomers extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['provider_user_id','provider_user_email','provider','user'];//provider_user_id chứa id account của google trả về
    protected $primaryKey = 'user_id';
    protected $table = 'tbl_social_customers';

    public function customer(){
        return $this->belongsTo('App\Models\Customer','user'); //user là id customer
    }
}

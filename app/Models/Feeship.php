<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false;
    protected $fillable = ['fee_matp','fee_maqh','fee_xaid','fee_feeShip'];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_feeship';
    public function city(){
        // có nghĩa là lấy id của City đem so sánh với fee_matp để lấy ra dữ liêuk
        return $this->belongsTo('App\Models\Province','fee_matp');
    }
    public function province(){
        //lấy id của province đối chiếu với fee_maqh để lấy dữ liệu
        return $this->belongsTo('App\Models\District','fee_maqh');
    }
    public function wards(){
        // lấy id của wards để đối chiếu với fee_xaid để lấy dữ liệu
        return $this->belongsTo('App\Models\Ward','fee_xaid');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
class RatingController extends Controller
{
    //
    public function  insertRating(Request $req){
        $rating = new Rating();
        $rating->product_id = $req->productId;
        $rating->rating = $req->index; // index là số sao người dùng đánh giá
        $rating->save();
    }
}

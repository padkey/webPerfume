<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportProduct implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'product_name' => $row[0],
            'product_price'=>$row[1],
            'product_slug'=>$row[2],
            'category_id'=>$row[3],
            'brand_id'=>$row[4],
            'product_des'=>$row[5],
            'product_content'=>$row[6],
            'product_image'=>$row[7],
            'product_status'=>$row[8],
        ]);
    }
}

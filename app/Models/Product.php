<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function getList() {
        // productsテーブルからデータを取得
        $products = Product::with('company');
        return $products;
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function store($Request , $image_path) {
        Product::create([
        'company_id' => $Request->input('company_id'),
        'product_name' => $Request->input('product_name'),
        'price' => $Request->input('price'),
        'stock' => $Request->input('stock'),
        'comment' => $Request->input('comment'),
        'img_path' => $image_path, 
      ]);
    }

    public function updateProduct($id , $Request , $image_path) {
        Product::where('id', $id)->update([
        'company_id' => $Request->input('company_id'),
        'product_name' => $Request->input('product_name'),
        'price' => $Request->input('price'),
        'stock' => $Request->input('stock'),
        'comment' => $Request->input('comment'),
        'img_path' => $image_path, 
      ]);
    }
}

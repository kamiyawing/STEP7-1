<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productModel = new Product();
        $salesModel = new Sale();
        
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

            //　トランザクション
        DB::beginTransaction();
        try {   
            $product = $productModel->lockForUpdate()->find($productId); // 排他ロックをかける

            if (!$product) {
                throw ValidationException::withMessages(['product_id' => "商品が見つかりません"]);
            }

            if ($product->stock < $quantity) {
                throw ValidationException::withMessages(['quantity' => "商品ID {$productId} の在庫が{$product->stock}個しかないため、{$quantity}個購入することはできません。"]);
            }
            $product->stock -= $quantity;

            $productModel->sale($productId, $product->stock);

            $salesModel->store($productId);

            DB::commit();
            return response()->json(['message' => '購入が完了しました'], 201);

            // バリデーションエラー発生時のエラー処理
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);

            // その他すべてのエラー発生時の処理
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => 'サーバーエラー'], 500);
        }
    }
}

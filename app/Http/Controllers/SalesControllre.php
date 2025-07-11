<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::find($request->product_id);

            if ($product->stock < $request->quantity) {
                return response()->json([
                    'message' => '在庫が足りません。購入できません。'
                ], 400);
            }

            // 在庫を減らす
            $product->stock -= $request->quantity;
            $product->save();

            // 購入記録を保存
            $sale = Sale::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);

            return response()->json([
                'message' => '購入処理が完了しました。',
                'sale' => $sale,
            ]);
        });
    }
}

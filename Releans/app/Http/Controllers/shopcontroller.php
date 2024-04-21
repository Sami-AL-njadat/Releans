<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\stockTracking;
use App\Models\sales;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Product;

class shopcontroller extends Controller
{
    public function index()
    {
        return view('page.shop.page.shop');
    }


    public function show()
    {
        return view('page.shop.page.selectproduct');
    }


    public function sale(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|min:0|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $saleQuant = $request->quantity;

        $product = Product::findOrFail($id);

        if ($saleQuant > $product->quantity) {
            return response()->json([
                'status' => 420,
                'message' => 'Sale quantity exceeds available quantity'
            ], 420);
        }




        $stock = new StockTracking();
        $stock->product_id = $id;
        $stock->type = 'deduction';
        $stock->quantities = $saleQuant;
        $stock->reason = 'transaction sale';
        $stock->description = 'Order placed by user: ' . $user->name;
        $stock->save();

        $sale = new Sales();
        $sale->user_id = $user->id;
        $sale->product_id = $id;
        $sale->trans_id = $stock->id;
        $sale->total_price = $saleQuant * $product->price;
        $sale->save();

        $product->quantity -= $saleQuant;
        $product->status = ($product->quantity >= $product->minimum_level) ? 'in stock' : 'out of stock';
        $product->save();


        $inventory = Inventory::where('product_id', $product->id)->firstOrNew();
        $inventory->status = ($product->quantity > $product->minimum_level) ? 'good' : 'low';
        $inventory->save();

        return response()->json([
            'status' => 200,
            'message' => 'Sale added successfully',
            'data' => $sale
        ]);
    }
}

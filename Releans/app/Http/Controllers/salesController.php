<?php

namespace App\Http\Controllers;

use App\Models\sales;
use App\Models\Product;
use App\Models\stockTracking;
use App\Models\User;

use Illuminate\Http\Request;

class salesController extends Controller
{
    public function index()
    {
        return view('page.sale.sales');
    }
    public function show()
    {
        $sales = Sales::with(['product:id,name,price', 'user:id,name', 'stock:id,quantities'])->get();

        if ($sales->isEmpty()) {
            $data = [
                'status' => 404,
                'message' => 'No stock transactions found',
            ];
            return response()->json($data, 404);
        } else {
            // Transforming the data to include only necessary fields
            $transformedSales = $sales->map(function ($sale) {
                // Check if product, user, and stock exist
                $productName = $sale->product ? $sale->product->name : 'Unknown Product';
                $productPrice = $sale->product ? $sale->product->price : 0;
                $userName = $sale->user ? $sale->user->name : 'Unknown User';
                $quantities = $sale->stock ? $sale->stock->quantities : 0;

                return [
                    'id' => $sale->id,
                    'user_name' => $userName,
                    'product_name' => $productName,
                    'product_price' => $productPrice,
                    'quantities' => $quantities,
                    'total_price' => $sale->total_price,
                    'status' => $sale->status,
                ];
            });

            $data = [
                'status' => 200,
                'sales' => $transformedSales,
            ];

            return response()->json($data, 200);
        }
    }
}

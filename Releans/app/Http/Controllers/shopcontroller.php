<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\stockTracking;
use App\Models\sales;
use App\Models\inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use App\Models\Product;



use Illuminate\Support\Facades\DomPDF;

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


    // public function sale(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'quantity' => 'required|min:0|max:1000',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 422,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $user = Auth::user();
    //     $saleQuant = $request->quantity;

    //     $product = Product::findOrFail($id);

    //     if ($saleQuant > $product->quantity) {
    //         return response()->json([
    //             'status' => 420,
    //             'message' => 'Sale quantity exceeds available quantity'
    //         ], 420);
    //     }




    //     $stock = new StockTracking();
    //     $stock->product_id = $id;
    //     $stock->type = 'deduction';
    //     $stock->quantities = $saleQuant;
    //     $stock->reason = 'transaction sale';
    //     $stock->description = 'Order placed by user: ' . $user->name;
    //     $stock->save();

    //     $sale = new Sales();
    //     $sale->user_id = $user->id;
    //     $sale->product_id = $id;
    //     $sale->trans_id = $stock->id;
    //     $sale->total_price = $saleQuant * $product->price;
    //     $sale->save();

    //     $product->quantity -= $saleQuant;
    //     $product->status = ($product->quantity >= $product->minimum_level) ? 'in stock' : 'out of stock';
    //     $product->save();


    //     $inventory = Inventory::where('product_id', $product->id)->firstOrNew();
    //     $inventory->status = ($product->quantity > $product->minimum_level) ? 'good' : 'low';
    //     $inventory->save();

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Sale added successfully',
    //         'data' => $sale
    //     ]);
    // }


    public function sale(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|min:1|max:12000|integer',
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
        $priceProduct = $product->price;
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
        $sale->trans_id  = $stock->id;
        $sale->status = 'on hold';
        $sale->total_price =  $saleQuant * $priceProduct;
        $sale->save();

        return response()->json([
            'status' => 200,
            'message' => 'Sale added successfully',
            'data' => $sale
        ]);
    }

    // public function updateSaleStatus(Request $request, $saleId)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'status' => 'required|in:accept,reject',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 422,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $sale = Sales::findOrFail($saleId);
    //     $stock = StockTracking::findOrFail($sale->trans_id);

    //     $sale->status = $request->status;

    //     if ($request->status === 'accept') {

    //         $product = Product::findOrFail($sale->product_id);
    //         $product->quantity -= $stock->quantities;
    //         $product->status = ($product->quantity >= $product->minimum_level) ? 'in stock' : 'out of stock';
    //         $product->save();
    //     } elseif ($request->status === 'reject') {
    //         $product = Product::findOrFail($sale->product_id);

    //         $stock = StockTracking::findOrFail($sale->trans_id);

    //         $stock->delete();
    //     }

    //     $sale->save();
    //     $inventory = Inventory::where('product_id', $product->id)->firstOrNew();

    //     $inventory->status = ($product->quantity > $product->minimum_level) ? 'good' : 'low';
    //     $inventory->save();
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Sale status updated successfully',
    //         'data' => $sale
    //     ]);
    // }

    public function updateSaleStatus(Request $request, $saleId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:accept,reject',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $sale = Sales::findOrFail($saleId);
        $stock = StockTracking::findOrFail($sale->trans_id);

        $sale->status = $request->status;

        $product = Product::findOrFail($sale->product_id);

        if ($request->status === 'accept') {
            $product->quantity -= $stock->quantities;
            $product->status = ($product->quantity >= $product->minimum_level) ? 'in stock' : 'out of stock';
            $product->save();
        } elseif ($request->status === 'reject') {
            $stock->reason = 'cancellation';
            $stock->description = 'THis order cancelled';

            $sale->status = 'reject';
            $stock->save();
        }

        $sale->save();

        $inventory = Inventory::where('product_id', $product->id)->firstOrNew();
        $inventory->status = ($product->quantity > $product->minimum_level) ? 'good' : 'low';
        $inventory->save();

        return response()->json([
            'status' => 200,
            'message' => 'Sale status updated successfully',
            'data' => $sale
        ]);
    }




    public function generateSalesReport()
    {
        $sales = sales::select('sales.product_id', 'products.name', 'products.price', 'products.quantity', DB::raw('SUM(total_price) as total_sales'))
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->groupBy('sales.product_id', 'products.name', 'products.price', 'products.quantity')
            ->orderByDesc('total_sales')
            ->get();

        if ($sales->isNotEmpty()) {
            $data = [
                'sales' => $sales,
                'message' => 'Report Sale generated successfully',
            ];

            $pdf = PDF::loadView('sales-report', $data);
            return $pdf->download('sales-report.pdf');
        } else {

            return redirect()->back()->with('error', json_encode(['error' => 'No popular products found']));
        }
    }

    public function generateInventoryReport()
    {
        $inventory = Inventory::select(
            'products.id as product_id',
            'products.name as product_name',
            'products.quantity as product_quantity',
            'products.minimum_level as product_minimum_level',
            'inventories.status'
        )
            ->join('products', 'inventories.product_id', '=', 'products.id')
            ->get();

        if ($inventory->isNotEmpty()) {
            $data = [
                'inventory' => $inventory,
                'message' => 'Inventory report generated successfully',
            ];

            $pdf = PDF::loadView('inventory-report', $data);
            return $pdf->download('inventory-report.pdf');
        } else {

            return redirect()->back()->with('error', json_encode(['error' => 'No popular products found']));
        }
    }


    public function generatePopularReport()
    {
        $popular = Sales::select(
            'products.id as product_id',
            'products.name as product_name',
            DB::raw('COUNT(sales.product_id) as sales_count')
        )
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('sales_count')
            ->limit(3)
            ->get();




        if ($popular->count() < 2) {
            $additionalPopular = Product::select(
                'id as product_id',
                'name as product_name',
                DB::raw('0 as sales_count')
            )->whereNotIn('id', $popular->pluck('product_id')->toArray())
                ->limit(3 - $popular->count())
                ->get();

            $popular = $popular->merge($additionalPopular);
        }

        if ($popular->isNotEmpty()) {
            $data = [
                'popular' => $popular,
                'message' => 'Popular Products report generated successfully',
            ];
            $pdf = PDF::loadView('popularProduct-report', $data);
            return $pdf->download('popular-Product-report.pdf');
        } else {

            return redirect()->back()->with('error', json_encode(['error' => 'No popular products found']));
        }
    }
}

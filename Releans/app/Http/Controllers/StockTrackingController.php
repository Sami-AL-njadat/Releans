<?php

namespace App\Http\Controllers;

use App\Models\stockTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\inventory;


class StockTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.stockTracking.stockTraIndex');
    }

    public function add()
    {
        return view('page.stockTracking.page.add');
    }
    public function edit()
    {
        return view('page.stockTracking.page.edit');
    }


    public function selectTrans($id)
    {
        $stock = stockTracking::findOrFail($id);

        $data = [
            'status' => 200,
            'stock' => $stock,
        ];

        return response()->json($data, 200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:addition,deduction',
            'quantities' => 'required|integer|min:0|max:100000',
            'reason' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $stock = StockTracking::find($id);



        if (!$stock) {
            return response()->json(['status' => 404, 'message' => 'Stock not found'], 404);
        }

        $originalProduct = Product::find($stock->product_id);
        $newProduct = Product::find($request->product_id);

        if (!$originalProduct || !$newProduct) {
            return response()->json(['status' => 404, 'message' => 'Product not found'], 404);
        }

        if ($stock->product_id != $request->product_id || $stock->type != $request->type || $stock->quantities != $request->quantities) {
            $originalQuantity = $originalProduct->quantity;
            $updatedQuantity = $newProduct->quantity;
            $stockOld = $stock->quantities;

            if ($stock->type === 'addition') {
                $originalQuantity -= $stock->quantities;
            } elseif ($stock->type === 'deduction') {
                $originalQuantity += $stock->quantities;
            }

            if ($request->type === 'addition') {
                $updatedQuantity += $request->quantities;
            } elseif ($request->type === 'deduction') {
                $updatedQuantity -= $request->quantities;
            }

            if (
                $stock->type != $request->type &&
                $stock->product_id != $request->product_id
            ) {
                if ($request->type === 'addition') {
                    $originalQuantity += $stockOld;
                    $originalQuantity += $request->quantities;
                } elseif ($request->type === 'deduction') {
                    $originalQuantity -= $stockOld;
                    $originalQuantity -= $request->quantities;
                }
            }

            $originalProduct->quantity = $originalQuantity;
            $newProduct->quantity = $updatedQuantity;
            $newProduct->status = ($newProduct->quantity > $newProduct->minimum_level) ? 'in stock' : 'out of stock';
            $originalProduct->status = ($originalProduct->quantity > $originalProduct->minimum_level) ? 'in stock' : 'out of stock';

            $originalProduct->save();
            $newProduct->save();
        }




        if ($stock->product_id == $stock->product_id || $stock->type  == $stock->type || $stock->quantities == $stock->quantities) {
            $originalProduct->status = ($originalProduct->quantity > $originalProduct->minimum_level) ? 'in stock' : 'out of stock';
            $originalProduct->save();

            $newProduct->status = ($newProduct->quantity > $newProduct->minimum_level) ? 'in stock' : 'out of stock';
            $newProduct->save();
        }


        $stock->product_id = $request->product_id;
        $stock->type = $request->type;
        $stock->quantities = $request->quantities;
        $stock->reason = $request->reason;
        $stock->description = $request->description;

        $stock->save();


        if ($newProduct->quantity <= $newProduct->minimum_level) {
            $inventory = Inventory::where('product_id', $newProduct->id)->firstOrNew();
            $inventory->status = 'low';
            $inventory->save();
        } else {
            $inventory = Inventory::where('product_id', $newProduct->id)->first();
            if ($inventory && $inventory->status === 'low') {
                $inventory->status = 'good';
                $inventory->save();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Stock updated successfully',
            'data' => $stock
        ]);
    }







    public function allTran()
    {
        $stock = stockTracking::with('product')->get();

        if ($stock->isEmpty()) {
            $data = [
                'status' => 404,
                'message' => 'No stock transactions found',
            ];
            return response()->json($data, 404);
        } else {
            $data = [
                'status' => 200,
                'stock' => $stock->toArray(),
            ];

            return response()->json($data, 200);
        }
    }




    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'type' => 'required|in:addition,deduction',
            'quantities' => 'required|integer|min:0|max:100000',
            'reason' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $stock = new stockTracking();
        $stock->product_id = $request->product_id;
        $stock->type = $request->type;
        $stock->quantities = $request->quantities;
        $stock->reason = $request->reason;
        $stock->description = $request->description;




        $stock->save();

        $product = Product::findOrFail($request->product_id);

        $originalQuantity = $product->quantity;
        $originalMinimumLevel = $product->minimum_level;

        if ($request->type === 'addition') {
            $product->quantity += $request->quantities;
        } elseif ($request->type === 'deduction') {
            $product->quantity -= $request->quantities;
        }

        $product->status = ($product->quantity > $product->minimum_level) ? 'in stock' : 'out of stock';

        $product->update($request->all());

        if ($originalQuantity !== $product->quantity || $originalMinimumLevel !== $product->minimum_level) {
            $inventory = Inventory::where('product_id', $product->id)->firstOrNew();

            $inventory->status = ($product->quantity > $product->minimum_level) ? 'good' : 'low';

            $inventory->save();
        }
        return response()->json([
            'status' => 200,
            'message' => 'stock added successfully',
            'data' => $stock
        ]);
    }






    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $deletedStock = StockTracking::find($id);

        if (!$deletedStock) {
            return response()->json(['message' => 'Stock transaction not found'], 404);
        }

        // Fetch the associated product
        $product = Product::find($deletedStock->product_id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($deletedStock->type === 'addition') {
            $product->quantity -= $deletedStock->quantities;
        } elseif ($deletedStock->type === 'deduction') {

            $product->quantity += $deletedStock->quantities;
        }
        $product->status = ($product->quantity > $product->minimum_level) ? 'in stock' : 'out of stock';

        $product->save();

        $deletedStock->delete();

        if ($product->quantity < $product->minimum_level) {
            $inventory = inventory::where('product_id', $product->id)->firstOrNew();
            $inventory->status = 'low';
            $inventory->save();
        } else {
            $inventory = inventory::where('product_id', $product->id)->first();
            if ($inventory && $inventory->status === 'low') {
                $inventory->status = 'good';
                $inventory->save();
            }
        }

        return response()->json(['message' => 'Stock transaction deleted successfully'], 200);
    }
}

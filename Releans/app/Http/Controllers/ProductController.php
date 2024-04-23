<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\inventory;
use App\Models\StockTracking;

use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }




    public function index()
    {

        return view('page.product.productIndex');
    }
    public function allProduct()
    {
        $product = Product::all();

        if ($product->isEmpty()) {
            $data = [
                'status' => 404,
                'message' => 'No products found',
            ];
            return response()->json($data, 404);
        } else {
            $data = [
                'status' => 200,
                'product' => $product,
            ];
            return response()->json($data, 200);
        }
    }

    public function addProdcut()
    {
        return view('page.product.productPage.add');
    }

    public function editProdcut()
    {

        return view("page.product.productPage.edit");
    }


    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'status' => 'required|in:in stock,out of stock',
            'quantity' => 'required|integer|min:0|max:100000',
            'minimum_level' => 'required|integer|min:0|max:100000',
            'price' => 'required|numeric|min:0|max:1000',
            'description' => 'required|string',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:25000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->status = $request->status;
        $product->quantity = $request->quantity;
        $product->minimum_level = $request->minimum_level;
        $product->price = $request->price;
        $product->description = $request->description;



        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/imagesProduct'), $imageName);
            $product->image = 'imagesProduct/' . $imageName;
        }

        $product->save();

        $inventory = new inventory;
        $inventory->product_id = $product->id;
        $inventory->status = ($product->quantity > $product->minimum_level) ? 'good' : 'low';
        $inventory->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product added successfully',
            'data' => $product
        ]);
    }



    public function delete($id)
    {


        $delete = Product::find($id);
        if (!$delete) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }


    public function edits(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'status' => 'required|in:in stock,out of stock',
            'quantity' => 'required|integer|min:0|max:100000',
            'minimum_level' => 'required|integer|min:0|max:100000',
            'price' => 'required|numeric|min:0|max:1000',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:25000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => 404, 'message' => 'Product not found'], 404);
        }

        $originalQuantity = $product->quantity;
        $originalMinimumLevel = $product->minimum_level;

        $product->name = $request->name;
        $product->status = $request->status;
        $product->quantity = $request->quantity;
        $product->minimum_level = $request->minimum_level;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/imagesProduct'), $imageName);
            $product->image = 'imagesProduct/' . $imageName;
        }

        $product->save();

        $stockTransactions = StockTracking::where('product_id', $product->id)->get();

        $totalAddition = 0;
        $totalDeduction = 0;
        if ($originalQuantity != $request->quantity) {
            foreach ($stockTransactions as $transaction) {
                if ($transaction->type === 'deduction') {
                    $totalDeduction += $transaction->quantities;
                } elseif ($transaction->type === 'addition') {
                    $totalAddition += $transaction->quantities;
                }
            }
        }

        $newQuantity = $request->quantity + $totalAddition - $totalDeduction;

        $product->quantity = $newQuantity;
        $product->save();

        if ($originalQuantity !== $product->quantity || $originalMinimumLevel !== $product->minimum_level) {
            $inventory = Inventory::where('product_id', $product->id)->first();
            if ($inventory) {
                $inventory->status = ($product->quantity > $product->minimum_level) ? 'good' : 'low';
                $inventory->save();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }



    public function selectProduct($id)
    {
        $product = Product::findOrFail($id);

        $data = [
            'status' => 200,
            'product' => $product,
        ];

        return response()->json($data, 200);
    }
}

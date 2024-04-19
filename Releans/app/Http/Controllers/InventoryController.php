<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function notify()
    {
        $inventory = Inventory::all();

        foreach ($inventory as $item) {
            if ($item->status === 'low') {
                if ($item->read) {
                    $item->read = false;
                    $item->save();
                }
            } else {
                $item->read = true;
                $item->read_at = now();
                $item->save();
            }
        }

        $lowInventory = $inventory->where('status', 'low')->where('read', false);

        if ($lowInventory->isEmpty()) {
            $data = [
                'status' => 404,
                'message' => 'No products found with low inventory',
            ];
            return response()->json($data, 404);
        } else {
            $formattedInventory = $lowInventory->map(function ($item) {
                $product = Product::find($item->product_id);

                return [
                    'id' => $item->id,
                    'product_name' => $product->name,

                    'updated_at' => $item->updated_at->toIso8601String(),
                ];
            })->values();

            $data = [
                'status' => 200,
                'lowInventory' => $lowInventory,
                'inventory' => $formattedInventory,
            ];
            return response()->json($data, 200);
        }
    }


    public function markAllAsRead()
    {
        $lowInventory = Inventory::where('status', 'low')->where('read', false)->get();

        foreach ($lowInventory as $item) {
            $item->read = true;
            $item->read_at = now();
            $item->save();
        }

        return response()->json(['message' => 'All notifications marked as read'], 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inventory $inventory)
    {
        //
    }
}

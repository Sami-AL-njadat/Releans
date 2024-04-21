<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.supplier.SuppPage');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function addSupplie()
    {
        return view('page.supplier.supplierPage.add');
    }
    public function create(Request $request)
    {
        $validator = User::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
         ]);

        if ($validator->fails()) {
            $data = [
                'status' => 422,
                'message' => $validator->messages()
            ];
            return response()->json($data, 422);
        } else {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
             $user->save();

            $data = [
                'status' => 200,
                'message' => 'Data successfully added'
            ];

            return response()->json($data);
        }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
    }
}
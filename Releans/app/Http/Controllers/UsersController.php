<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.users.userPage');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add()
    {
        return view('page.users.page.add');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|digits:10',
            'role' => 'required|in:admin,user,manager', // Validate role against predefined options
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->image = 'frontend/userImage/avatar-5.png'; // Assuming default image path
        $user->role = $request->input('role'); // Assigning role from the form
        $user->save();

        return response()->json([
            'status' => 201,
            'message' => 'User created successfully',
        ], 201);
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
        $user = user::all();

        if ($user->isEmpty()) {
            $data = [
                'status' => 404,
                'message' => 'No users found',
            ];
            return response()->json($data, 404);
        }

        $data = [
            'status' => 200,
            'user' => $user,
        ];

        return response()->json($data, 200);
    }



    public function edit(User $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $delete = user::find($id);
        if (!$delete) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'user  deleted successfully'], 200);
    }
}

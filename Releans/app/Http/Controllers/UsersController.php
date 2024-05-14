<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
            'role' => 'required|in:admin,user,manager',
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
    public function store()
    {
        return view('page.profile.profile');
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



    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'email|unique:users,email,' . Auth::id(), // Ensure email is unique except for the current user
            'phone' => 'digits:10',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:25000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = Auth::user();

        // Update the user information based on provided data
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = 'frontend/userImage/' . $imageName;
            $image->move(public_path('frontend/userImage'), $imageName);
            $user->image = $imagePath;
        }

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'User information updated successfully',
            'user' => $user, // Optionally, you can return the updated user object
        ], 200);
    }


    public function passWord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm' => 'required|string|min:8|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = Auth::user();

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 422,
                'message' => 'The old password is incorrect.',
            ], 422);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Password updated successfully.',
        ], 200);
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


    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);


        $request->validate([
            'role' => ['required', 'in:admin,manager,user'],
        ]);

        $user->role = $request->input('role');
        $user->save();

        return response()->json(['status' => 200, 'message' => 'User role updated successfully'], 200);
    }
}

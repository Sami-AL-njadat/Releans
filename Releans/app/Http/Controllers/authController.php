<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class authController extends Controller
{


    public function index()
    {
        // dd(Auth::user());
        return view('page.login.login');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 201);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

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
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if (!empty($user)) {
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

    public function destroy($token = null)
    {

        // Invalidate the session

        $user = Auth::user();
        $personalAccessToken = PersonalAccessToken::findToken($token);
        // dd($token);
        if (null === $token) {
            $user->currentAccessToken()->delete();
            Auth::guard('web')->logout();

            return response()->json([
                'message' => 'Current Access Token Deleted'
            ], 204);
        }

        if (!$personalAccessToken) {
            return response()->json([
                'error' => 'Invalid token'
            ], 404);
        }

        if ($user->id === $personalAccessToken->tokenable_id) {
            $personalAccessToken->delete();
            Auth::guard('web')->logout();

            return response()->json([
                'message' => 'Personal Access Token Deleted'
            ], 204);
        }

        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }
}
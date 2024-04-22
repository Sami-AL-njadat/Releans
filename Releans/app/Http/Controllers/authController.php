<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class authController extends Controller
{


    public function index()
    {
        return view('page.login.page.login');
    }

    public function signup()
    {
        return view('page.login.page.signup');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->image = 'frontend/userImage/avatar-1.png';
        $user->save();

        event(new Registered($user));

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'status' => 201,
                'message' => 'User created successfully',
                'token' => $token,
                'user' => Auth::user(),
            ], 201);
        }

        return response()->json(
            [
                'status' => 500,
                'message' => 'Failed to create user. Please try again later.',
            ],
            500
        );
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
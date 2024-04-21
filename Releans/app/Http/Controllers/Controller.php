<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Validator;




class Controller extends BaseController
{
    public function index()
    {
        $uses = User::all();
        $data = [

            'status' => 200,
            'uses' => $uses,

        ];
        return response()->json($data, 200);
    }
    public function show()
    {

        return view('show');
    }


    public function apiShow()
    {
        $user = User::all();
        $data = [

            'status' => 200,
            'user' => $user,

        ];
        return response()->json($data, 200);
    }


    public function editPageOpen($id)
    {


        return view("edit");
    }





    public function editPage($id)
    {
        $user = User::findOrFail($id);

        $data = [
            'status' => 200,
            'user' => $user,
        ];

        return response()->json($data, 200);
    }



    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8', // Add password and confirmation rules
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
            $user->password = Hash::make($request->password); // Hash the password
            $user->save();

            $data = [
                'status' => 200,
                'message' => 'Data successfully added'
            ];

            return response()->json($data);
        }
    }

    public function edits(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 422,
                'message' => $validator->messages()
            ];
            return response()->json($data, 422);
        } else {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['status' => 404, 'message' => 'User not found'], 404);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            $data = [
                'status' => 200,
                'message' => 'Data successfully updated'
            ];
            return response()->json($data, 200);
        }
    }

    // public function delete($id)
    // {
    //     $delete = Users::find($id);
    //     if (!$delete) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     $delete->delete();
    //     return response()->json(['message' => 'User deleted successfully'], 200);
    // }
}

<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{

    public function register(Request $request) {
        $response = [
            "error" => true,
            "message" => "User gagal didaftar!",
        ];

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'full_name' => 'required',
            'gender' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }

        $user = new User();
        $user->username = $request->username;
        $user->password = md5($request->password);
        $user->email = $request->email;
        $user->full_name = $request->full_name;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $saved = $user->save();

        if($saved) {
            $response = [
                "error" => false,
                "message" => "User berhasil didaftar!"
            ];
        }
        
        return response()->json($response);
    }

    public function login(Request $request) {
        $response = [
            "error" => true,
            "message" => "Username atau password salah!",
            "data" => []
        ];

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }

        $username = $request->username;
        $password = md5($request->password);

        $user = User::where('username', $username)->where('password', $password)->first();
        if($user) {
            $response = [
                "error" => false,
                "message" => "Username dan password benar!",
                "data" => $user
            ];
        }

        return response()->json($response);
    }

    public function show($id) {
        $response = [
            "error" => true,
            "message" => "User tidak ditemukan!",
            "data" => []
        ];

        $user = User::find($id);
        if($user) {
            $response = [
                "error" => false,
                "message" => "User ditemukan!",
                "data" => $user
            ];
        }
        return response()->json($response);
    }
}

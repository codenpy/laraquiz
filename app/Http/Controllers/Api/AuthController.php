<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginCheck(Request $request)
    {

        $user = User::where('phone', $request->get('phone'))->first();


        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Login Failed! Your credentials are incorrect',
            ]);
        }

        $userToken = $user->createToken($request->get('device_name'))->plainTextToken;
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Login Successful',
            'userToken' => $userToken,
            'user' => $user,
        ]);
    }
}

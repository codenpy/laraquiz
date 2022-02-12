<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        return response()->json([
            'users' => $users,
        ]);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            //'email' => 'nullable|email|unique:users,email',
            //            'email' => [
            //                'required',
            //                Rule::unique('users')->ignore($user->id),
            //            ],
            'phone' => ['required', 'digits:11'],
            'password' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 201,
                'success' => false,
                'validator' => $validator->errors()
            ]);
        } else {

            // Create new user
            $user = new User();
            $user->name = $request->get('name');
            $user->phone = $request->get('phone');
            $user->password = Hash::make($request->get('password'));

            $user->save();



            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Registration Successful'
            ]);
        }
    }


    public function edit($user_id)
    {
        // Retrieving models
        $user = User::find($user_id);

        if ($user) {
            return response()->json([
                'status' => 200,
                'success' => true,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'No user found'
            ]);
        }
    }



    public function update(Request $request, $user_id)
    {

        $user = User::find($user_id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'student_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 201,
                'success' => false,
                'validator' => $validator->errors()
            ]);
        } else {

            // Update the user
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->student_id = $request->get('studentId');

            $user->save();


            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Profile has been updated'
            ]);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }
}

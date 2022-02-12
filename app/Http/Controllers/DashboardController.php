<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard.index');
    }

    public function authCheck(Request $request)
    {
        $email = 'admin@admin.com';
        $password = '12345678';

        $user = User::where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->with(['msg' => 'Login failed', 'type' => 'error']);
        }

        return 'successfully Logged in';
    }
}

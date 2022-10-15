<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::get()->sortBy('auth_level');
        return view('pages.admin.user.index', compact('user'));
    }

    public function store(Request $request)
    {
        $username   = $request->input('username');
        $name       = $request->input('name');
        $password   = Hash::make($request->input('password'));
        $auth_level = $request->input('auth_level');

        User::create([
            'username'      => $username,
            'name'          => $name,
            'password'      => $password,
            'auth_level'    => $auth_level
        ]);

        return redirect()->back();
    }

    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        $find     = User::where('username', $username)->count();
        if($find > 0) {
            return response()->json([
                'message'   => 'Duplicate Username'
            ], 400);
        }
        return response()->json([
            'message'   => 'Username is ready'
        ], 200);
    }
}

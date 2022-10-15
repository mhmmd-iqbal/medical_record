<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::get()->sortBy('auth_level');
        return view('pages.admin.user.index', compact('user'));
    }

    public function store(Request $request)
    {
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));
        $auth_level = $request->input('auth_level');

        User::create([
            'username'      => $username,
            'password'      => $password,
            'auth_level'    => $auth_level
        ]);

        return redirect()->back();
    }
}

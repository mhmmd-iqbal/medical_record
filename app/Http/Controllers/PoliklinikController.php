<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PoliklinikController extends Controller
{
    public function index(Request $request)
    {
        $user       = User::where('auth_level', 'poliklinik')->get();
        $poliklinik = Poliklinik::get();
        return view('pages.admin.poliklinik.index', compact('user', 'poliklinik'));
    }

    public function store(Request $request)
    {
        $name       = $request->input('name');
        $code       = $request->input('code');
        $user_id    = $request->input('user_id');

        Poliklinik::create([
            'name'      => $name,
            'code'      => $code,
            'user_id'    => $user_id
        ]);

        return redirect()->back();
    }

    public function checkCode(Request $request)
    {
        $code       = $request->input('code');
        $find       = Poliklinik::where('code', $code)->count();
        if($find > 0) {
            return response()->json([
                'message'   => 'Duplicate Kode Poliklinik'
            ], 400);
        }
        return response()->json([
            'message'   => 'Kode is ready'
        ], 200);
    }
}

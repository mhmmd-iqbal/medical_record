<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        switch ($user->auth_level) {
            case 'admin':
                $poliklinik = Poliklinik::withCount('queues')->get();
                return view('pages.admin.dashboard', compact('poliklinik'));
                break;
            case 'poliklinik':
                break;
            case 'apotek':
                break;
            
        }
    }
}

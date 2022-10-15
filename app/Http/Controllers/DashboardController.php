<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use App\Models\Queue;
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
                $queue = Queue::get();
                return view('pages.poliklinik.dashboard', compact('queue'));
                break;
            case 'apotek':
                $poliklinik = Poliklinik::get();
                return view('pages.apotek.dashboard', compact('poliklinik'));
                break;
            
        }
    }
}

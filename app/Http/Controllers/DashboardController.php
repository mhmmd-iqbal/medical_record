<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\SellTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        switch ($user->auth_level) {
            case 'admin':
                return view('pages.admin.dashboard');
                break;
            case 'poliklinik':
                break;
            case 'apotek':
                break;
            
        }
    }
}

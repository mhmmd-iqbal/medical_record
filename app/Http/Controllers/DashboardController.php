<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
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
                $medical_record = MedicalRecord::where('status', false)
                                ->with('medicineLists.stock', 'user.polikliniks', 'patient')
                                ->get();
                // return $medical_record;
                return view('pages.apotek.dashboard', compact('medical_record'));
                break;
            
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

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
                $poliklinik = Poliklinik::where('user_id', Auth::user()->id)->first();
                $queues = $poliklinik->queues()->whereDate('created_at', now())->with('patient')->get();
                if($request->ajax()){
                    return DataTables::of($queues)
                        ->addIndexColumn()
                        ->addColumn('gender', function ($data) {
                                return $data->patient->gender == 'male' ? 'Laki-laki' : 'Perempuan';
                        })
                        ->addColumn('action', function ($data) {
                                return
                                '<button class="btn btn-success text-white "onclick="patientDetail(this)" data-value="'.$data->patient->id.'"><i class="fa fa-eye"></i></button>';
                        })
                        ->addColumn('createdAt', function($data){
                            return Carbon::parse($data->created_at)->format('H : i : s');
                        })
                        ->rawColumns([
                            'action',
                            'createAt'
                        ])
                        ->make(true);
                }
                return view('pages.poliklinik.dashboard');
                break;
            case 'apotek':
                $poliklinik = Poliklinik::get();
                return view('pages.apotek.dashboard', compact('poliklinik'));
                break;
            
        }
    }
}

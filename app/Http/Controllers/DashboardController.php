<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Poliklinik;
use App\Models\Queue;
use App\Models\Stock;
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
                $poliklinik = Poliklinik::with(['queues' => function ($query) {
                    $query->whereDate('created_at', now());
                }])->get();
                foreach ($poliklinik as $key => $value) {
                    $poliklinik[$key]->queues_count = $poliklinik[$key]->queues->count();
                }
                return view('pages.admin.dashboard', compact('poliklinik'));
                break;
            case 'poliklinik':
                $poliklinik = Poliklinik::where('user_id', Auth::user()->id)->first();
                $medicines = Stock::all();
                $queues = $poliklinik->queues()->whereDate('created_at', now())->with('patient')->get();
                if($request->ajax()){
                    return DataTables::of($queues)
                        ->addIndexColumn()
                        ->addColumn('gender', function ($data) {
                                return $data->patient->gender == 'male' ? 'Laki-laki' : 'Perempuan';
                        })
                        ->addColumn('action', function ($data) {
                                return
                                '<button class="btn btn-success text-white "onclick="patientDetail(this)" data-value="'.$data->patient->id.' "data-medical_issue="'.$data->medical_issue.'"><i class="fa fa-eye"></i></button>';
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
                return view('pages.poliklinik.dashboard', compact('medicines'));
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

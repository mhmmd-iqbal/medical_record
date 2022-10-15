<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function show(Request $request)
    {
        $nik = $request->input('nik');

        $patient = Patient::where('nik', $nik)->first();

        return response()->json([
            'message'   => 'ok',
            'result'    => $patient
        ], 200);
    }

    public function store(Request $request)
    {
        $nik            = $request->input('nik');
        $name           = $request->input('name');
        $date_of_birth  = $request->input('date_of_birth');
        $gender         = $request->input('gender');
        $phone          = $request->input('phone');
        $medical_issue  = $request->input('medical_issue');
        $poliklinik_id  = $request->input('poliklinik_id');

        $patient = Patient::updateOrCreate([
            'nik'           => $nik
        ], [
            'name'          => $name,
            'date_of_birth' => $date_of_birth,
            'gender'        => $gender,
            'phone'         => $phone,
        ]);

        $queue_count = Queue::where('poliklinik_id', $poliklinik_id)
                        ->whereDate('created_at', Carbon::today())
                        ->count();

        $patient->medicalRecords()->create([
            'poliklinik_id' => $poliklinik_id,
            'medical_issue' => $medical_issue,
            'queue_no'      => $queue_count++
        ]);

        return response()->json([
            'message'   => 'ok',
        ], 200);
    }
}

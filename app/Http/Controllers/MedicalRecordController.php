<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;

class MedicalRecordController extends Controller
{
    public function store(Request $request)
    {
        $patient_id     = $request->input('patient_id');
        $user_id        = $request->input('user_id');
        $status         = $request->input('status');
        $medical_issue  = $request->input('medical_issue');
        $medical_handle = $request->input('medical_handle');

        MedicalRecord::create([
            'patient_id' => $patient_id,
            'user_id' => $user_id,
            'status' => $status,
            'medical_issue' => $medical_issue,
            'medical_handle' => $medical_handle,
        ]);

        return response()->json([
            'message'   => 'Berhasil input data',
        ], 200);    
    }
}

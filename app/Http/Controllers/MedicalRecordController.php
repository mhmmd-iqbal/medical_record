<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\MedicineList;
use DB;

class MedicalRecordController extends Controller
{
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $medicineList   = $request->input('medicine_list');
            $patient_id     = $request->input('patient_id');
            $user_id        = $request->input('user_id');
            $status         = $request->input('status');
            $medical_issue  = $request->input('medical_issue');
            $medical_handle = $request->input('medical_handle');

            $medicalRecord = MedicalRecord::create([
                'patient_id' => $patient_id,
                'user_id' => $user_id,
                'status' => $status ?? 0,
                'medical_issue' => $medical_issue,
                'medical_handle' => $medical_handle,
            ]);
            
            if (count($medicineList) != 0) {
                foreach ($medicineList as $key => $value) {
                    MedicineList::create([
                        'medical_record_id' => $medicalRecord->id,
                        'stock_id' => $value['stockID'],
                        'quantity' => $value['quantity'],
                    ]);
                }
            }
        });

        return response()->json([
            'message'   => 'Berhasil input data',
        ], 200);    
    }
}

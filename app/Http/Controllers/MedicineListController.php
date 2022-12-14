<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\MedicineList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineListController extends Controller
{
    public function store(Request $request)
    {
        $medical_record_id  = $request->input('patient_id');
        $stock_id           = $request->input('user_id');
        $quantity           = $request->input('status');

        MedicineList::create([
            'medical_record_id'     => $medical_record_id,
            'stock_id'              => $stock_id,
            'quantity'              => $quantity,
        ]);

        return response()->json([
            'message'   => 'Berhasil input data',
        ], 200);    
    }

    public function getListByMedicalRecord($id) 
    {
        $medicine_list = MedicineList::with('stock')->where('medical_record_id', $id)->get();

        return response()->json([
            'message'   => 'ok',
            'result'    => $medicine_list
        ], 200);
    }

    public function approveMedicine(Request $request, $id)
    {
        DB::beginTransaction();
        $list = $request->input('input');

        try {
            MedicalRecord::find($id)
            ->update([
                'status'    => true
            ]);
            
            // foreach list approve, cek stock and minus
            foreach ($list as $item) {
                $medicine = MedicineList::find($item['id']);
                $medicine->update(['confirmed', 1]);

                $medicine->stock()->decrement('quantity', (int) $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'message'   => 'ok'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message'   => $th->getMessage()
            ], 500);
        }
    }
}

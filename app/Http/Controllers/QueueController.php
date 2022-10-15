<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        $poliklinik = Poliklinik::with([
            'queues' => function($query) {
                $query
                ->with('patient')
                ->whereDate('created_at', Carbon::today())
                ->where('status', false)
                ->orderBy('queue_no', 'desc');
            }
        ])->get();
        
        return view('pages.patient', compact('poliklinik'));
        return $poliklinik;
    }

    public function countQueue($id) 
    {
        $count = Queue::where('poliklinik_id', $id)
                ->whereDate('created_at', Carbon::today())
                ->count();
        
        return response()->json(
            [
                'message'   => 'ok',
                'result'    => $count,
            ], 200
        );
    }
}

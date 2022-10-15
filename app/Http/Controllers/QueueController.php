<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueController extends Controller
{
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

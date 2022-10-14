<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SellTransaction;
use App\Models\SellTransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class SellTransactionController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $purchases = SellTransaction::orderBy('updated_at', 'DESC')
                ->get();
            return DataTables::of($purchases)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                    return
                        '<a class="btn btn-success" href="'.route("sell.transaction.show", $data->id).'" ><i class="fa fa-book"></i></a>';
                })
                ->addColumn('total', function($data){
                    return number_format($data->total, 0, '', '.');
                })
                ->addColumn('createdAt', function($data){
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                })
                ->rawColumns([
                    'total',
                    'action',
                    'createdAt',
                ])
            ->make(true);
        }
        return view('pages.sell_transaction.index');
    }

    public function store(Request $request){
        $total = 0;
        DB::beginTransaction();
        $products = json_decode($request->product);
        try {
            $transaction = SellTransaction::create([
                'invoice'   => Str::random(5).'/'.Carbon::now('Asia/Jakarta')->format('d/m/y'),
                'consumen'  => $request->consumen,
                'total'     => $total,
                'address'   => $request->address
            ]);

            foreach ($products as $key => $product) {
                $total += (int) $product->price;

                SellTransactionDetail::create([
                    'product_id'    => $product->id,
                    'sell_id'       => $transaction->id,
                    'quantity'      => 1,
                ]);

                Product::where('id', $product->id)
                        ->decrement('unit', 1);
            }

            $transaction->update([
                'total' => $total
            ]);
            
            DB::commit();
            return response()->json([
                'status'    => true
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollback();;
            return response()->json([
                'status'    => false
            ], 200);

        }
        
    }

    public function show(SellTransaction $id){
        $data = $id;
        return view('pages.sell_transaction.show', compact('data'));
    }

    public function create(){
        return view('pages.sell_transaction.create');
    }
}

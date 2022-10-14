<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\SellTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $category = ProductCategory::all();
        $productBaseOnCategory = [];
        $month = $now->format('m');
        $day = $now->firstOfMonth();
        $daysInMonth = $now->daysInMonth;
        $transaction = [];
        // $categoryProductTransaction = Product::with('detailTransaction')->get();

        for ($i = 0; $i < $daysInMonth; $i++) { 
            $transaction[$i] = SellTransaction::whereMonth('created_at', '=', $month)
                            ->whereDay('created_at', $i + 1)
                            ->count();
        }

        foreach ($category as $key => $value) {
            $productBaseOnCategory[$key]['value'] = Product::where('category_id', $value->id)->count();
            $productBaseOnCategory[$key]['name'] = $value->name;
        }

        $lastTenData = SellTransaction::orderBy('id', 'desc')->take(10)->get();
        
        // dd(SellTransaction::with('details')->get()->toArray());
        // for ($i = 1; $i <= \Carbon\Carbon::now()->daysInMonth; $i++) {
        // };
        // $transaction = SellTransaction::get();
        return view('pages.dashboard', compact('productBaseOnCategory', 'lastTenData', 'transaction'));
    }
}

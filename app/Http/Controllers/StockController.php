<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index() {
        $stock       = Stock::get();
        return view('pages.apotek.stock', compact('stock'));
    }

    public function store(Request $request) 
    {
        $name       = $request->input('name');
        $quantity   = $request->input('quantity');

        Stock::create([
            'name'      => $name,
            'quantity'  => $quantity
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $quantity = $request->input('quantity');

        Stock::find($id)->increment('quantity', (int) $quantity);

        return redirect()->back();
    }
}

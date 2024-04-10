<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Auth::user()->purchases;
        return response()->json($purchases);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
        */
    public function store(Request $request)
    {
        $deadline = \Carbon\Carbon::parse($request->deadline)->toDateTimeString();
        $folio = time();
        $purchase = new Purchase();
        $purchase->user_id = Auth::user()->id;
        $purchase->quantity = $request->quantity;
        $purchase->price = $request->price;
        $purchase->city = $request->city;
        $purchase->deadline = $deadline;
        $purchase->folio = $folio;
        $purchase->save();
        return response()->json($purchase);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $purchase->decrement('quantity', 1);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    public function readQr($folio)
    {
        $purchase = Purchase::where('folio', $folio)->first();
        if($purchase->quantity <= 0){
            return response()->json(['message' => 'Producto agotado'], 400);
        }
        $purchase->decrement('quantity', 1);
        return response()->json($purchase);
    }
}

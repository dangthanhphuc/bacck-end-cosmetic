<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validator = $request->validate([
            'products' => "required|array",
            'products.*.id' => 'required|uuid',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'date' => now(),
            'status'=> 'PENDING'
        ]);

        OrderDetail::createFromProducts($order->id, $validator['products']);
    
        return response()->json([
            'message' => 'Order created successfully',
            $order => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $orders = Order:: where('user_id', $userId)->get();
        return $orders;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

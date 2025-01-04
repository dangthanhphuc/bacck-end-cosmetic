<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:1'
        ]);

        try {
            $cart = Cart::create( $validator);
            
            return response()->json([
                'message' => 'Cart created successfully',
                'cart' => $cart
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $cart = Cart::where('user_id', $userId)->get();
        return $cart;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $cart = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

    if (!$cart) {
        return response()->json([
            'message' => 'Cart not found',
        ], 404);
    }

    $validator = $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    try {
        $cart->quantity = $request->quantity;
        $cart->save();
    
        return response()->json([
            'message' => 'Cart updated successfully',
            'cart' => $cart
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An error occurred while updating the cart',
            'error' => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}

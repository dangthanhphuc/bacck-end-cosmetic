<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'date' => now(),
                'status'=> 'PENDING'
            ]);
    
            OrderDetail::createFromProducts($order->id, $validator['products']);
        
            DB::commit();
    
            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while creating the order',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $orders = Order::with("orderDetails")->where('user_id', $userId)->get();
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

    public function deleteOrder($orderId) {
        try {
          DB::beginTransaction();
          $order = Order::findOrFail($orderId);
          
          if($order->user_id !== auth()->id()) {
               return response()->json(['message' => 'Unauthorized'], 401);
          }

          $order->delete();

          DB::commit();

          return response()->json(['message' => 'Order deleted successfully'], 200);

        }catch(\Exception $e) {
          DB::rollBack();
          return response()->json([
               'message' => 'An error occurred while deleting the order',
               'error' => $e->getMessage()
          ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteOrderDetail(Request $request)
    {
        $validator = $request->validate([
            'order_id' => "required|uuid",
            'product_id' => 'required|uuid',
        ]);

        OrderDetail::find([$request->order_id => $request->product_id])->delete();
    }
}

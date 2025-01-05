<?php

namespace App\Http\Controllers;

use App\Enums\Origin;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ProductController extends Controller
{
    //

    public function products() {
        $products = Product::with(['brand', 'category'])->get();
        return $products;
    }

    public function create(Request $request) {
        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => '',
            'origin' => 'required',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:categories,id',
        ]);

        try {
            $product = Product::create( $validator);
            
            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the product',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function update(Request $request, $id) {
        
        $product = Product::findOrFail($id); 

        $validator = $request->validate([
            'name' => 'sometimes|required',
            'price' => 'sometimes|required|numeric',
            'description' => 'sometimes',
            'origin' => 'sometimes|required',
            'category_id' => 'sometimes|required|exists:categories,id',
            'brand_id' => 'sometimes|required|exists:brands,id'
        ]);

        try {
            $product->update($validator);
        
            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the product',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
    
            return response()->json([
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

};

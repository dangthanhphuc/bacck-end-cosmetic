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
        $products = Product::all();
        return $products;
    }

    public function create(Request $request) {
        $validator = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => '',
            'origin' => ['required', new Enum(Origin::class)],
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        try {
            $product = Product::create(attributes: $validator);
            
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


};

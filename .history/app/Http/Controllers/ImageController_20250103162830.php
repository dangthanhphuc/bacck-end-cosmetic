<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // Validate input để đảm bảo nhận đúng file
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Lưu file vào thư mục storage/app/public/images
        // $path = $request->file('image')->store('images', 'public');


        // Lưu file vào thư mục storage/app/public/images
        $uploadedImages = [];

        // Lặp qua mảng các ảnh và lưu từng ảnh
        foreach ($request->file('images') as $image) {
            $path = $image->store('images', 'public');
            $uploadedImages[] = asset('storage/' . $path);
        }
        
        // Trả về response chứa đường dẫn của tất cả các ảnh
        return response()->json([
            'message' => 'Images uploaded successfully!',
            'urls' => $uploadedImages,
        ]);
    }

    public function show($filename)
    {
        // Trả về file hình ảnh theo tên
        $path = storage_path('app/public/images/' . $filename);

        if (!file_exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return response()->file($path);
    }
}

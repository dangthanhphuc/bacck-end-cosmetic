<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // Validate input để đảm bảo nhận đúng file
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        // Lưu file vào thư mục storage/app/public/images
        $path = $request->file('image')->store('images', 'public');

        // Trả về response chứa đường dẫn
        return response()->json([
            'message' => 'Image uploaded successfully!',
            'url' => asset('storage/' . $path),
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

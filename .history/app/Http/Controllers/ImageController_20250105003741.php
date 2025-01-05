<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // Validate input để đảm bảo nhận đúng file
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        // Lưu file vào thư mục storage/app/public/images
        // $path = $request->file('image')->store('images', 'public');


        // Lưu file vào thư mục storage/app/public/images
        $uploadedImages = [];

        try {
            DB::beginTransaction();
            // Lặp qua mảng các ảnh và lưu từng ảnh
            foreach ($data['images'] as $image) {
                $path = $image->store('images', 'public');
                $uploadedImages[] = asset('storage/' . $path);
                $image = Image::create([
                    'product_id' => $request->product_id,
                    'url' => $path
                ]);
            }
            DB::commit();
            // Trả về response chứa đường dẫn của tất cả các ảnh
            return response()->json([
                'message' => 'Images uploaded successfully!',
                'urls' => $uploadedImages,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json('error', $e->getMessage());
        }

        
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

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info() {
        $userId = auth()->user()->id;
        $user = User::find($userId)->first();
        return response()->json([
            'user' => $user
        ], 200);
    }

    public function update(Request $request) {
        $userId = auth()->user()->id;
        $user = User::find($userId)->first();

        $validator = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $user->update($validator);

        return response()->json([
           'message' => 'User updated successfully'
        ], 200);
    }
        
}

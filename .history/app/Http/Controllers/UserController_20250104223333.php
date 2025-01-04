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
}

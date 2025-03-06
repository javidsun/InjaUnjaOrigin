<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controllers
{
    public function getUserDetails(Request $request)
    {
        return response()->json($request->user());
    }
}

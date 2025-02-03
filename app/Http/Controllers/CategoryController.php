<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controllers
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
}

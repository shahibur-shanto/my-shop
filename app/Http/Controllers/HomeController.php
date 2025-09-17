<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::all()->map(function ($category) {
            $category->image = $category->image
                ? Storage::url($category->image)
                : null;
            return $category;
        }); // Fetch all categories

        return Inertia::render('Home', [
            'categories' => $categories
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

        $new_arrivals = Product::orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function ($new_arrival){
                $new_arrival->image = $new_arrival->image
                    ? Storage::url($new_arrival->image)
                    : null;
                return $new_arrival;
            });

        return Inertia::render('Home', [
            'categories' => $categories,
            'new_arrivals'=>$new_arrivals,
        ]);
    }
}

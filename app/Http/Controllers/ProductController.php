<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function create(){

        return Inertia::render('Admin/Products/Create',[
            'categories' => Category::select('id','name')->get(),
            'brands' => Brand::select('id','name')->get(),
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'quantity'       => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
        ]);
        Product::create($validated);

        return redirect()->back()->with('success', 'Product added successfully!');
    }
}

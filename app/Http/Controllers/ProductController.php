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
            'image' => 'required|image|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'quantity'=>$request->quantity,
            'category_id'=>$request->category_id,
            'brand_id'=>$request->brand_id,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }
}

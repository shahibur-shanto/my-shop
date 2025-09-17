<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function create(){
        return Inertia::render('Admin/Brands/Create');
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'string|max:255',
            'website_url'=>'string|max:255'
        ]);

        Brand::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'website_url'=>$request->url,
        ]);
        return redirect()->back()->with('success', 'Brand added successfully!');
    }
}

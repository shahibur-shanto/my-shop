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
        Brand::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'website_url'=>$request->url,
        ]);
        return Inertia::render('Admin/Dashboard');
    }
}

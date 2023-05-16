<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(ProductFormRequest $request)
    {
        $validatedData = $request->validated();

        $category = Category::findOrFail($validatedData['category_id']);

        $product = $category->products()->create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['slug']),
            'small_description' => $validatedData['small_description'],
            'brand' => $validatedData['brand'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'trending' => $request->trending == true ? '1':'0',
            'status' => $request->status == true ? '1':'0',
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description']
        ]);

        if($request->hasFile('image')){
            $path = 'uploads/product/';
            $i = 1;
            foreach ($request->file('image') as $file) {
                $ext = $file->getClientOriginalExtension();
                $filename = time().$i++.'.'.$ext;
                $file->move($path,$filename);
                $productImage = $path.$filename;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $productImage
                ]);
            }
        }

        return redirect('admin/product')->with('message','Product added successfully');
        // return $product->id;
    }
}

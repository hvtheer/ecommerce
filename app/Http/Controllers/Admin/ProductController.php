<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::where('status','0')->get();

        return view('admin.product.create', compact('categories', 'brands', 'colors'));
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

        if($request->colors) {
            foreach ($request->colors as $color) {
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $request->color_quantity[$color] ?? 0
                ]);
            }
        }

        return redirect('admin/product')->with('message','Product added successfully');
        // return $product->id;
    }

    public function edit(int $product_id)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::findOrFail($product_id);

        $product_color = $product->productColors->pluck('color_id')->toArray();
        $colors = Color::whereNotIn('id',$product_color)->get();

        return view('admin.product.edit', compact('categories', 'brands', 'colors', 'product'));
    }

    public function update(ProductFormRequest $request, int $product_id)
    {
        $validatedData = $request->validated();

        $product = Category::findOrFail($validatedData['category_id'])
                        ->products()->where('id',$product_id)->first();
        $product->update([
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

        if($request->colors) {
            foreach ($request->colors as $color) {
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $request->color_quantity[$color] ?? 0
                ]);
            }
        }

        return redirect('admin/product')->with('message','Product updated successfully');
    }

    public function destroyImage(int $product_image_id)
    {
        $productImage = ProductImage::findOrFail($product_image_id);
        if (File::exists($productImage->image)) {
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back()->with('message','Product\'s image deleted successfully');
    }

    public function destroy(int $product_id)
    {
        $product= Product::findOrFail($product_id);
        if ($product->productImages()) {
            foreach ($product->productImages as $image) {
                if (File::exists($image->image)) {
                    File::delete($image->image);
                }
                $image->delete(); 
            }
        }
        $product->delete();
        return redirect()->back()->with('message','Product deleted with all images successfully');
    }

    public function updateProdColorQty(Request $request, $prod_color_id)
    {
        $productColorData = Product::findOrFail($request->product_id)
                                ->productColors()->where('id',$prod_color_id)->first();
        $productColorData->update([
            'quantity' => $request->qty
        ]);

        return response()->json(['message' => 'Product Color Qty updated']);
    }

    public function deleteProdColor($prod_color_id)
    {
        $productColor = ProductColor::findOrFail($prod_color_id);
        $productColor->delete();
        return response()->json(['message' => 'Product Color deleted']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Symfony\Contracts\Service\Attribute\Required;

class ProductController extends Controller
{

    public function list()
    {
        $product = Product::paginate(10);
        return view('backend.features.product.list', compact('product'));
    }

    public function create()
    {
        $category = Category::all();
        $brand = Brand::all();
        return view('backend.features.product.create', compact('category', 'brand'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        //file upload
        $fileName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/products'), $fileName);
        }

        //eloquent orm model create method
        $product = Product::create([
            "name" => $request->name,
            "category_id" => $request->category_id,
            "brand_id" => $request->brand_id,
            "description" => $request->description,
            "price" => $request->price,
            "stock" => $request->stock,
            "discount" => $request->discount,
            "status" => $request->status,
            "image" => $fileName
        ]);

        // Handle multiple gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryFileName = uniqid('gallery_') . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload/products/gallery'), $galleryFileName);
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $galleryFileName
                ]);
            }
        }

        toastr()->title('Product')->success('Product created successfully');
        return redirect()->route('product.list');
    }

    public function edit($id)
    {
        $product = Product::with('productImages')->findOrFail($id);
        $category = Category::all();
        $brand = Brand::all();
        return view('backend.features.product.edit', compact('product', 'category', 'brand'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'status' => 'required|string|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $fileName = $product->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/products'), $fileName);
        }

        $product->update([
            "name" => $request->name,
            "category_id" => $request->category_id,
            "brand_id" => $request->brand_id,
            "description" => $request->description,
            "price" => $request->price,
            "stock" => $request->stock,
            "discount" => $request->discount,
            "status" => $request->status,
            "image" => $fileName
        ]);

        // Handle multiple gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryFileName = uniqid('gallery_') . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload/products/gallery'), $galleryFileName);
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $galleryFileName
                ]);
            }
        }

        toastr()->title('Product')->success('Product updated successfully');
        return redirect()->route('product.list');
    }

    public function deleteGalleryImage($id)
    {
        $image = \App\Models\ProductImage::findOrFail($id);
        $imagePath = public_path('upload/products/gallery/' . $image->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $image->delete();
        return response()->json(['success' => true]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        toastr()->title('Product')->success('Products imported successfully!');
        return redirect()->route('product.list');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image file if exists
        $imagePath = public_path('upload/products/' . $product->image);
        if ($product->image && file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        $product->delete();
        toastr()->title('Product')->success('Product deleted successfully');
        return redirect()->back();
    }

    public function view($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('backend.features.product.view', compact('product'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Product not found');
        }
    }
}



<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BrandsImport;

class BrandController extends Controller
{
    public function list() {
        $brand=Brand::all();
        return view('backend.features.Brand.list',compact('brand'));
    }


public function create(){
return view('backend.features.Brand.create');
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|string|in:active,inactive'
        ]);

        $fileName = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/brands'), $fileName);
        }

        Brand::create([
            "name" => $request->name,
            "description" => $request->description,
            "logo" => $fileName,
            "status" => $request->status
        ]);

        toastr()->title('Brand')->success('Brand created successfully');
        return redirect()->route('brand.list');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.features.Brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|string|in:active,inactive'
        ]);

        $fileName = $brand->logo;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/brands'), $fileName);
        }

        $brand->update([
            "name" => $request->name,
            "description" => $request->description,
            "logo" => $fileName,
            "status" => $request->status
        ]);

        toastr()->title('Brand')->success('Brand updated successfully');
        return redirect()->route('brand.list');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        Excel::import(new BrandsImport, $request->file('file'));

        toastr()->title('Brand')->success('Brands imported successfully!');
        return redirect()->route('brand.list');
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        
        // Delete logo file if exists
        $logoPath = public_path('upload/brands/' . $brand->logo);
        if ($brand->logo && file_exists($logoPath)) {
            unlink($logoPath);
        }
        
        $brand->delete();
        toastr()->title('Brand')->success('Brand deleted successfully');
        return redirect()->route('brand.list');
    }
}
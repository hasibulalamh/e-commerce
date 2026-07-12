<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BrandsImport;

class BrandController extends Controller
{
    public function list()
    {
         $brands = Brand::paginate(10, ['*'], 'page', null, null);
        return view('backend.features.Brand.list', compact('brands'));
    }


    public function create()
    {
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

        $dbPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands'), $fileName);
            $dbPath = 'brands/' . $fileName;
        }

        Brand::create([
            "name" => $request->name,
            "description" => $request->description,
            "logo" => $dbPath,
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

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands'), $fileName);
            $dbPath = 'brands/' . $fileName;
        } else {
            $dbPath = $brand->logo;
        }

        $brand->update([
            "name" => $request->name,
            "description" => $request->description,
            "logo" => $dbPath,
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
        $logoPath = public_path('uploads/brands/' . $brand->logo);
        if ($brand->logo && file_exists($logoPath)) {
            unlink($logoPath);
        }

        $brand->delete();
        toastr()->title('Brand')->success('Brand deleted successfully');
        return redirect()->route('brand.list');
    }
}

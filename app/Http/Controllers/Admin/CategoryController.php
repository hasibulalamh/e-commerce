<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CategoriesImport;

class CategoryController extends Controller
{
    public function list()
    {

        $cat = Category::paginate(10, ['*'], 'page', null, null);
        return view('backend.features.category.list', compact('cat'));
    }


    public function create()
    {
        return view('backend.features.category.create');
    }


    public function store(Request $request)
    {
        //category validation
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'display_order' => 'required|integer',
            'status' => 'required|string|in:active,inactive',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($validation->fails()) {
            toastr()->title('category form')->error($validation->getMessageBag());
            return redirect()->back();
        }

        //image file upload
        $dbPath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $fileName);
            $dbPath = 'categories/' . $fileName;
        }

        Category::create([
            "name" => $request->name,
            "description" => $request->description,
            "image" => $dbPath,
            "display_order" => $request->display_order,
            "status" => $request->status
        ]);

        toastr()->title('Category')->success('Category created successfully');
        return redirect()->route('category.list');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.features.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'display_order' => 'required|integer',
            'status' => 'required|string|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $fileName);
            $dbPath = 'categories/' . $fileName;
        } else {
            $dbPath = $category->image;
        }

        $category->update([
            "name" => $request->name,
            "description" => $request->description,
            "image" => $dbPath,
            "display_order" => $request->display_order,
            "status" => $request->status
        ]);

        toastr()->title('Category')->success('Category updated successfully');
        return redirect()->route('category.list');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        Excel::import(new CategoriesImport, $request->file('file'));

        toastr()->title('Category')->success('Categories imported successfully!');
        return redirect()->route('category.list');
    }

    public function delete($id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();
        toastr()->title('Category')->success('Category deleted successfully');
        return redirect()->back();
    }
}

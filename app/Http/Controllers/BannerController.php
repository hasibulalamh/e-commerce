<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('backend.features.banner.list', compact('banners'));
    }

    public function create()
    {
        return view('backend.features.banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'integer'
        ]);

        $fileName = null;
        if ($request->hasFile('image')) {
            $fileName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/banners'), $fileName);
        }

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text ?? 'SHOP NOW',
            'button_url' => $request->button_url,
            'image' => $fileName,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        toastr()->title('Banner')->success('Banner created successfully!');
        return redirect()->route('banner.list');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('backend.features.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'integer'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image && File::exists(public_path('upload/banners/' . $banner->image))) {
                File::delete(public_path('upload/banners/' . $banner->image));
            }

            $fileName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/banners'), $fileName);
            $banner->image = $fileName;
        }

        $banner->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text ?? 'SHOP NOW',
            'button_url' => $request->button_url,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        toastr()->title('Banner')->success('Banner updated successfully!');
        return redirect()->route('banner.list');
    }

    public function delete($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && File::exists(public_path('upload/banners/' . $banner->image))) {
            File::delete(public_path('upload/banners/' . $banner->image));
        }

        $banner->delete();

        toastr()->title('Banner')->success('Banner deleted successfully!');
        return redirect()->route('banner.list');
    }
}

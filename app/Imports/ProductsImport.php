<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $categoryId = Category::where('name', $row['category_name'])->value('id');
        $brandId = Brand::where('name', $row['brand_name'])->value('id');

        // Skip row if category or brand not found to prevent crashes
        if (!$categoryId || !$brandId) {
            \Log::warning("Skipping product import row: Category ({$row['category_name']}) or Brand ({$row['brand_name']}) not found.");
            return null;
        }

        $imageField = null;

        if (!empty($row['image_url'])) {
            try {
                $response = Http::timeout(10)->get($row['image_url']);
                if ($response->successful()) {
                    $fileName = time() . '_' . uniqid() . '.jpg';
                    $path = public_path('upload/products');
                    
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0755, true);
                    }
                    
                    File::put($path . '/' . $fileName, $response->body());
                    $imageField = $fileName;
                }
            } catch (\Exception $e) {
                // Keep imageField as null if download fails
                \Log::error('Bulk Import Image Download Failed: ' . $e->getMessage());
            }
        }

        return new Product([
            'name'          => $row['name'],
            'category_id'   => $categoryId,
            'brand_id'      => $brandId,
            'description'   => $row['description'] ?? '',
            'price'         => $row['price'] ?? 0,
            'discount'      => $row['discount'] ?? 0,
            'stock'         => $row['stock'] ?? 0,
            'status'        => $row['status'] ?? 'active',
            'image'         => $imageField ?? null,
        ]);
    }
}

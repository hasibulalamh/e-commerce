<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow, SkipsOnError, WithChunkReading
{
    use SkipsErrors;

    public function model(array $row)
    {
        $name = trim($row['name'] ?? $row['product_name'] ?? $row['product name'] ?? '');
        if (empty($name)) return null;

        $categoryName = trim($row['category_name'] ?? $row['category'] ?? '');
        $brandName = trim($row['brand_name'] ?? $row['brand'] ?? '');

        $categoryId = Category::where('name', $categoryName)->value('id');
        $brandId = Brand::where('name', $brandName)->value('id');

        if (!$categoryId || !$brandId) {
            \Log::warning("Skipping product import: Category ({$categoryName}) or Brand ({$brandName}) not found.");
            return null;
        }

        $imageInput = $row['image_url'] ?? $row['image'] ?? $row['product_image'] ?? $row['product image'] ?? $row['img'] ?? $row['url'] ?? null;
        $imageField = $this->handleImage($imageInput);

        return new Product([
            'name'          => $name,
            'category_id'   => $categoryId,
            'brand_id'      => $brandId,
            'description'   => $row['description'] ?? '',
            'price'         => (float) ($row['price'] ?? 0),
            'discount'      => (float) ($row['discount'] ?? 0),
            'stock'         => (int) ($row['stock'] ?? 0),
            'status'        => $row['status'] ?? 'active',
            'image'         => $imageField,
        ]);
    }

    private function handleImage(?string $input): ?string
    {
        if (blank($input)) return null;
        $input = trim($input);

        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return $this->downloadImage($input);
        }

        $filename = basename($input);
        $path = 'products/' . $filename;
        return Storage::disk('public')->exists($path) ? $path : null;
    }

    private function downloadImage(string $url): ?string
    {
        try {
            $response = Http::timeout(20)->get($url);
            if (!$response->successful()) return null;

            $contentType = $response->header('Content-Type');
            $extension = match (true) {
                str_contains($contentType, 'jpeg') => 'jpg',
                str_contains($contentType, 'png')  => 'png',
                str_contains($contentType, 'webp') => 'webp',
                default => 'jpg',
            };

            $path = 'products/' . Str::uuid() . '.' . $extension;
            Storage::disk('public')->put($path, $response->body());
            return $path;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function chunkSize(): int
    {
        return 50;
    }
}

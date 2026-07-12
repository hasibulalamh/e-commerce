<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CategoriesImport implements ToModel, WithHeadingRow, SkipsOnError, WithChunkReading
{
    use SkipsErrors;

    public function model(array $row)
    {
        $name = trim(
            $row['name']
            ?? $row['category_name']
            ?? $row['category name']
            ?? ''
        );

        if (empty($name)) {
            return null;
        }

        $imageInput = $row['image'] ?? $row['image_url'] ?? $row['image url'] ?? null;
        $imagePath  = $this->handleImage($imageInput);

        return new Category([
            'name'          => $name,
            'description'   => $row['description'] ?? '',
            'image'         => $imagePath,
            'display_order' => (int) ($row['display_order'] ?? $row['displayorder'] ?? 0),
            'status'        => $row['status'] ?? 'active',
        ]);
    }

    private function handleImage(?string $input): ?string
    {
        if (blank($input)) {
            return null;
        }

        $input = trim($input);

        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return $this->downloadImage($input);
        }

        $filename = basename($input);
        $path     = 'categories/' . $filename;

        // ✅ Fix 2: $filename → $path
        return Storage::disk('public')->exists($path) ? $path : null;
    }

    private function downloadImage(string $url): ?string
    {
        try {
            $response = Http::timeout(20)->get($url);

            if (! $response->successful()) {
                return null;
            }

            $contentType = $response->header('Content-Type');
            $extension   = match (true) {
                str_contains($contentType, 'jpeg') => 'jpg',
                str_contains($contentType, 'png')  => 'png',
                str_contains($contentType, 'webp') => 'webp',
                str_contains($contentType, 'gif')  => 'gif',
                default => pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg',
            };

            $path = 'categories/' . Str::uuid() . '.' . $extension;
            Storage::disk('public')->put($path, $response->body());

            // ✅ Fix 1: $filename → $path
            return $path;

        } catch (\Throwable $e) {
            logger()->warning("Image download failed: {$url}", ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
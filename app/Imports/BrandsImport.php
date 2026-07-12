<?php

namespace App\Imports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandsImport implements ToModel, WithHeadingRow, SkipsOnError, WithChunkReading
{
    use SkipsErrors;

    public function model(array $row)
    {
        $name = trim($row['name'] ?? $row['brand_name'] ?? '');
        if (empty($name)) return null;

        $imageInput = $row['logo'] ?? $row['logo_url'] ?? $row['image'] ?? null;
        $logoPath = $this->handleImage($imageInput);

        return new Brand([
            'name'        => $name,
            'description' => $row['description'] ?? '',
            'status'      => $row['status'] ?? 'active',
            'logo'        => $logoPath,
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
        $path = 'brands/' . $filename;
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

            $path = 'brands/' . Str::uuid() . '.' . $extension;
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

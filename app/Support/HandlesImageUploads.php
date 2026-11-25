<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUploads
{
    protected function storeImage(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    /**
     * @param  array<int, UploadedFile>  $files
     * @return array<int, string>
     */
    protected function storeImages(array $files, string $directory): array
    {
        $paths = [];

        foreach ($files as $file) {
            $paths[] = $this->storeImage($file, $directory);
        }

        return $paths;
    }

    protected function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

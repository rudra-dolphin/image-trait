<?php

namespace ImagesManagement\ImageTrait;

use Illuminate\Support\Facades\Storage;


trait ImagesTrait
{
    // Upload Image Trait Method
    public function uploadMedia($media, $name, $filepath, $filenameold, $deleteOlder = true)
    {

        if ($deleteOlder == true) {
            $this->deleteImage($filepath, $filenameold);
        }
        if ($media->isValid()) {
            $fileName = time() . '-' . $name . '.' . $media->getClientOriginalExtension();
            $media->storeAs($filepath, $fileName, 'public');
            return $fileName;
        }
        return null;
    }

    // Upload Images Trait Method
    public function uploadImages(array $images, $name, $filepath, $filenameold, $deleteOlder = true): array
    {
        $uploadedImages = [];
        
        $fullFilePath =  $filepath;

        if ($deleteOlder) {
            $this->deleteImage($filepath, $filenameold);
        }
        foreach ($images as $file) {
            $fileName = $name . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($fullFilePath, $fileName, 'public');
            $uploadedImages[] = $fileName;
        }

        return $uploadedImages;
    }

    // Delete Image Trait Method
    public function deleteImage($filepath, $image)
    {
        $fullPath = $filepath . '/' . $image;
        if (Storage::disk('public')->exists($fullPath)) {
            Storage::disk('public')->delete($fullPath);
        }
        return null;
    }

    // Delete Multiple Images Trait Method
    public function deleteMultipleImages(array $images, $path)
    {
        foreach ($images as $image) {
            $this->deleteImage($path, $image);
        }
    }
}

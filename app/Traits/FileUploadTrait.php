<?php

namespace App\Traits;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait FileUploadTrait
{
    /**
     * Handle Image Upload to Cloudinary
     */
    function uploadImage(Request $request, $inputName, $oldPath = NULL, $path = "upload", $width = null, $height = null)
    {
        if ($request->hasFile($inputName)) {

            // 1. Purani image agar Cloudinary par hai toh use delete karein
            if ($oldPath && str_contains($oldPath, 'cloudinary.com')) {
                $this->removeImage($oldPath);
            }

            $file = $request->file($inputName);

            // 2. Cloudinary options (Folder name setup)
            $options = [
                'folder' => trim($path, '/') // Default ab "upload" folder jayega
            ];

            // 3. Resizing logic (Cloudinary Transformations)
            // Agar aap controller se width/height bhejenge, toh Cloudinary auto-resize karega
            if (!is_null($width) && !is_null($height)) {
                $options['transformation'] = [
                    'width' => $width,
                    'height' => $height,
                    'crop' => 'fill', // Image ko properly fit karega
                    'gravity' => 'auto' // Face ya main object par focus rakhega
                ];
            }

            // 4. Upload and get Secure URL (https://...)
            $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), $options)->getSecurePath();

            return $uploadedFileUrl;
        }

        return NULL;
    }

    /**
     * Remove file from Cloudinary using URL
     */
    function removeImage(string $path): void
    {
        if ($path && str_contains($path, 'cloudinary.com')) {
            try {
                // URL se Public ID nikalne ka logic
                $parts = explode('/upload/', $path);
                if (isset($parts[1])) {
                    // Version number (v12345...) ko hatana
                    $fileAndPath = preg_replace('/^v\d+\//', '', $parts[1]);
                    
                    // Folder + Filename nikalna (Public ID)
                    $publicId = pathinfo($fileAndPath, PATHINFO_DIRNAME) . '/' . pathinfo($fileAndPath, PATHINFO_FILENAME);

                    // Cloudinary se delete karna
                    Cloudinary::destroy(trim($publicId, './'));
                }
            } catch (\Exception $e) {
                // Logger mein error daal sakte hain agar delete fail ho
                \Log::error("Cloudinary delete failed: " . $e->getMessage());
            }
        }
    }
}

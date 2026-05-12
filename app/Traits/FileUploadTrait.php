<?php

namespace App\Traits;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait FileUploadTrait
{
    function uploadImage(Request $request, $inputName, $oldPath = NULL, $path = "uploads", $width = null, $height = null)
    {
        if ($request->hasFile($inputName)) {

            if ($oldPath && $oldPath !== '/uploads/default.png') {
                $this->removeImage($oldPath);
            }

            $file = $request->file($inputName);

            $options = [
                'folder' => trim($path, '/')
            ];

            if (!is_null($width) && !is_null($height)) {
                $options['transformation'] = [
                    'width' => $width,
                    'height' => $height,
                    'crop' => 'fill'
                ];
            }

            $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), $options)->getSecurePath();

            return $uploadedFileUrl;
        }

        return NULL;
    }

    /**
     * Remove file from Cloudinary
     */
    function removeImage(string $path): void
    {
        if ($path && str_contains($path, 'cloudinary.com')) {
            $parts = explode('/upload/', $path);
            if (isset($parts[1])) {
                $fileAndPath = preg_replace('/^v\d+\//', '', $parts[1]);
                $publicId = pathinfo($fileAndPath, PATHINFO_DIRNAME) . '/' . pathinfo($fileAndPath, PATHINFO_FILENAME);

                if (trim($publicId, './') !== '') {
                    Cloudinary::destroy(trim($publicId, './'));
                }
            }
        }
    }
}

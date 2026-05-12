<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

trait FileUploadTrait
{
    function uploadImage(Request $request, $inputName, $oldPath = NULL, $path = "/uploads", $width = null, $height = null)
    {
        if ($request->hasFile($inputName)) {

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;

            $destinationPath = public_path($path);

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            if (!is_null($width) && !is_null($height)) {
                $manager = ImageManager::usingDriver(GdDriver::class);
                $img = $manager->decode($image);
                $img->resize($width, $height);
                $img->save($destinationPath . '/' . $imageName);
            } else {
                $image->move($destinationPath, $imageName);
            }

            if ($oldPath && $oldPath !== '/uploads/default-avatar.jpg') {
                $cleanedOldPath = ltrim($oldPath, '/');
                if (File::exists(public_path($cleanedOldPath))) {
                    File::delete(public_path($cleanedOldPath));
                }
            }

            return $path . '/' . $imageName;
        }

        return NULL;
    }

    /**
     * Remove file
     */
    function removeImage(string $path): void
    {
        if ($path && $path !== '/uploads/default-avatar.jpg') {
            $cleanedPath = ltrim($path, '/');
            if (File::exists(public_path($cleanedPath))) {
                File::delete(public_path($cleanedPath));
            }
        }
    }
}

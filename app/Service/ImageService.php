<?php

namespace App\Service;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class ImageService
{


    public static function resize($absolutePath)
    {
        $img = Image::make($absolutePath)->widen(20);

        $path = 'uploads/images/thumbnails_' . basename($absolutePath);
        $imageName = public_path($path);

        $img->save($imageName);

        $movedPath = 'uploads/images/thumbnails/' . basename($absolutePath);
        Storage::disk('navegador')->makeDirectory('uploads/images/thumbnails');
        Storage::disk('navegador')->move($path, $movedPath);
        return $movedPath;
    }
}

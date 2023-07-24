<?php

namespace App\Service;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
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

    public static function downloadImage($url, $path)
    {
        // Descargamos la imagen
        $response = Http::get($url);

        // Obtenemos el contenido de la respuesta
        $content = $response->getBody()->getContents();

        $type = $response->header('Content-Type');

        // Generamos un nombre para el archivo
        $extension = Str($type)->endsWith('jpeg') ? 'jpg' : 'png';
        $name = Str::random(40) . '.' . $extension;

        // Generamos el path donde se va a almacenar el archivo
        $path = $path.'/'.$name;
        file_put_contents($path, $content);

        return $name;
    }
}

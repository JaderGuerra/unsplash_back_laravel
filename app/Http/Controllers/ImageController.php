<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Requests\PostCreateRequest;
use App\Service\ImageService;

class ImageController extends Controller
{
    public function uploadImage(PostCreateRequest $request)
    {

        $label = $request->input('label');

        if( $request->hasFile('image_path') ) {
            $image = $request->file('image_path');
            $imagePath = $image->store('uploads/images', 'navegador');
        }
        else {
            $imagePath = 'uploads/images/' . ImageService::downloadImage($request->url, public_path('uploads/images/'));
        }

        $imageThumbnail = ImageService::resize(public_path($imagePath));

        $file = new File();
        $file->label = $label;
        $file->image_path = $imagePath;
        $file->image_path_thumbnail = $imageThumbnail;

        $file->save();

        $imageName = url($imagePath);

        return response()->json([
            'message'       => 'Imagen cargada exitosamente',
            'image_name'    =>  $imageName,
            'image_thumbnail'    =>  url($imageThumbnail),
        ], 200);
    }

    public function listImages()
    {
        $response = File::orderBy('created_at', 'DESC')->get();
        return $response;
    }

    public function searchImages(Request $request)
    {
        $search = $request->query('q');
        return File::where('label', 'LIKE', "%$search%")->get();
    }

    /* public function addUrlToImage($images)
    {
        return $images->map(function ($file) {
            $file->image_path = url($file->image_path);
            return $file;
        });
    } */
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\File;

class ImageController extends Controller
{
    public function uploadImage(PostCreateRequest $request)
    {

        $label = $request->input('label');
        $image = $request->file('image_path');

        $imagePath = $image->store('image_path', 'public');

        $file = new File();
        $file->label = $label;
        $file->image_path = $imagePath;
        $file->save();

        $imageName = basename($imagePath);

        return response()->json([
            'message'       => 'Imagen cargada exitosamente',
            'image_name'    =>  $imageName,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Account;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AvatarController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request -> validate([
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:1000'],
        ]);

        // Se obtiene el usario que esta haciendo el Request
        $user = $request->user();

        // Upload an Image File to Cloudinary with One line of Code
        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();


        // Se hace uso del Trait para asociar esta imagen con el modelo user
        $user->attachImage($uploadedFileUrl);
        // Uso de la función padre
        return $this->sendResponse('Avatar actualizado satisfactoriamente');

    }
}


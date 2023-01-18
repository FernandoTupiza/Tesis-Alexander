<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documentos;
use App\Models\Materias;
use Illuminate\Support\Facades\Validator;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DocumentosAdminController extends Controller
{
    public function store_admin (Request $request, Materias $materias)
    {
        $doc=$request -> validate([

            'documentos' => ['required', 'file', 'mimes:pdf', 'max:200000'],
        ]);

        // $documentos = $request->documentos();

        $doc1 = $doc [ 'documentos'];
  
   
        // Upload any File to Cloudinary with One line of Code



        $uploadedFileUrl = Cloudinary::uploadFile($doc1->getRealPath())->getSecurePath();
        // // Upload any File to Cloudinary with One line of Code
        // $uploadedFileUrl = Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();
        // $doc1->attachImage($uploadedFileUrl);

        $documentos = new Documentos($request->all());
        $documentos->materias_id = $materias->id;
      
        $documentos->path= $uploadedFileUrl;
        $documentos->save();
        
        return $this->sendResponse('Documento subido  satisfactoriamente');

    }


    public function update_admin(Request $request, Documentos $documentos)
    {
        $doc=$request -> validate([
            'documentos' => ['required', 'file', 'mimes:pdf', 'max:200000'],
        ]);

        // $documentos = $request->documentos();

        $doc1 = $doc [ 'documentos'];
  
   
        // Upload any File to Cloudinary with One line of Code



        $uploadedFileUrl = Cloudinary::uploadFile($doc1->getRealPath())->getSecurePath();

        $documentos -> update( [
            'path'  => $uploadedFileUrl,
        ]);
        return $this->sendResponse('Documento se ha actualizado satisfactoriamente');
    }

    //FUNCION PARA VER UNA MATERIA
    public function show_admin (Request $request, $id){

        $documentos = Documentos::find($id);
        if($documentos){
        return response()->json([
            'mesagge' => 'Path del documento a vizualizarse',
            'data'=> $documentos

        ]);
        }else{
            return response()->json([
                'message' => 'No existe ninguna path con ese id.',


            ], 404);

        }
    }
    
        //FUNCION PARA VER TODAS LOS DOCUMENTOS CREADOS  CREADAS
        public function index_admin (Request $request){

                $documentos = Documentos::all();
                return response()->json([
                    'data'=> $documentos

                ]);

        }

}

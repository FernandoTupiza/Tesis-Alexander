<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentos;
use Illuminate\Support\Facades\Validator;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class DocumentosController extends Controller
{
    public function store(Request $request)
    {
        // $rules=array(
        //     'materias_id' => 'required|numeric',
        // );
        // $messages=array(

        //     'materias_id.unique' => 'La materia debe ser unica',
        // );
        
        // $validator=Validator::make($request->all(),$rules,$messages);
        // if($validator->fails())
        // {
        //     $messages=$validator->messages();
        //     return response()->json(["messages"=>$messages], 500);
        // }$documentos = new Documentos();
        // $documentos->materias_id= $request->materias_id;

        // // $registro->password_confirmation = $request->password_confirmation;
        // $documentos->save();
        // return response()->json(["documentos" => $documentos, "message"=>"El documento se ha creado satisfactoriamente"], 200);

  
        $doc=$request -> validate([

            // 'materias_id' => 'required|numeric',
            'documentos' => ['required', 'file', 'mimes:pdf', 'max:200000'],
        ]);

        // $documentos = $request->documentos();

        $doc1 = $doc [ 'documentos'];
  
   
        // Upload any File to Cloudinary with One line of Code



        $uploadedFileUrl = Cloudinary::uploadFile($doc1->getRealPath())->getSecurePath();
        // // Upload any File to Cloudinary with One line of Code
        // $uploadedFileUrl = Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();
        // $doc1->attachImage($uploadedFileUrl);
        
        Documentos::create([
            'path' => $uploadedFileUrl,
        ]);

        return $this->sendResponse('Documento subido  satisfactoriamente');

    }


    public function update(Request $request, Documentos $documentos)
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
            public function show (Request $request, $id){

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

}

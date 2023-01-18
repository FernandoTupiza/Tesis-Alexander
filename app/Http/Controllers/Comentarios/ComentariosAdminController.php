<?php

namespace App\Http\Controllers\Comentarios;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComentarioSistema;
use App\Http\Resources\Resource;
use App\Models\Materias;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ComentariosAdminController extends Controller
{
//FUNCION PARA CREAR COMENTARIOS
public function store_admin (Request $request, Materias $materias)
{
    $rules=array(

        'comentario' => 'required|string',
    );
    $messages=array(

        'comentario.required' => 'Debe tener un comentario.',
        // 'password_confirmation.required' => 'Ingrese la confirmación de la contraseña.',

    );
    
    $validator=Validator::make($request->all(),$rules,$messages);
    if($validator->fails())
    {
        $messages=$validator->messages();
        return response()->json(["messages"=>$messages], 500);
    }
    
    $comentarios = new ComentarioSistema($request->all());

    $comentarios ->materias_id = $materias->id;

    $user = Auth::user();

    $comentarios->user_id = $user->id;
    // $registro->password_confirmation = $request->password_confirmation;
    $comentarios->save();
    return response()->json(["comentarios" => $comentarios, "message"=>"El comentario se ha creado satisfactoriamente"], 200);

}
//FUNCION PARA VER LOS COMENTARIOS
    public function index_admin (Request $request){

        $comentarios = ComentarioSistema::all();

        return response()->json([
            'data'=> $comentarios

        ]);
    }

//FUNCION PARA VER UN COMENTARIOS
    public function show_admin ( $id){

        $comentarios = ComentarioSistema::find($id);
        if($comentarios){
            return response()->json([
                'mesagge' => 'Comentario a vizualizarse',
                'data'=> $comentarios

            ]);
        }else{
             return response()->json([
            'message' => 'No existe ninguna carrera con ese id.',


            ], 404);

        }
    }
//FUNCION PARA ACTUALIZAR COMENTARIOS
    public function update_admin (Request $request, $id){

        $fields = $request->validate([

            'comentario' => 'nullable|string',
            
        ]);

        $comentarios = ComentarioSistema::find($id);


        if($comentarios){
            $comentarios->update($fields);

            return response()->json([
                'message' => 'El comentario se actualizado satisfactoriamente.',
                'data'=> $comentarios
            ]);
        }
        else{
            return response()->json([
                'message'=> 'No existe ningun comentario con ese id.'
    
            ], 404);

        }


    }

    // FUNCION PARA ELIMINAR COMENTARIOS
    public function delete_admin (Request $request, $id){


        $comentarios = ComentarioSistema::find($id);


        if($comentarios){
            $comentarios->delete();

            return response()->json([
                'message'=> 'El comentario se ha eliminado satisfactoriamente'
            ]);
        }
        else{
            return response()->json([
                'message'=> 'No existe ninguna comentario con ese id.'
    
            ], 404);

        }


    }
}

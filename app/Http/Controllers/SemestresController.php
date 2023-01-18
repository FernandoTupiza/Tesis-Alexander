<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semestres;
use App\Http\Resources\Resource;
use App\Models\Carreras;
use Illuminate\Support\Facades\Validator;


class SemestresController extends Controller
{

    //---------FUNCION PARA CREAR LOS SEMESTRES-------------//
    public function store(Request $request, Carreras $carreras)
    {
        $rules=array(
            'nombre' => 'required|string|unique:semestres',
            'descripcion' => 'required|string',

        );
        $messages=array(
            'nombre.unique' => 'El semestre debe ser unico',
            'descripcion.required' => 'Debe tener una descripción.',

        );
        
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages=$validator->messages();
            return response()->json(["messages"=>$messages], 500);
        }
        
        $semestres = new Semestres($request->all());
        $semestres ->carreras_id = $carreras->id;

        // $registro->password_confirmation = $request->password_confirmation;
        $semestres ->save();
        return response()->json(["semestres" => $semestres , "message"=>"El semestre se ha creado satisfactoriamente"], 200);

    }

    //-----------------------------------------------------//

    //-------FUNCION PARA VER LOS SEMESTRES ACTIVOS--------//
    public function index (){

        $semestres = Semestres::where('estado',1)->get();

        return response()->json([
            'data'=> $semestres

        ]);
    }
    //-----------------------------------------------------//


    //---FUNCION PARA VER TODOS LOS SEMESTRES CREADOS-----//
    public function index_admin (){

        $semestres = Semestres::all();

        return response()->json([
            'data'=> $semestres

        ]);
    }
    //-----------------------------------------------------//


    //FUNCION PARA VER UN SEMESTRE
    public function show ( $id){

        $semestres = Semestres::find($id);
        if($semestres){
            return response()->json([
                'data'=> $semestres

            ]);
        }else{
            return response()->json([
                'message' => 'No existe ningun semestre con ese id.',

    
            ], 404);
        }
    }

    //FUNCION PARA ACTUALIZAR LOS SEMESTRES
    public function update (Request $request, $id){

        $fields = $request->validate([
            'carreras_id' => 'required|numeric',
            'nombre' => 'nullable|string',
            'descripcion' => 'nullable|string',
            // 'encargado' => 'nullable|string'
            
        ]);

        $semestres = Semestres::find($id);


        if($semestres){
            $semestres->update($fields);

            return response()->json([
                'message' => 'El semestre se actualizado satisfactoriamente.',
                'data'=> $semestres
            ]);
        }
        else{
            return response()->json([
                'message'=> 'No existe ningun semestre  con ese id.'
    
            ], 404);

        }


    }

    //ACTIVAR E INACTIVAR SEMESTRE

    
    public function destroy (Semestres $semestres){


        // $carreras = Carreras::find($id);
    $semestres_estado = $semestres->estado;
    $mensaje = $semestres_estado ? "Inactiva":"Activa";
    $semestres->estado = !$semestres_estado;
    $semestres->save();

    return $this->sendResponse(message: "El semestres esta $mensaje ");


    }






}

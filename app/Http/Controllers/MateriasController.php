<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materias;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\Validator;

class MateriasController extends Controller
{
    //FUNCION PARA CREAR MATERIAS
    public function store(Request $request)
    {
        $rules=array(
            'semestres_id' => 'required|numeric',
            'nombre' => 'required|string|unique:materias',
            'descripcion' => 'required|string',
            'encargado' => 'required|string|'
        );
        $messages=array(
            'semestres_id.required' => 'Debe tener un id de semestre.',
            'nombre.unique' => 'La materia debe ser unica',
            'descripcion.required' => 'Debe tener una descripción.',
            'encargado.required' => 'Ingrese una persona a cargo.',
            // 'password_confirmation.required' => 'Ingrese la confirmación de la contraseña.',

        );
        
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails())
        {
            $messages=$validator->messages();
            return response()->json(["messages"=>$messages], 500);
        }$materias = new Materias();
        $materias->semestres_id = $request->semestres_id;
        $materias->nombre= $request->nombre;
        $materias->descripcion = $request->descripcion;
        $materias->encargado = $request->encargado;
        // $registro->password_confirmation = $request->password_confirmation;
        $materias->save();
        return response()->json(["materias" => $materias, "message"=>"La materia se ha creado satisfactoriamente"], 200);

    }

        //FUNCION PARA VER LAS MATERIAS CREADAS ACTIVAS
        public function index (Request $request){


            $materias = Materias::where('estado',1)->get();
            return response()->json([
                'data'=> $materias
                
            ]);
        }
        
        //FUNCION PARA VER TODAS LA MATERIAS CREADAS
        public function index_admin (Request $request){

            $materias = Materias::all();
            return response()->json([
                'data'=> $materias

            ]);
        }
        
        //FUNCION PARA VER UNA MATERIA
        public function show (Request $request, $id){

            $materias = Materias::find($id);
            if($materias){
            return response()->json([
                'mesagge' => 'Materia a vizualizarse',
                'data'=> $materias
    
            ]);
        }else{
            return response()->json([
                'message' => 'No existe ninguna materia con ese id.',

    
            ], 404);

        }
        }


        //FUNCION PARA ACTUALIZAR LA MATERIA
        public function update (Request $request, $id){

            $fields = $request->validate([
                'semestres_id' => 'required|numeric',
                'nombre' => 'nullable|string',
                'descripcion' => 'nullable|string',
                'encargado' => 'nullable|string'
                
            ]);

            $materias = Materias::find($id);


            if($materias){
                $materias->update($fields);

                return response()->json([
                    'message' => 'La materia se actualizado satisfactoriamente.',
                    'data'=> $materias
                ]);
            }
            else{
                return response()->json([
                    'message'=> 'No existe ninguna carrera con ese id.'

                ], 404);

            }
    

        }

        //FUNCION PARA ACTIVAR Y DESACTIVAR 

        
        public function destroy (Materias $materias){


            // $carreras = Carreras::find($id);
        $materias_estado = $materias->estado;
        $mensaje = $materias_estado ? "inactivo":"activo";
        $materias->estado = !$materias_estado;
        $materias->save();

        return $this->sendResponse(message: "La materia esta $mensaje ");


        }

}

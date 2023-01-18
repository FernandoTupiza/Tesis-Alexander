<?php

namespace App\Http\Controllers\Semestres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semestres;
use App\Http\Resources\Resource;
use App\Models\Carreras;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
class SemestresEstudianteController extends Controller
{
        //---------FUNCION PARA CREAR LOS SEMESTRES-------------//
        public function store_estudiante (Request $request, Carreras $carreras)
        {
            $response = Gate::inspect('gestion-semestres');

            if($response->allowed())
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
            }else{
                echo $response->message();
            }
        
        }
        
        //-----------------------------------------------------//
    
        //-------FUNCION PARA VER LOS SEMESTRES ACTIVOS--------//
        public function index_estudiante (){
    
            $semestres = Semestres::where('estado',1)->get();
    
            return response()->json([
                'data'=> $semestres
    
            ]);
        }
        //-----------------------------------------------------//
    
    
        //---FUNCION PARA VER TODOS LOS SEMESTRES CREADOS-----//
        public function index_estudianteE (){
            $response = Gate::inspect('gestion-semestres');

            if($response->allowed())
            {
                $semestres = Semestres::all();
        
                return response()->json([
                    'data'=> $semestres
        
                ]);
            }else{
                echo $response->message();
            }
        
        }
        //-----------------------------------------------------//
    
    
        //FUNCION PARA VER UN SEMESTRE
        public function show_estudiante ( $id){
            $response = Gate::inspect('gestion-semestres');

            if($response->allowed())
            {
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
            }else{
                echo $response->message();
            }
        
        }
    
        //FUNCION PARA ACTUALIZAR LOS SEMESTRES
        public function update_estudiante (Request $request, $id){
            $response = Gate::inspect('gestion-semestres');

            if($response->allowed())
            {
                $fields = $request->validate([
 
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
            }else{
                echo $response->message();
            }
        
        
        
            }
        
            //ACTIVAR E INACTIVAR SEMESTRE
        
            
            public function destroy_estudiante (Semestres $semestres){
        
                $response = Gate::inspect('gestion-semestres');

                if($response->allowed())
                {
                        // $carreras = Carreras::find($id);
                    $semestres_estado = $semestres->estado;
                    $mensaje = $semestres_estado ? "Inactiva":"Activa";
                    $semestres->estado = !$semestres_estado;
                    $semestres->save();
                
                    return $this->sendResponse(message: "El semestres esta $mensaje ");
                
                }else{
                    echo $response->message();
                }
        
                }
                
    
    
    
    
    
}

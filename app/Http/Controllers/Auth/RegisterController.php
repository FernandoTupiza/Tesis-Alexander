<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

// use App\Http\Controllers\Auth\Validator;

class RegisterController extends Controller
{

    public function registro(Request $request)
    {
        $fields = $request->validate([
            'role_id' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
            
        ]);

        $user = User::create([
            'role_id' => $fields['role_id'],
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        //$token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'message' => 'Usuario registrado satisfactoriamente'
            //'token' => $token
        ];

        return response($response, 201);
    }


    // public function register_valido(Request $request)
    // {


    //     $rules=array(
    //         'role_id' => 'required|numeric',
    //         'first_name' => 'required|string',
    //         'last_name' => 'required|string',
    //         'email' => 'required|string|unique:users,email',
    //         'password' => 'required|string|confirmed'

    
    //     );
    //     $messages=array(
    //         'role_id.required' => 'Ingrese el rol',
    //         'first_name.required' => 'Ingrese el nombre',
    //         'last_name.required' => 'Ingrese el apellido',
    //         'email.unique' => 'El email del registro debe ser unico .',
    //         'password.required' => 'Ingrese una contraseña.',
    //         // 'password_confirmation.required' => 'Ingrese la confirmación de la contraseña.',

    //     );
        
    //     $validator=Validator::make($request->all(),$rules,$messages);
    //     if($validator->fails())
    //     {
    //         $messages=$validator->messages();
    //         return response()->json(["messages"=>$messages], 500);
    //     }$registro = new User;
    //     $registro->role_id = $request->role_id;
    //     $registro->first_name = $request->first_name;
    //     $registro->last_name = $request->last_name;
    //     $registro->email = $request->email;
    //     $registro->password = $request->password;
    //     // $registro->password_confirmation = $request->password_confirmation;
    //     $registro->save();
    //     return response()->json(["usuario" => $registro, "message"=>"El registro ha sido satisfactorio"], 200);
    // }

}

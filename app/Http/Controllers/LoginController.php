<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    //

    // function test(){
    //     return "Funciones desde controller";
    // }

    // function Hola(){
    //     return "Funciones PRUEBA";
    // }

    //Funcio para ingresar usuario
    function registrar(Request $request){
        $user = New User;        
        $user->create($request->all());
        $data['password']=bcrypt($request->password);//bcrypt para encriptar el password
        $user->create($data);
        return response()->json(["message"=>"Usuario creado exitosamente"]);
    }

    //Función para hacer la autenticación
    function inicio(Request $request){
        $datosUsuario = $request->all();

        if (Auth::attempt($datosUsuario)){
            $user = User::find(Auth::user()->id);

            $datosUsuario['token'] = $user->createToken('authToken')->plainTextToken;
            return response()->json(['respose'=>'Encontrado',usuario=>$datosUsuario,]);
        }else{
            return response()->json(['respose'=>'No encontrado','message'=>"Credencial invalida"]);
        }
    }
}

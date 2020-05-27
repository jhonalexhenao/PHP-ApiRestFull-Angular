<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

//use Illuminate\Support\Facades\DB;
use App\Usuario;

class UsuarioController extends Controller
{
    //



    public function index() {

        $json = array(
            "detalle"=>"No encontrado"
        );

        return json_encode($json, true);
    
    }


    /**
     * @param Request $request
     * FUNCION PARA CREAR REGISTRO
     * @return void
     */
    public function store(Request $request) {
        //recoger datos 
        $datos = array("nombre"=>$request->input("nombre"),
                        "contraseña"=>$request->input("contraseña"),
                        "perfil"=>$request->input("perfil")    );

        if(!empty($datos)){

                       

        //Validar datos 
        $validator = Validator::make($datos, [
            'nombre' => 'required|unique:usuarios|max:255',
            'contraseña' => 'required|string|max:255',
            'perfil' => 'required|string|max:255',
            //'email' => 'required|string|email|max:255|unique:usuarios'
        ]); 

        //si falla la validación
        
        if ($validator->fails()) {
            
            $json = array(

                "detalle" =>"Registro con errores"

            );

            return json_encode($json, true);

        }else{

            $id_cliente = Hash::make($datos["nombre"].$datos["contraseña"].$datos["perfil"]);
            $llave_secreta = Hash::make($datos["perfil"].$datos["contraseña"].$datos["nombre"], ['rounds' => 12]);

            $usuario = new Usuario();
            $usuario->nombre = $datos["nombre"];
            $usuario->contraseña = $datos["contraseña"];
            $usuario->perfil = $datos["perfil"];
            $usuario->id_cliente = str_replace('$','-', $id_cliente);
            $usuario->llave_secreta = str_replace('$','-', $llave_secreta);

            $usuario->save();

            $json = array(

                "status" => 200,
                "detalle" => "Registro exitoso, tome sus credenciales y guardelas", 
                "credenciales"=> array("id_cliente:" => str_replace('$','-', $id_cliente), "llave_secreta:" => str_replace('$','-', $llave_secreta))  

            );
            
            return json_encode($json, true);

            }

        }else {

            $json = array(

                "status" => 404,
                "detalle" =>"Registro con errores"

            );

            return json_encode($json, true);
        }
        //echo '<pre>'; print_r($datos); echo '</pre>';
    }

    
}

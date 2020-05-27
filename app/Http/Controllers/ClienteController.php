<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Cliente;
use App\Usuario;

class ClienteController extends Controller
{
   
    public function index(Request $request) {

        $token = $request->header('Authorization');
        $usuario = Usuario::all();
        $json = array();


        foreach ($usuario as $key => $value) {
            //echo 'aqui estoy en foreach';
            
            if("Basic ".base64_encode($value["Id_cliente"].":".$value["llave_secreta"]) == $token){

                $clientes = Cliente::all();

                if(!empty($clientes)){
        
                    //echo '<pre>'; print_r("estoy en clientes".$clientes); echo '</pre>';
        
                    $json = array(
        
                        "status" => 200,
                        "Total_registros" => count($clientes),
                        "detalles" => $clientes
            
                    );
        
                }else{
        
                    $json = array(
        
                        "status" => 200,
                        "Total_registros" => 0,
                        "detalles" => "No hay ningún curso registrado"
            
                    );
        
                }
            }else{

                $json = array(
        
                    "status" => 404,
                    "Total_registros" => 0,
                    "detalles" => "No esta Autorizado para recibir la información"
        
                );

            }

        }

       
        //echo '<pre>'; print_r($usuario); echo '</pre>';
      



        return json_encode($json, true);

    }

    public function store(Request $request) {
        
        $token = $request->header('Authorization');
        $usuario = Usuario::all();
        $json = array();

        foreach ($usuario as $key => $value) {
            //echo 'aqui estoy en foreach';
            //echo 'Estoy aqui en el post';
            
            if("Basic ".base64_encode($value["Id_cliente"].":".$value["llave_secreta"]) == $token){

                echo 'Estoy aqui en el post';
                $datos = array("nombre"=>$request->input("nombre"),
                        "codigo"=>$request->input("codigo"),
                        "documento"=>$request->input("documento"),
                        "tipoDocumento"=>$request->input("tipoDocumento"),
                        "imagen"=>$request->input("imagen"),
                        "email"=>$request->input("email"),
                        "telefono"=>$request->input("telefono"),
                        "cupo"=>$request->input("cupo")   );

                        if(!empty($datos)) {

                            //Validar datos 
                            $validator = Validator::make($datos, [
                                'nombre' => 'required|unique:clientes|max:255',
                                'documento' => 'string|max:255|unique:clientes',
                                'tipoDocumento' => 'string|max:255',
                                'imagen' => 'string|max:255',
                                'email' => 'string|max:255',
                                
                                //'email' => 'required|string|email|max:255|unique:usuarios'
                            ]); 

                            //si falla la validación
                            
                            if ($validator->fails()) {
                                
                                $json = array(

                                    "detalle" =>"Registro con errores"

                                );

                                return json_encode($json, true);

                            }


                
                        }else{

                            $json = array(
        
                                "status" => 404,
                                "detalles" => "Los registros no pueden estar vacios"
                    
                            );
                        }

                        echo '<pre>'; print_r($datos); echo '</pre>';

                        return;

            }else {
                
            }


        }

        return json_encode($json, true);        

    }


}

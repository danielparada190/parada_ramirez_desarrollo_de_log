<?php
ini_set('display_error' , 1);
ini_set('display_startup_error' , 1);
include('inc/funciones.inc.php');
include('secure/ips.php)');

$metodo_permitido = "POST";
$archivo = "../logs/log.log";
$dominio_autorizado = "localhost";
$ip = ip_in_ranges($_SERVER["REMOTE_ADDR"], $rango);
$txt_usuario_autorizado = "admin";
$txt_password_autorizado = "admin";


//SE VERIFICA QUE LA DIRECCION DE ORIGEN SEA AUTORIZADA
if(array_key_exists("HTTP_REFERER",$_SERVER)){
    //VIENE DE UNA PAGINA DENTRO DEL SISTEMA

    if(strpos($_SERVER["HTTP_REFERER"],$dominio_autorizado)){

        if($ip === true){

            if($SERVER["REQUEST_METHOD"] == $metodo_permitido){
                //LIMPIEZA DE VALORES DESDE QUE VIENEN DESDE EL FORMULARIO
                $valor_campo_usuario = (     (array_key_exists("txt_user" ,$POST)) ? htmlspecialchars(stripslashes(trim($_POST["txt_user"])),ENT_QUOTES) :"" );
                $valor_campo_password = (     (array_key_exists("txt_pass" ,$POST)) ? htmlspecialchars(stripslashes(trim($_POST["txt_pass"])),ENT_QUOTES) :"" );


                //SE VERIFICA QUE LOS VALORES DE LOS CAMPOS SEA DIFERENTE A VACIO

                if(($valor_campo_usuario != "" || strlen($valor_campo_usuario) > 0) and
                ($valor_campo_password != "" || strlen($valor_campo_password) > 0) ){

                    $usuario = preg_match('/^[a-zA-Z0-9]{1,10}+$/' , $valor_campo_usuario); //SE VERIFICA CON UN PATRON SI EL VALOR DEL CAMPO USUARIO CUMPLE CON LAS CONDICIONES ACEPTABLES
                    $password = preg_match('/^[a-zA-Z0-9]{1,10}+$/' , $valor_campo_password); //SE VERIFICA CON UN PATRON SI EL VALOR DEL CAMPO USUARIO CUMPLE CON LAS CONDICIONES ACEPTABLES

                    if($usuario !== false and $usuario !== 0 and $password !== false and $password !==0){

                        if($valor_campo_usuario === $txt_usuario_autorizado and $valor_campo_password === $txt_password_autorizado){

                            echo("HOLA MUNDO");
                            crear_editar_log($archivo , "EL CLIENTE INICIO SESION SATISFACTORIAMENTE" , 1,$SERVER["REMOTE_ADDR"],$SERVER["HTTP_REFERER"],$SERVER["HTTP_USER_AGENT"]);
                                
                            //6
                        }else{
                            crear_editar_log($archivo,"CREDENCIALES INCORRECTAS ENVIADAS HACIA // $SERVER[HTTP_HOST] $SERVER[HTTP_REQUEST_URI]", 2,$SERVER["REMOTE_ADDR"],$SERVER["HTTP_USER_AGENT"]);
                            header ("HTTP/1.1 301 Moved Permanetly");
                            header ("Location: ../?status= 6");
                        }

                    }else{
                        crear_editar_log($archivo,"ENVÍO DE CAMPOS VACÍOS AL SERVIDOR",2,$SERVER[HTTP_HOST] $SERVER[HTTP_REQUEST_URI]", 2,$SERVER["REMOTE_ADDR"],$SERVER["HTTP_USER_AGENT"]);
                            header ("HTTP/1.1 301 Moved Permanetly");
                            header ("Location: ../?status= 5");
                    }

                        }


                    }else{

                    }


                }

            }else {


            }            
        }else{


        }
    } else {


    }


}else {

}


?>
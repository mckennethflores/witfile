<?php
session_start();
require_once "../modelos/Perfil.php";

$usuario = new Perfil();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nom_us=isset($_POST["nom_us"])? limpiarCadena($_POST["nom_us"]):"";
$usu_us=isset($_POST["usu_us"])? limpiarCadena($_POST["usu_us"]):"";
$cla_us=isset($_POST["cla_us"])? limpiarCadena($_POST["cla_us"]):"";
$rol_id_us=isset($_POST["rol_id_us"])? limpiarCadena($_POST["rol_id_us"]):"";
$imagen_us=isset($_POST["imagen_us"])? limpiarCadena($_POST["imagen_us"]):"";

$nuevaclaveusuario=isset($_POST["nuevaclaveusuario"])? limpiarCadena($_POST["nuevaclaveusuario"]):"";// Datos del input Ventana Modal

    switch($_GET["op"]){

        case 'mostrar':
            $rspta=$usuario->mostrar();
            echo json_encode($rspta);
        break;

        case 'actualizAracceso':
            $mensaje = "";
            $guardo = false;

            $claveactual=isset($_POST["claveactual"])? limpiarCadena($_POST["claveactual"]):"";
            $nuevaclave=isset($_POST["nuevaclave"])? limpiarCadena($_POST["nuevaclave"]):"";
            $repetirclave=isset($_POST["repetirclave"])? limpiarCadena($_POST["repetirclave"]):"";

            $clavehash=hash("SHA256",$claveactual);

            $rspta=$usuario->verificar($claveactual);

            if($rspta && !empty($rspta['id'])){

                //$nuevaclavehash=hash("SHA256",$nuevaclave);
                $rstaCambioClave = $usuario->actualizarClave($claveactual, $nuevaclave);
                $rsptaActualizada = $usuario->verificar($nuevaclave);

                if($rsptaActualizada  && !empty($rsptaActualizada['idusuario'])){

                    if($rsptaActualizada && !empty($rsptaActualizada['idusuario'])){
                        $guardo = true;
                        $mensaje = "La clave se actualizó con exito";
                    }

                }else{
                    $mensaje = "Error al momento de actualizar la clave";
                }
            }else{
                $mensaje = "Error!. No se pudo actualizar la clave";
            }

            $respuesta = array(
                'mensaje' => $mensaje,
                'rsta' => $guardo
            );

            echo json_encode($respuesta);

        break;
}
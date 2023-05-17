<?php
session_start();
require_once "../modelos/Rol.php";

$rol=new Rol();
$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nom_rol=isset($_POST["nom_rol"])? limpiarCadena($_POST["nom_rol"]):"";


    switch($_GET["op"]){
        
        case 'guardaryeditar':

            if(empty($id)){
                $rspta=$rol->insertar($nom_rol);
                echo $rspta ? "Registrad(a)": "No se puedo registrar";
            }else{
                $rspta=$rol->editar($id,$nom_rol);
                echo $rspta ? "Actualizad(a)": "No se puedo actualizar";
            }
        break;

        case 'desactivar';
                $rspta=$rol->desactivar($id);
                echo $rspta ? "Desactivad(a)": "No se pudo desactivar";
        break;

        case 'activar':
            $rspta=$rol->activar($id);
            echo $rspta ? "Activad(a)": "No se puedo activar";
        break;

        case 'mostrar':
            $rspta=$rol->mostrar($id);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$rol->listar();
            $data= Array();
            while ($reg=$rspta->fetch_object()){

                $data[]=array(
                    "0"=>($reg->con_rol)?"<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-danger' onclick='desactivar(".$reg->id.")'><i class='fa fa-close'></i></button>":
                    "<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-primary' onclick='activar(".$reg->id.")'><i class='fa fa-check'></i></button>",
                    "1"=>$reg->nom_rol,
                    "2"=>$reg->con_rol

                );
            }
            $results = array(
                "sEcho"=>1, // Info para el datables
                "iTotalRecords"=>count($data), // Envio total de registros al datatables
                "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        break;
        
        case "selectRol":
            require_once "../modelos/Rol.php";
            $rol = new Rol();
            $rspta = $rol->listarRol();
            echo '<option value="0" selected disabled>Seleccione porfavor</option>';        
            while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->id_rol. '>' . $reg->nom_rol . '</option>';
                }
        break;

}
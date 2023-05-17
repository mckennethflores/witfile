<?php
session_start();
require_once "../modelos/ClientePotencial.php";

$clientepotencial=new ClientePotencial();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$id_em_cp=isset($_POST["id_em_cp"])? limpiarCadena($_POST["id_em_cp"]):"";
$id_cl_cp=isset($_POST["id_cl_cp"])? limpiarCadena($_POST["id_cl_cp"]):"";
$fec_cp=isset($_POST["fec_cp"])? limpiarCadena($_POST["fec_cp"]):"";


    switch($_GET["op"]){
        
        case 'guardaryeditar':

            if(empty($id)){
                $rspta=$clientepotencial->insertar($id_em_cp,$id_cl_cp,$fec_cp);
                echo $rspta ? "Registrad(a)": "No se puedo registrar";
            }else{
                $rspta=$clientepotencial->editar($id,$id_em_cp,$id_cl_cp,$fec_cp);
                echo $rspta ? "Actualizad(a)": "No se puedo actualizar";
            }
        break;

        case 'mostrar':
            $rspta=$clientepotencial->mostrar($id);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$clientepotencial->listarCliente();
            $data= Array();
            while ($reg=$rspta->fetch_object()){

                $data[]=array(
                    "0"=>($reg->id)?"<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-danger' onclick='desactivar(".$reg->id.")'><i class='fa fa-close'></i></button>":
                    "<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-primary' onclick='activar(".$reg->id.")'><i class='fa fa-check'></i></button>",
                    "1"=>$reg->nom_em,
                    "2"=>$reg->nom_cl,
                    "3"=>$reg->fec_cp

                );
            }
            $results = array(
                "sEcho"=>1, // Info para el datables
                "iTotalRecords"=>count($data), // Envio total de registros al datatables
                "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        break;
        

}
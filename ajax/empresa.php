<?php
session_start();
require_once "../modelos/Empresa.php";

$empresa=new Empresa();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nom_em=isset($_POST["nom_em"])? limpiarCadena($_POST["nom_em"]):"";
$tel_em=isset($_POST["tel_em"])? limpiarCadena($_POST["tel_em"]):"";
$url_em=isset($_POST["url_em"])? limpiarCadena($_POST["url_em"]):"";
$ema_em=isset($_POST["ema_em"])? limpiarCadena($_POST["ema_em"]):"";
$dir_em=isset($_POST["dir_em"])? limpiarCadena($_POST["dir_em"]):"";
$id_usuario_emp=isset($_POST["id_usuario_emp"])? limpiarCadena($_POST["id_usuario_emp"]):"";


//$id_asi_emp=isset($_POST["id_asi_emp"])? limpiarCadena($_POST["id_asi_emp"]):"";
$ruc_em=isset($_POST["ruc_em"])? limpiarCadena($_POST["ruc_em"]):"";
$raz_em=isset($_POST["raz_em"])? limpiarCadena($_POST["raz_em"]):"";

    switch($_GET["op"]){
        
        
        case 'guardaryeditar':

            if(empty($id)){
                // Validar si el nombre y apellido
                $rspta=$empresa->validateExistCompany($nom_em,$ruc_em,$raz_em);
                $data= Array();
                while ($reg=$rspta->fetch_object()){
                    $data[]=array(  "0"=>$reg->id );
                }
                if(count($data)>0){
                    echo "La empresa ya se encuentra registrada";
                    return;
                }

                $rspta=$empresa->insertar($nom_em,$tel_em,$url_em,$ema_em,$dir_em,$id_usuario_emp,$ruc_em,$raz_em);
              //  echo  $rspta;
              echo $rspta ? "La empresa se ha registrado satisfactoriamente": "La empresa no se ha podido registrar";
                //echo  $id_usuario_emp;
            }else{               
                $rspta=$empresa->editar($id,$nom_em,$tel_em,$url_em,$ema_em,$dir_em,$ruc_em,$raz_em);
               // echo $rspta; return;
               echo $rspta ? "Empresa actualizada satisfactoriamente": "La empresa no se ha podido actualizar";
            }
        break;

        case 'desactivar';
                $rspta=$empresa->desactivar($id);
                echo $rspta ? "Empresa desactivada satisfactoriamente": "La empresa no se ha podido desactivar";
        break;

        case 'activar':
            $rspta=$empresa->activar($id);
            echo $rspta ? "Empresa Activada satisfactoriamente": "La empresa no se ha podido activar";
        break;

        case 'mostrar':
            $rspta=$empresa->mostrar($id);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$empresa->listar();
            $data= Array();
            while ($reg=$rspta->fetch_object()){
                $cond = $reg->con_emp;
                $str = '';
                if($cond == '1'){
                    $str .= 'Activado';
                }else{
                    $str .= 'Desactivado';
                }
                $data[]=array(
                    "0"=>($reg->con_emp)?"<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-danger' onclick='desactivar(".$reg->id.")'><i class='fa fa-close'></i></button>":
                    "<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-primary' onclick='activar(".$reg->id.")'><i class='fa fa-check'></i></button>",
                    "1"=>$reg->nom_em,
                    "2"=>$reg->tel_em,
                    "3"=>$reg->url_em,
                    "4"=>$str,
                    "5"=>$reg->nom_us

                );
            }
            $results = array(
                "sEcho"=>1, // Info para el datables
                "iTotalRecords"=>count($data), // Envio total de registros al datatables
                "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        break;
        
        case 'selectEmpresa':
            require_once "../modelos/Empresa.php";
            $empresa = new Empresa();
            $rspta = $empresa->listar();
            echo '<option value="0" selected disabled>Seleccione porfavor</option>';    
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id . '>' . $reg->nom_em . '</option>';
            }
        break;
}
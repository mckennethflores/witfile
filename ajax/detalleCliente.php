<?php
session_start();
require_once "../modelos/DetalleCliente.php";

$detcliente=new DetalleCliente();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$asunto_actreu=isset($_POST["asunto_actreu"])? limpiarCadena($_POST["asunto_actreu"]):"";
$fecini_actreu=isset($_POST["fecini_actreu"])? limpiarCadena($_POST["fecini_actreu"]):"";
$fecfin_actreu=isset($_POST["fecfin_actreu"])? limpiarCadena($_POST["fecfin_actreu"]):"";
$dec_actreu=isset($_POST["dec_actreu"])? limpiarCadena($_POST["dec_actreu"]):"";
$recordatorio=isset($_POST["recordatorio"])? limpiarCadena($_POST["recordatorio"]):"";


$idActividadReunion=isset($_POST["idActividadReunion"])? limpiarCadena($_POST["idActividadReunion"]):"";

$idReunion= isset($_GET["idReunion"])? $id =$_GET["idReunion"] : "";

    switch($_GET["op"]){
        case 'obtenerRecordatorios':
            $rspta = $detcliente->obtenerRecordatorios();
            $data = '';
            $counter = 0;
            while ($reg=$rspta->fetch_object()){
                $data .= '<div>Reunión: '.$reg->nom_re.'<br>Actividad: '.$reg->asunto_actreu.'<br>Fecha: '.$reg->fecini_actreu.' -- '.$reg->fecfin_actreu.'<br>Recordatorio: '.$reg->recordatorio.'</div>
                <a class="btnReunion" href="./detalleCliente.php?op=mostrarReuniones&idReunion='.$reg->id_reu_actreu.'">Ir</a><hr style="margin-top: 5px; margin-bottom: 5px;">';
                $counter++;
                if ($counter == 3) {
                    break;
                }
            }
            if ($counter == 0) {
                $data .= 'No hay ninguna alerta pendiente.';
            }
            echo json_encode([
                'count' => $counter,
                'print_data' => $data
            ]);
        break;

        case 'mostrarReuniones':
            $rspta=$detcliente->mostrarReuniones($id);
            echo json_encode($rspta);
        break;

        case 'listarReuniones':

            $rspta=$detcliente->listarReuniones();
            $data= Array();
            while ($reg=$rspta->fetch_object()){
                $archivo = "";
                if(!$reg->archivo_pdf_word == '' || !$reg->archivo_pdf_word == null){

                    $archivo .= "<a href='../files/reuniones/".$reg->archivo_pdf_word."'> <img src='../files/word.png' height='25px' width='25px'></a>";
                }

                $cond = $reg->con_re;
                $str = '';
                if($cond == '1'){
                    $str .= 'Activado';
                }else{
                    $str .= 'Desactivado';
                }
                $data[]=array(
                    "0"=>
                    ($reg->con_re)?
                    "<button class='btn btn-warning' onclick='mostrarReuniones(".$reg->idreunion.")'><i class='fa fa-pencil'></i></button>".
                    "".
                    " <button class='btn btn-danger' onclick='eliminar(".$reg->idreunion.")'><i class='fa fa-close'></i></button>":
                    "<button class='btn btn-warning' onclick='mostrarReuniones(".$reg->idreunion.")'><i class='fa fa-pencil'></i></button>".
                    " ",
                    "1"=>"<div onclick='showWhitoutEdit(".$reg->idreunion.")'>".$reg->nom_re."</div>",
                    "2"=>$reg->cos_re,
                    "3"=>$reg->nom_em,
                    "4"=>$reg->fec_re,
                    "5"=>$reg->idetapa,
                    "6"=>$str,
                    "7"=>$archivo,
                    "8"=>$reg->nom_us
                );
            }
            $results = array(
                "sEcho"=>1, // Info para el datables
                "iTotalRecords"=>count($data), // Envio total de registros al datatables
                "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        break;

        /* ACTIVIDADES */

        case 'guardaryeditaractividades':

                if(empty($id)){
                    $rspta=$detcliente->insertarActividades($idActividadReunion,$asunto_actreu,$fecini_actreu,$fecfin_actreu,$dec_actreu,$recordatorio);
                    echo $rspta ? "Se agrego la Actividad": "Actividad no se puede agregar";
                }else{
                    $rspta=$detcliente->editarActividades($id,$asunto_actreu,$fecini_actreu,$fecfin_actreu,$dec_actreu,$recordatorio);
                    echo $rspta ? "Actividad Actualizada con exito": "Actividad no se puede actualizar";
                }
        break;
    
        case 'mostrarActividad':
    
                $rspta=$detcliente->mostrarActividad($id);
                echo json_encode($rspta);
        break;
    
        case 'listarActividades':
                                                    // $id de la reunion
                $rspta=$detcliente->listarActividades($id);
                $data= Array();
                while ($reg=$rspta->fetch_object()){
    
                    $data[]=array(
                        "0"=>$reg->nom_re,
                        "1"=>$reg->fecini_actreu,
                        "2"=>$reg->fecfin_actreu,
                        "3"=>$reg->asunto_actreu,
                        "4"=>$reg->dec_actreu
                    );
                }
                $results = array(
                    "sEcho"=>1, // Info para el datables
                    "iTotalRecords"=>count($data), // Envio total de registros al datatables
                    "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                    "aaData"=>$data);
                echo json_encode($results);
        break;

        case 'listarFechasVencidas':

            function restarFecha($fechaFinal, $formatoDiferencia = '%a' )
            {
                $hoy = date("Y-m-d");
                $fechaFinal = date_create($fechaFinal);
                $hoy = date_create($hoy);
                $resultado = date_diff($hoy, $fechaFinal);
            
                return $resultado->format($formatoDiferencia);
            }
            $rspta=$detcliente->listarFechasVencidas();
            $data= Array();
            while ($reg=$rspta->fetch_object()){
                
                $resultado =  restarFecha($reg->fecfin_actreu, $formatoDiferencia = '%a' );

                $resParseInt = (int)$resultado;
                if($resParseInt <= 2){
                    $data[]=array(
                        "id"=>$reg->id,
                        "fecha_inicio"=>$reg->fecini_actreu,
                        "fecha_fin"=>$reg->fecfin_actreu, 
                        "asunto"=>$reg->asunto_actreu 
                    );
                }
            }
            echo "<pre>";
        echo json_encode($data);

        break;

        }
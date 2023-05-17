<?php
session_start();
require_once "../modelos/Reportes.php";

$reportes = new Reportes();

    switch($_GET["op"]){
        case 'cerradosPrimeraCita':
            $datos = $reportes->printCerradosPrimeraCita();
        break;
        case 'cerradosSegundaCita':
            $datos = $reportes->printCerradosSegundaCita();
        break;
        case 'prospeccion':
            $datos = $reportes->printProspeccion();
        break;
        case 'cerrados':
            $datos = $reportes->printCerrados();
        break;
        case 'cerradosMes':
            $datos = $reportes->printCerradosMes();
        break;
        case 'montoMes':
            $datos = $reportes->printMontoMes();
        break;
        case 'datosCerrados':
            $datos = $reportes->getDatosClientes();
            $data = array();
            $data['primera_cita'] = count($datos['primera_cita']);
            $data['segunda_cita'] = count($datos['segunda_cita']);
            $data['prospeccion'] = count($datos['prospeccion']);
            $data['cerrados_mes'] = count($datos['cerrados_mes']);
            $data['cerrados'] = count($datos['cerrados']);
            $data['monto_mes'] = $datos['monto_mes'];
            echo json_encode($data);
        break;

        case 'contratosCerrados':
            
            $fecha_inicio=$_REQUEST["fecha_inicio"];
            $fecha_fin=$_REQUEST["fecha_fin"];
            $id_eta_re=$_REQUEST["id_eta_re"];
            $id_eta_re=$_REQUEST["id_eta_re"];
            $id_usuario_re=$_REQUEST["id_usuario_re"];
            /* elseif ($id_usuario_re == null){
                echo "null";
            }else{
                echo "ninguna";
            } */
            
            

            $rspta = $reportes->contratosCerrados($fecha_inicio,$fecha_fin,$id_eta_re,$id_usuario_re);

            $data= Array();
            $moneda = 'S/ ';
            while ($reg = $rspta->fetch_object()){

                $data[]=array(
                    "0"=>$reg->nom_re,
                    "1"=>$moneda.$reg->cos_re,
                    "2"=>$reg->nom_pr .' '.$reg->ape_pr ,
                    "3"=>$reg->fec_created_at,
                    "4"=>$reg->nom_etapa,
                    "5"=>$reg->nom_us
                );
            }
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
}
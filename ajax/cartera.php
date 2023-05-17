<?php
session_start();
require_once "../modelos/Cartera.php";

$cartera=new Cartera();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nom_re=isset($_POST["nom_re"])? limpiarCadena($_POST["nom_re"]):"";
$cos_re=isset($_POST["cos_re"])? limpiarCadena($_POST["cos_re"]):"";
$emp_id_re=isset($_POST["emp_id_re"])? limpiarCadena($_POST["emp_id_re"]):"";
$des_re=isset($_POST["des_re"])? limpiarCadena($_POST["des_re"]):"";
$fec_re=isset($_POST["fec_re"])? limpiarCadena($_POST["fec_re"]):"";
$id_eta_re=isset($_POST["id_eta_re"])? limpiarCadena($_POST["id_eta_re"]):"";
$archivo_pdf_word=isset($_POST["archivo_pdf_word"])? limpiarCadena($_POST["archivo_pdf_word"]):"";

/* $id_usuario_re=isset($_POST["id_usuario_re"])? limpiarCadena($_POST["id_usuario_re"]):""; */

    switch($_GET["op"]){
        
        case 'guardaryeditar':

            if (!file_exists($_FILES['archivo_pdf_word']['tmp_name']) || !is_uploaded_file($_FILES['archivo_pdf_word']['tmp_name']))
            {
                $archivo_pdf_word=$_POST["archivo_pdf_word_actual"];
            }
            else 
            {
                $ext = explode(".", $_FILES["archivo_pdf_word"]["name"]);
                
                if ($_FILES['archivo_pdf_word']['type'] == "application/pdf" || $_FILES['archivo_pdf_word']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                {
                    $archivo_pdf_word = round(microtime(true)) . '.' . end($ext);
                    move_uploaded_file($_FILES["archivo_pdf_word"]["tmp_name"], "../files/reuniones/" . $archivo_pdf_word);
                }
            }

            if(empty($id)){
                $rspta=$cartera->insertar($nom_re,$cos_re,$emp_id_re,$des_re,$fec_re,$id_eta_re,$archivo_pdf_word);
                echo $rspta ? "Cartera se registro satisfactoriamente": "cartera no se puede registrar";
            }else{
                $rspta=$cartera->editar($id,$nom_re,$cos_re,$emp_id_re,$des_re,$fec_re,$id_eta_re,$archivo_pdf_word);
                //  echo $rspta
             
                echo $rspta ? "cartera se Actualizo satisfactoriamente": "cartera no se pudo actualizar";
            }
        break;

        case 'desactivar';
                $rspta=$cartera->desactivar($id);
                echo $rspta ? "Desactivad(a)": "No se pudo desactivar";
        break;

        case 'activar':
            $rspta=$cartera->activar($id);
            echo $rspta ? "Activad(a)": "No se puedo activar";
        break;

        case 'mostrar':
            $rspta=$cartera->mostrar($id);
            echo json_encode($rspta);
        break;
        case 'eliminar':
            $rspta=$cartera->eliminar($id);
            echo $rspta ? "Registro eliminado con exito": "Registro no se pudo eliminar";
        break;
        case 'listar_historico':
            $id=isset($_GET["id"])? limpiarCadena($_GET["id"]):"";
            $rspta=$cartera->listarHistorico($id);
            $data = Array();
            while ($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0" => ucfirst($reg->tipo),
                    "1" => $reg->descripcion,
                    "2" => date('d/m/Y H:i',strtotime($reg->fecha_modificacion)),
                );
            }
            $results = array(
                "sEcho"=>1, // Info para el datables
                "iTotalRecords"=>count($data), // Envio total de registros al datatables
                "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        break;
        case 'listar':
            $rspta=$cartera->listar();
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
                    "<button class='btn btn-warning disabled' )'><i class='fa fa-pencil'></i></button>".
                    "".
                    " <button class='btn btn-danger disabled' )'><i class='fa fa-close'></i></button>":
                    "<button class='btn btn-warning disabled' )'><i class='fa fa-pencil'></i></button>".
                    " ",
                    "1"=>"<a href='detalleCliente.php?op=mostrarReuniones&idReunion=".$reg->idreunion."'>".$reg->nom_re."</a>",
                    "2"=>$reg->cos_re,
                    "3"=>$reg->nom_pr.' '.$reg->ape_pr,
                    "4"=> date('d/m/Y H:i',strtotime($reg->fec_created_at)),
                    "5"=>"<button class='btn btn-warning' onclick='mostrarHistorico(".$reg->idreunion.")'><i class='fa fa-book'></i></button>",
                    "6"=>"<small class='badge btn-success'>".$reg->idetapa." </small>",
                    "7"=>"<small class='badge btn-info'>".$str." </small>",
                    "8"=>$archivo,
                    "9"=>$reg->nom_us
                );
            } 
            $results = array(
                "sEcho"=>1, // Info para el datables
                "iTotalRecords"=>count($data), // Envio total de registros al datatables
                "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        break;
        
/*         case 'selectLinea':
            require_once "../modelos/Linea.php";
            $cartera = new Linea();
            $rspta = $cartera->listar();
            while ($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id . '>' . $reg->nomproductolinea . '</option>';
            }
        break; */
}
<?php
session_start();
require_once "../modelos/Reuniones.php";

$reuniones=new Reuniones();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nom_re=isset($_POST["nom_re"])? limpiarCadena($_POST["nom_re"]):"";
$cos_re=isset($_POST["cos_re"])? limpiarCadena($_POST["cos_re"]):"";
$emp_id_re=isset($_POST["emp_id_re"])? limpiarCadena($_POST["emp_id_re"]):"";
$des_re=isset($_POST["des_re"])? limpiarCadena($_POST["des_re"]):"";
$fec_re=isset($_POST["fec_re"])? limpiarCadena($_POST["fec_re"]):"";
$id_eta_re=isset($_POST["id_eta_re"])? limpiarCadena($_POST["id_eta_re"]):"";
$archivo_pdf_word=isset($_POST["archivo_pdf_word"])? limpiarCadena($_POST["archivo_pdf_word"]):"";
$frec_pago_re=isset($_POST["frec_pago_re"])? limpiarCadena($_POST["frec_pago_re"]):"";

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
                    move_uploaded_file($_FILES["archivo_pdf_word"]["tmp_name"], "../files/adjuntos/" . $archivo_pdf_word);
                }
            }

            if(empty($id)){
               
                $rspta=$reuniones->meetingExistCustomer($emp_id_re);
                
                $data= Array();
                
                while ($reg=$rspta->fetch_object()){
                    $data[]=array(
                        "0"=>$reg->emp_id_re
                    
                    );
                }
                $result = count($data);
               /*  if($result>0){
                    //if se agrego entonces mandar un aler
                    echo "Ya se agendo una reunión con el cliente seleccionado";
                    return;
                }else{ */
                    $rspta=$reuniones->insertar($nom_re,$cos_re,$emp_id_re,$des_re,$fec_re,$id_eta_re,$archivo_pdf_word,$frec_pago_re);       
                  //  echo $rspta;
                    echo $rspta ? "La reunión se registro satisfactoriamente": "Reunión no se puede registrar";
                /* } */

                


            }else{
                $rspta=$reuniones->editar($id,$nom_re,$cos_re,$emp_id_re,$des_re,$fec_re,$id_eta_re,$archivo_pdf_word);
                //  echo $rspta
             
                echo $rspta ? "Reunión se Actualizo satisfactoriamente": "Reunión no se pudo actualizar";
            }
        break;

        case 'desactivar';
                $rspta=$reuniones->desactivar($id);
                echo $rspta ? "Desactivad(a)": "No se pudo desactivar";
        break;

        case 'activar':
            $rspta=$reuniones->activar($id);
            echo $rspta ? "Activad(a)": "No se puedo activar";
        break;

        case 'mostrar':
            $rspta=$reuniones->mostrar($id);
            echo json_encode($rspta);
        break;

        case 'listar_historico':
            $id=isset($_GET["id"])? limpiarCadena($_GET["id"]):"";
            $rspta=$reuniones->listarHistorico($id);
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
            $rspta=$reuniones->listar();
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
                    "<button class='btn btn-warning' onclick='mostrar(".$reg->idreunion.")'><i class='fa fa-pencil'></i></button>  <button class='btn btn-danger' onclick='eliminar(".$reg->idreunion.")'><i class='fa fa-trash'></i></button>":
                    "<button class='btn btn-warning' onclick='mostrar(".$reg->idreunion.")'><i class='fa fa-pencil'></i></button>  ",
                    "1"=>"<a target='_blank' href='".BASE_URL.'/files/adjuntos/'.$reg->archivo_pdf_word."'>".$reg->nom_re."</a>",
                    
                    "2"=>BASE_URL.'/files/adjuntos/'.$reg->archivo_pdf_word,
                    "3"=> date('d/m/Y H:i',strtotime($reg->fec_created_at)),
                    
                   
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
        case 'eliminar':
            $rspta=$reuniones->eliminar($id);
            echo $rspta ? "Se elimino la actividad": "No se pudo eliminar la actividad";
        break;
        case 'frecuenciaPago':
            require_once "../modelos/Reuniones.php";
            $reuniones = new Reuniones();
            $rspta = $reuniones->frecuenciaPago();
            echo '<option class="disabled" value="0" disabled selected>Seleccione</option>';

            while ($reg = $rspta->fetch_object())
            {
                echo '<option value=' . $reg->id . '>' . $reg->valor . '</option>';
            }
        break;
}
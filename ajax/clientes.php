<?php
session_start();
require_once "../modelos/Clientes.php";

$clientes=new Clientes();
//prospecto
$idprospecto=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nom_pr=isset($_POST["nom_pr"])? limpiarCadena($_POST["nom_pr"]):"";
$ape_pr=isset($_POST["ape_pr"])? limpiarCadena($_POST["ape_pr"]):"";
//Se oculto por que ahora voy a mandar paramentros por get para validar el dni. entonces lo recojo por get
//$dni_pr=isset($_POST["dni_pr"])? limpiarCadena($_POST["dni_pr"]):"";
$ema_pr=isset($_POST["ema_pr"])? limpiarCadena($_POST["ema_pr"]):"";
$tel_pr=isset($_POST["tel_pr"])? limpiarCadena($_POST["tel_pr"]):"";
$cel_pr=isset($_POST["cel_pr"])? limpiarCadena($_POST["cel_pr"]):"";
$dir_pr=isset($_POST["dir_pr"])? limpiarCadena($_POST["dir_pr"]):"";
$fec_pr=isset($_POST["fec_pr"])? limpiarCadena($_POST["fec_pr"]):"";
$des_pr=isset($_POST["des_pr"])? limpiarCadena($_POST["des_pr"]):"";

$idprospecto=isset($_POST["idprospecto"])? limpiarCadena($_POST["idprospecto"]):"";

//clientes
$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
//empresa
$id_em_cl=isset($_POST["id_em_cl"])? limpiarCadena($_POST["id_em_cl"]):"";
//lo oculte por que ahora voy a registrarlo por el formulario
//$id_prospecto_cl=isset($_POST["id_prospecto_cl"])? limpiarCadena($_POST["id_prospecto_cl"]):"";
$id_usuario_cl=isset($_POST["id_usuario_cl"])? limpiarCadena($_POST["id_usuario_cl"]):"";

$dni_pr=isset($_GET["dni_pr"])? limpiarCadena($_GET["dni_pr"]):"";



    switch($_GET["op"]){
        
        case 'guardaryeditar':

            if(empty($id)){

/*                 $rspta=$clientes->validateNameAndSurnamesRepeat($nom_pr,$ape_pr);
                $data= Array();
                while ($reg=$rspta->fetch_object()){
                    $data[]=array(  "0"=>$reg->id );
                }
                if(count($data)>0){
                    echo "El Nombre y apellido ya se encuentra registrado";
                    return;
                } */

                if($id_em_cl == ''){
                    $rspta=$clientes->insertar($nom_pr,$ape_pr,$dni_pr,$ema_pr,$tel_pr,$cel_pr,$dir_pr,$fec_pr,$des_pr,"-1",$id_usuario_cl);
                    echo $rspta ? "Cliente registrado satisfactoriamente": "El cliente no se puede registrar";
                    return;
                }
                

                $rspta=$clientes->insertar($nom_pr,$ape_pr,$dni_pr,$ema_pr,$tel_pr,$cel_pr,$dir_pr,$fec_pr,$des_pr,$id_em_cl,$id_usuario_cl);
             //  echo $rspta;
                 echo $rspta ? "Cliente registrado satisfactoriamente": "El cliente no se puede registrar";
            }else{
                //aqui meto el idprospecto para  can editarlo
                $rspta=$clientes->editar($id,$nom_pr,$ape_pr,$dni_pr,$ema_pr,$tel_pr,$cel_pr,$dir_pr,$des_pr,$id_em_cl,$idprospecto);
                
               echo $rspta ? "Cliente Actualizado satisfactoriamente": "Cliente no se puede actualizar";
            }
        break;
        case 'eliminar':
            // Cliente tiene una actividad en ejecución
            $rspta=$clientes->clienteTieneActividad($id);
            $data= Array();
            while ($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>$reg->emp_id_re
                   
                );
            }
            $result = count($data);
            if($result>0){
                //if se agrego entonces mandar un aler
              //  echo "existCustomerActivity";
                echo  "Cliente no se puede eliminar por que tiene una actividad en ejecución";
             }else{
                 //if no agregar producto
              //    echo "notExistCustomerActivity";
                 $rspta=$clientes->eliminar($id);
                 echo $rspta ? "Cliente eliminado con exito": "Cliente no se pudo eliminar";
             }
        break;
        case 'mostrar':
            $rspta=$clientes->mostrarDatosdelClienteYProspecto($id);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$clientes->listarCliente();
            $data= Array();
            while ($reg=$rspta->fetch_object()){

                $data[]=array(
                    "0"=>($reg->id)?"<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-danger' onclick='eliminar(".$reg->idprospecto.")'><i class='fa fa-close'></i></button>":
                    "<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>",
                    "1"=>$reg->nom_pr.' '.$reg->ape_pr,
                    "2"=>$reg->dni_pr,
                    "3"=> date('d/m/Y H:i',strtotime($reg->fec_created_at)),
                    "4"=>$reg->nom_us

                );
            }
            $results = array(
                "sEcho"=>1, // Info para el datables
                "iTotalRecords"=>count($data), // Envio total de registros al datatables
                "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        break;
        /* Tenemos que ir a prospecto.
        El sistema esta obteniendo la información del prospecto aun asi si llama cliente por el fin de que solo se agregue una sola vez la informacion en la
        tabla prospecto -> luego en la tabla clietnes solo agrega el idprospecto*/
        case 'selectClientes':
            require_once "../modelos/Clientes.php";
            $clientes = new Clientes();
            $rspta = $clientes->listarClienteDesvinculandoEmpresa();
            echo '<option value="0" selected disabled>Seleccione porfavor</option>';    
            while ($reg = $rspta->fetch_object())
            { 
                echo '<option value=' . $reg->id . '>' . $reg->nom_pr.' ' .$reg->ape_pr .'</option>';
            }
        break;
        case 'existCustomerInserted':
            
            $rspta=$clientes->validateDni($dni_pr);
            $data= Array();
            while ($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>$reg->dni_pr
                   
                );
            }
            $result = count($data);
            if($result>0){
                //if se agrego entonces mandar un aler
                echo "existCustomer";
             }else{
                 //if no agregar producto
                  echo "notExistCustomer";
             }

        break;
}
<?php
session_start();
require_once "../modelos/Usuario.php";

$usuario=new Usuario();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nom_us=isset($_POST["nom_us"])? limpiarCadena($_POST["nom_us"]):"";
$usu_us=isset($_POST["usu_us"])? limpiarCadena($_POST["usu_us"]):"";
$cla_us=isset($_POST["cla_us"])? limpiarCadena($_POST["cla_us"]):"";


//Rol
$rol_id_us=isset($_POST["rol_id_us"])? limpiarCadena($_POST["rol_id_us"]):"";


    switch($_GET["op"]){
        
        case 'guardaryeditar':

            if(empty($id)){
                
                
                if((int)$rol_id_us == ROL_ADMINISTRADOR){
                    $rspta=$usuario->insertarAdministrador($nom_us,$usu_us,$cla_us,$rol_id_us);
                     echo $rspta ? "Se registro el usuario Administrador Satisfactoriamente": "No se pudo registrar el usuario Administrador";
                }else if((int)$rol_id_us == ROL_VENDEDOR){

                    $rspta=$usuario->insertarVendedor($nom_us,$usu_us,$cla_us,$rol_id_us);
                    echo $rspta ? "Se registro el usuario Vendedor Satisfactoriamente": "No se pudo registrar el usuario Vendedor";
                }else{
                    echo "Rol Ingresado es equivocado: error: 408".$rol_id_us;
                }
                
             //   $rspta=$usuario->insertar($nom_us,$usu_us,$cla_us,$rol_id_us);
             //  echo $rspta; return;
           // echo $rspta ? "Usuario Registrad(a)": "Usuario No se puedo registrar";
            }else{
                $rspta=$usuario->editar($id,$nom_us,$usu_us,$cla_us,$rol_id_us);
                
                echo $rspta ? "Usuario Actualizad(a)": "Usuario No se puedo actualizar";
            }
        break;

        case 'desactivar';
                $rspta=$usuario->desactivar($id);
                echo $rspta ? "Usuario Desactivad(a)": "Usuario No se pudo desactivar";
        break;

        case 'activar':
            $rspta=$usuario->activar($id);
            echo $rspta ? "Usuario Activad(a)": "Usuario No se pudo activar";
        break;

        case 'verifyRolUser':
            $rspta=$usuario->verifyRolUser();
            $data= Array();
                while ($reg=$rspta->fetch_object()){
                    $data[]=array(  "0"=>$reg->id,"1"=>$reg->rol_id_us );
                    $rol =  $reg->rol_id_us;
                }
               if((int)$rol == 2){
                   echo "ejecutivoventas";
               }else{
                echo "administrador";
               }
             

                /* if(count($data)>0){
                    echo "El Nombre y apellido ya se encuentra registrado";
                    return;
                } */
           // echo $rspta;
           
        break;

        case 'mostrar':
            $rspta=$usuario->mostrar($id);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta=$usuario->listar();
            $data= Array();
            while ($reg=$rspta->fetch_object()){
                $cond = $reg->con_us;
                $str = '';
                if($cond == '1'){
                    $str .= 'Activado';
                }else{
                    $str .= 'Desactivado';
                }
                $data[]=array(
                    "0"=>($reg->con_us)?"<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-danger' onclick='desactivar(".$reg->id.")'><i class='fa fa-close'></i></button>":
                    "<button class='btn btn-warning' onclick='mostrar(".$reg->id.")'><i class='fa fa-pencil'></i></button>".
                    " <button class='btn btn-primary' onclick='activar(".$reg->id.")'><i class='fa fa-check'></i></button>",
                    "1"=>$reg->nom_us,
                    "2"=>$reg->usu_us,
                    "3"=>$reg->nom_rol,
                    "4"=>$str
                );
            }
            $results = array(
                "sEcho"=>1, // Info para el datables
                "iTotalRecords"=>count($data), // Envio total de registros al datatables
                "iTotalDisplayRecords"=>count($data), // Total de registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);
        break;
        
        case "selectUsuarios":
            require_once "../modelos/Usuario.php";
            $usuario = new Usuario();
            $rspta = $usuario->listar();
            echo '<option value="0" selected disabled>Seleccione porfavor</option>';
            echo '<option value="-1" >Todos</option>';
            while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->id . '>' . $reg->nom_us . '</option>';
                }
        break;

        case 'verificar':
            $usu_us=$_POST['usu_us'];
            $cla_us=$_POST['cla_us'];
            $rol_id_us=$_POST['rol_id_us'];

            //$clavehash=hash("SHA256",$cla_us);
            $rspta=$usuario->verificar($usu_us,$cla_us,$rol_id_us);
            $fetch=$rspta->fetch_object();
            if (isset($fetch))
            {
                $_SESSION['idusuario']=$fetch->id;
                $_SESSION['nomusuario']=$fetch->nom_us;
                $_SESSION['imagenusuario']=$fetch->imagen_us;
                $_SESSION['dniusuario']=$fetch->usu_us;
                $_SESSION['rol_id_us']=$fetch->rol_id_us;
                $marcados = $usuario->listarmarcados($fetch->id);

                $valores=array();
                $menu = array();
                //recorre todos los datos
                // asigna una matriz doble 
                while ($per = $marcados->fetch_object())
                {
                    array_push($valores, $per->idpermiso);
                    $menu[$per->idpermiso] = $per->nombre;
                    $menu['url'][$per->idpermiso] = $per->url;
                    $menu['id'][$per->idpermiso] = $per->id;
                    $menu['icono'][$per->idpermiso] = $per->icono;
                }
                //Esta sesión la uso para seleccionar que modulos mostrar y acceder
                $_SESSION['permisos_idmodulos'] = $valores;
                $_SESSION['permisos_nommodulos'] = $menu;
                in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
                in_array(2,$valores)?$_SESSION['prospecto']=1:$_SESSION['prospecto']=0;
                //in_array(3,$valores)?$_SESSION['empresa']=1:$_SESSION['empresa']=0;
                in_array(3,$valores)?$_SESSION['empresa']=1:$_SESSION['empresa']=0;
                in_array(4,$valores)?$_SESSION['clientes']=1:$_SESSION['clientes']=0;
                in_array(5,$valores)?$_SESSION['reuniones']=1:$_SESSION['reuniones']=0;
                in_array(6,$valores)?$_SESSION['reportes']=1:$_SESSION['reportes']=0;
                in_array(7,$valores)?$_SESSION['mi_perfil']=1:$_SESSION['mi_perfil']=0;
                /* in_array(8,$valores)?$_SESSION['detalle_cliente']=1:$_SESSION['detalle_cliente']=0; */
                in_array(8,$valores)?$_SESSION['usuario']=1:$_SESSION['usuario']=0;
                
            }
            echo json_encode($fetch);
        break;

        case 'salir':  
            session_unset();
            session_destroy();
            header("Location: ../index.php");
        break;

        case 'mostrardetalleperfil':
            
            if(!empty($_POST)){
                $idusuario=$_POST['idusuario'];
                $rspta=$usuario->mostrardetalleperfil($idusuario);
            }            
        break;
    
        case 'editarperfil':
            
            if(!empty($_POST)){
                $idusuario=$_POST['idusuario'];
                $nomusuario=$_POST['nomusuario'];
                $dniusuario=$_POST['dniusuario'];
                $rspta=$usuario->editarperfil($idusuario,$nomusuario,$dniusuario);
            }            
        break;

        case 'subir':
            if(!empty($_POST)){
                $idusuario=$_POST['idusuario'];
                $imagenusuario=$_POST['imagenusuario'];
                $rspta=$usuario->subir($idusuario,$imagenusuario);
            }          
        break;
        
        case 'selectSexousuario':
            $rspta = $usuario->listarSexousuario();
            while ($reg = $rspta->fetch_object()){
                        echo '<option value=' . $reg->id . '>' . $reg->descripcion . '</option>';
            }
        break;
        case 'selectPerfilUsuario':
            $rspta = $usuario->listarPerfilUsuario();
            while ($reg = $rspta->fetch_object()){
                        echo '<option value=' . $reg->id . '>' . $reg->descripcion . '</option>';
            }
        break;
}
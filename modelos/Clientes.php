<?php
require "../config/Conexion.php";

class Clientes{

    private $idUsuarioSesion;
    private $idRol;
    // Implementamos nuestro metodo constructor
    public function __construct(){
        $this->idUsuarioSesion = $_SESSION['idusuario'];
        $this->idRol = $_SESSION['rol_id_us'];
    }

    public function validateNameAndSurnamesRepeat($nom_pr,$ape_pr){

        $sql="SELECT  * FROM  prospecto WHERE nom_pr='$nom_pr' AND ape_pr='$ape_pr'";
       return ejecutarConsulta($sql);
      
    }
    public function validateDni($dni){

        $sql="SELECT * FROM prospecto WHERE dni_pr='$dni'";
        
        return ejecutarConsulta($sql);
    }
    // Implementamos metodo para insertar registros
    public function insertar($nom_pr,$ape_pr,$dni_pr,$ema_pr,$tel_pr,$cel_pr,$dir_pr,$fec_pr,$des_pr,$id_em_cl,$id_usuario_cl)
    {
        $sql_prospecto="INSERT INTO prospecto (nom_pr,ape_pr,dni_pr,ema_pr,tel_pr,cel_pr,dir_pr,fec_pr,des_pr,img_pr,con_pr, id_usuario_pr, fec_created_at) 
        VALUES('$nom_pr','$ape_pr','$dni_pr','$ema_pr','$tel_pr','$cel_pr','$dir_pr',date(now()),'$des_pr','img.jpg','1', '$id_usuario_cl', CURRENT_TIMESTAMP);";

        $idprospecto = ejecutarConsulta_retornarID($sql_prospecto);

        $sql_cliente="INSERT INTO cliente (id_em_cl, id_prospecto_cl,id_usuario_cl,fec_created_at) VALUES('$id_em_cl','$idprospecto','$id_usuario_cl',CURRENT_TIMESTAMP)";

        return ejecutarConsulta($sql_cliente);
    }
  /*   public function insertCustomer($idprospecto,$idempresa,$idusuario){
        $sql="INSERT INTO cliente (id_em_cl, id_prospecto_cl,id_usuario_cl,fec_created_at) VALUES('$idempresa','$idprospecto','$idusuario',CURRENT_TIMESTAMP)";
        echo $sql; return;
    } */
    // Metodo para editar registros
    public function editar($id,$nom_pr,$ape_pr,$dni_pr,$ema_pr,$tel_pr,$cel_pr,$dir_pr,$des_pr,$id_em_cl,$idprospecto)
    {
        $sql_prospecto = "UPDATE prospecto 
        SET
        nom_pr='$nom_pr',
        ape_pr='$ape_pr',
        dni_pr='$dni_pr',
        ema_pr='$ema_pr',
        tel_pr='$tel_pr',
        cel_pr='$cel_pr',
        dir_pr='$dir_pr',
        des_pr='$des_pr'

         WHERE id='$idprospecto'";
         //echo $sql_prospecto; return;
        ejecutarConsulta($sql_prospecto);

        $sql_cliente = "UPDATE cliente 
        SET
        id_em_cl='$id_em_cl',
        id_prospecto_cl='$idprospecto'
         WHERE id='$id'";
         //echo $sql_cliente; return;
        return ejecutarConsulta($sql_cliente);
    }
    public function eliminar($id)
    {
        $sql1 = "DELETE FROM `prospecto` WHERE id=$id";
        ejecutarConsulta($sql1);
        $sql2 = "DELETE FROM `cliente` WHERE id_prospecto_cl =$id";
        return ejecutarConsulta($sql2);
    }
    public function desactivar($id)
    {
        $sql1 = "UPDATE `prospecto` SET con_pr=0 WHERE id=$id";
        ejecutarConsulta($sql1);
        $sql2 = "UPDATE `cliente` SET con_cl=0 WHERE id_prospecto_cl =$id";
        return ejecutarConsulta($sql2);
    }
    // El metodo muestra los datos de un registro a modificar
    public function mostrar($id)
    {
        $sql="SELECT * FROM cliente WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function mostrarDatosdelClienteYProspecto($id)
    {
        $sql="SELECT
        cliente.id AS idcliente, 
        cliente.id_em_cl AS idempresa, 
        cliente.id_prospecto_cl AS idprospecto, 
        cliente.id_usuario_cl, 
        cliente.fec_created_at, 
        prospecto.id AS id_prospecto, 
        prospecto.nom_pr AS nombre_pr,
        prospecto.ape_pr AS apellido_pr, 
        prospecto.dni_pr AS dni_pr, 
        prospecto.ema_pr AS email_pr, 
        prospecto.tel_pr AS telefono_pr, 
        prospecto.cel_pr AS celular_pr, 
        prospecto.dir_pr AS direccion_pr, 
        prospecto.fec_pr, 
        prospecto.des_pr AS descripcion_pr, 
        prospecto.img_pr, 
        prospecto.con_pr, 
        prospecto.id_usuario_pr, 
        prospecto.fec_created_at
        FROM
        cliente
        INNER JOIN
        prospecto
        ON 
            cliente.id_prospecto_cl = prospecto.id WHERE cliente.id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // Metodo para listar los registros

    public function listarCliente()
    {
        if($this->idRol == ROL_ADMINISTRADOR){
            $sql="SELECT cliente.id, cliente.id_usuario_cl,prospecto.id as idprospecto, prospecto.dni_pr, prospecto.nom_pr, cliente.fec_created_at, prospecto.ape_pr, usuario.nom_us FROM cliente INNER JOIN empresa ON cliente.id_em_cl = empresa.id INNER JOIN prospecto ON cliente.id_prospecto_cl = prospecto.id INNER JOIN usuario ON cliente.id_usuario_cl = usuario.id WHERE prospecto.con_pr =1 AND cliente.con_cl=1 GROUP BY id desc;";
            return ejecutarConsulta($sql);
        }else{
            $sql="SELECT cliente.id, cliente.id_usuario_cl,prospecto.id as idprospecto, prospecto.dni_pr, prospecto.nom_pr, cliente.fec_created_at, prospecto.ape_pr, usuario.nom_us FROM cliente INNER JOIN empresa ON cliente.id_em_cl = empresa.id INNER JOIN prospecto ON cliente.id_prospecto_cl = prospecto.id INNER JOIN usuario ON cliente.id_usuario_cl = usuario.id WHERE prospecto.con_pr =1 AND cliente.con_cl=1 AND cliente.id_usuario_cl='$this->idUsuarioSesion' GROUP BY id desc;";
            return ejecutarConsulta($sql);
        }
    }
    public function clienteTieneActividad($id)
    {
           $sql="SELECT reuniones.id,reuniones.emp_id_re, cliente.id,cliente.id_prospecto_cl,prospecto.id
           FROM reuniones
           INNER JOIN cliente
           ON reuniones.emp_id_re = cliente.id
           INNER JOIN  prospecto
           ON cliente.id_prospecto_cl = prospecto.id
           WHERE cliente.id_prospecto_cl = $id;";
           return ejecutarConsulta($sql);
    }
    // Esto es para el select
    public function listarClienteDesvinculandoEmpresa()
    {
        if($this->idRol == ROL_ADMINISTRADOR){
            $sql="SELECT
            cliente.id,
            cliente.id_usuario_cl,
            prospecto.nom_pr,
            prospecto.ape_pr,
            cliente.fec_created_at,
            usuario.nom_us 
        FROM
            cliente
            INNER JOIN prospecto ON cliente.id_prospecto_cl = prospecto.id
            INNER JOIN usuario ON cliente.id_usuario_cl = usuario.id";
            return ejecutarConsulta($sql);
        }else{
            $sql="SELECT
            cliente.id,
            cliente.id_usuario_cl,
            prospecto.nom_pr,
            prospecto.ape_pr,
            cliente.fec_created_at,
            usuario.nom_us 
        FROM
            cliente
            INNER JOIN prospecto ON cliente.id_prospecto_cl = prospecto.id
            INNER JOIN usuario ON cliente.id_usuario_cl = usuario.id  WHERE cliente.id>0 AND cliente.id_usuario_cl='$this->idUsuarioSesion' GROUP BY id desc;";
            return ejecutarConsulta($sql);
        }
    }
    
}
?>
<?php
require "../config/Conexion.php";

class Empresa{

    private $idUsuarioSesion;
    private $idRol;
    // Implementamos nuestro metodo constructor
    public function __construct(){
        $this->idUsuarioSesion = $_SESSION['idusuario'];
        $this->idRol = $_SESSION['rol_id_us'];
    }

    public function validateExistCompany($nom_em,$ruc_em,$raz_em){

        $sql="SELECT * FROM empresa WHERE nom_em='$nom_em' OR ruc_em='$ruc_em' OR raz_em='$raz_em'";
        return ejecutarConsulta($sql);
    }
    // Implementamos metodo para insertar registros
    public function insertar($nom_em,$tel_em,$url_em,$ema_em,$dir_em,$id_usuario_emp,$ruc_em,$raz_em)
    {
        $sql="INSERT INTO empresa (nom_em, tel_em, url_em, ema_em, dir_em, id_asi_emp,con_emp,id_usuario_emp,fec_created_at,ruc_em,raz_em) VALUES('$nom_em','$tel_em','$url_em','$ema_em','$dir_em','1','1','$id_usuario_emp',CURRENT_TIMESTAMP,'$ruc_em','$raz_em')";
       //echo $sql;
       return ejecutarConsulta($sql);
    }
    // Metodo para editar registros
    public function editar($id,$nom_em,$tel_em,$url_em,$ema_em,$dir_em,$ruc_em,$raz_em)
    {
        $sql = "UPDATE empresa SET nom_em='$nom_em', tel_em='$tel_em', url_em='$url_em', ema_em='$ema_em', dir_em='$dir_em',ruc_em='$ruc_em',raz_em='$raz_em' WHERE id='$id'";
       // echo $sql;
        return ejecutarConsulta($sql);
    }
    //Metodo para desactivar 
    public  function desactivar($id)
    {
        $sql = "UPDATE empresa SET con_emp='0' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }
    //Metodo para activar 
    public  function activar($id)
    {
        $sql = "UPDATE empresa SET con_emp='1' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }
    // El metodo muestra los datos de un registro a modificar
    public function mostrar($id)
    {
        $sql="SELECT * FROM empresa WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // Metodo para listar los registros
    public function listar()
    {
        if($this->idRol == ROL_ADMINISTRADOR){
            $sql="SELECT
            usuario.nom_us, 
            usuario.id, 
            empresa.id, 
            empresa.nom_em, 
            empresa.tel_em, 
            empresa.url_em, 
            empresa.ema_em, 
            empresa.dir_em, 
            empresa.id_asi_emp, 
            empresa.con_emp, 
            empresa.id_usuario_emp, 
            empresa.fec_created_at,
            empresa.ruc_em
        FROM
            empresa
            INNER JOIN
            usuario
            ON 
                empresa.id_usuario_emp = usuario.id
        WHERE
            empresa.id > 0
        GROUP BY
            empresa.id";
            return ejecutarConsulta($sql);
        }else{
            $sql="SELECT
            usuario.nom_us, 
            usuario.id, 
            empresa.id, 
            empresa.nom_em, 
            empresa.tel_em, 
            empresa.url_em, 
            empresa.ema_em, 
            empresa.dir_em, 
            empresa.id_asi_emp, 
            empresa.con_emp, 
            empresa.id_usuario_emp, 
            empresa.fec_created_at,
            empresa.ruc_em
        FROM
            empresa
            INNER JOIN
            usuario
            ON 
                empresa.id_usuario_emp = usuario.id
        WHERE empresa.id>0 AND empresa.id_usuario_emp='$this->idUsuarioSesion' GROUP BY empresa.id desc;";
            return ejecutarConsulta($sql);
        }
    }
}
?>
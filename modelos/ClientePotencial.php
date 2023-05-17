<?php
require "../config/Conexion.php";

class ClientePotencial{

    // Implementamos nuestro metodo constructor
    public function __construct(){

    }

    // Implementamos metodo para insertar registros
    public function insertar($id_em_cp,$id_cl_cp,$fec_cp)
    {
        $sql="INSERT INTO clientepotencial (id_em_cp, id_cl_cp, fec_cp) VALUES('$id_em_cp','$id_cl_cp','$fec_cp')";
        return ejecutarConsulta($sql);
    }
    // Metodo para editar registros
    public function editar($id,$id_em_cp,$id_cl_cp,$fec_cp)
    {
        $sql = "UPDATE clientepotencial SET id_em_cp='$id_em_cp', id_cl_cp='$id_cl_cp', fec_cp='$fec_cp' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }
    //Metodo para desactivar 
    /* public  function desactivar($id)
    {
        $sql = "UPDATE clientepotencial SET con_emp='0' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }
    //Metodo para activar 
    public  function activar($id)
    {
        $sql = "UPDATE clientepotencial SET con_emp='1' WHERE id='$id'";
        return ejecutarConsulta($sql);
    } */
    // El metodo muestra los datos de un registro a modificar
    public function mostrar($id)
    {
        $sql="SELECT * FROM clientepotencial WHERE id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // Metodo para listar los registros
    public function listar()
    {
        $sql="SELECT * FROM clientepotencial GROUP BY id asc;";
        return ejecutarConsulta($sql);
    }
    public function listarCliente()
    {
        /* $sql="SELECT clientepotencial.id, cliente.id, empresa.id, id_em_cp, id_cl_cp, fec_cp, nom_cl as cli,nom_em as emp FROM clientepotencial 
        INNER JOIN cliente  ON cliente.id = clientepotencial.id
        INNER JOIN empresa  ON empresa.id = clientepotencial.id;"; */

        $sql="SELECT
        clientepotencial.id, 
        clientepotencial.id_em_cp, 
        clientepotencial.id_cl_cp, 
        clientepotencial.fec_cp, 
        empresa.nom_em, 
        cliente.nom_cl
        FROM
        clientepotencial
        INNER JOIN
        empresa
        ON 
            clientepotencial.id_em_cp = empresa.id
        INNER JOIN
        cliente
        ON 
            clientepotencial.id_cl_cp = cliente.id";
        return ejecutarConsulta($sql);
    }
    
}
?>
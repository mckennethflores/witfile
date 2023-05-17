<?php
require "../config/Conexion.php";

class Auxiliar{

    // Implementamos nuestro metodo constructor
    public function __construct(){

    }

   
    public function listar()
    {
        $sql="SELECT * FROM auxiliar WHERE tipo = 'etapaventas' GROUP BY valor asc;";
        return ejecutarConsulta($sql);
    }

    public function listarFrecuenciaPago()
    {
            $sql="SELECT * FROM `auxiliar` WHERE tipo = 'frecuenciapago'";
            return ejecutarConsulta($sql);
    }
}
?>
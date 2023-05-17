<?php
require "../config/Conexion.php";

class Login{

    public function __construct(){

    }

    public function listarRol()
	{
		$sql="SELECT * FROM rol where id_rol > 0  order by id_rol asc";
		return ejecutarConsulta($sql);		
    }
}
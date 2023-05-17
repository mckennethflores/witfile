<?php
require "../config/Conexion.php";

class Perfil{

	private $idUsuarioSesion;
    private $idRol;
    private $nomUsuario;
    private $usuUsuario;

    public function __construct(){
		$this->idUsuarioSesion = $_SESSION['idusuario'];
        $this->idRol = $_SESSION['rol_id_us'];
		$this->nomUsuario = $_SESSION['nomusuario'];
		$this->usuUsuario = $_SESSION['dniusuario'];
    }

    public function mostrar(){
        $sql="SELECT * FROM usuario WHERE id=$this->idUsuarioSesion";
        return ejecutarConsultaSimpleFila($sql);
    }
    //Función para verificar el acceso al sistema
	public function verificar($cla_us)
    {
    	$sql="SELECT id FROM usuario WHERE usu_us='$this->usuUsuario' AND cla_us='$cla_us' AND con_us='1'"; 
    	return ejecutarConsultaSimpleFila($sql);  
    }
    
	public function actualizarClave($clavehash, $nuevaclavehash){
		$sql="UPDATE usuario SET cla_us='$nuevaclavehash' WHERE usu_us='$this->usuUsuario' AND id='$this->idUsuarioSesion' AND  cla_us='$clavehash' AND con_us='1'";
        ejecutarConsulta($sql);
	}
}
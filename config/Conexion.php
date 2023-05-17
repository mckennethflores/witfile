<?php
require_once "global.php";

date_default_timezone_set('America/Lima');

$conexion= new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
mysqli_query($conexion,'SET NAMES "'.DB_ENCODE.'"');

if(mysqli_connect_errno()){
    printf("falló conexion con la base de datos %s \n".mysqli_connect_errno());
    exit();
}

if (!function_exists('ejecutarconsulta')){

    function obtenerLastId()
    {
        global $conexion;
        return $conexion->insert_id;
    }
    function ejecutarconsulta($sql){
        global $conexion;
        $query = $conexion->query($sql);
        return $query;
    }
    function ejecutarConsultaSimpleFila($sql){
        global $conexion;
        $query = $conexion->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }

    function ejecutarConsulta_retornarID($sql){
        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->insert_id;
    }
    function limpiarCadena($str){
        global $conexion;
		$str = mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
    }
    /*obtenemos un caracter aleatorio escogido de la cadena de caracteres*/
    function generarPassword($numeroCaracteres){
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; $password = "";
		for($i=0;$i<$numeroCaracteres;$i++) {
			$password .= substr($str,rand(0,62),1);
         } return $password; }
    /* Email */
    function enviaremailregistro($nombreaquien,$emailaquien,$asunto,$quienenvia,$emailquienenvia,$dniusuario,$clavegenerada){
      $to = $emailaquien; 
      $subject = $asunto;
      $mensaje = '<html> <head> <title>Sistema Online</title>  </head><body><h1>Hola '.$nombreaquien.'!</p> <table> <tr> <th>Usuario</th><th>Contraseña</th>   </tr>
       <tr> <td>'.$dniusuario.'</td><td>'.$clavegenerada.'</td>   </tr></table> </body> </html>';

      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=utf-8';
      $headers[] = 'To: '.$nombreaquien.' <'.$emailaquien.'>';
      $headers[] = 'From: '.$quienenvia.' <'.$emailquienenvia.'>';
      $headers[] = 'Bcc: oswaldoelflori@gmail.com';
      mail($to, $subject, $mensaje, implode("\r\n", $headers));
    }

    function optionselected($opselected,$value){
      if($opselected=="selected"){
        echo "<option value='".$value."'  selected='selected'>".$value."</option>";
      }
    }
    function generateCode(){
        $code = rand(100000,999999);
        return $code;
    }
}
?>
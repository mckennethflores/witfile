<?php
require "../config/Conexion.php";

class Cartera{

    private $idUsuarioSesion;
    private $idRol;
    // Implementamos nuestro metodo constructor
    public function __construct(){
        $this->idUsuarioSesion = $_SESSION['idusuario'];
        $this->idRol = $_SESSION['rol_id_us'];
    }
    // Implementamos metodo para insertar reunion
    public function insertar($nom_re,$cos_re,$emp_id_re,$des_re,$fec_re,$id_eta_re,$archivo_pdf_word)
    {
        $sql = "SELECT valor FROM auxiliar WHERE id = $id_eta_re";
        $result = ejecutarConsultaSimpleFila($sql);
        $etapa = $result['valor'];
        $sql="INSERT INTO reuniones (nom_re, cos_re, emp_id_re, des_re, fec_re, id_eta_re, con_re, id_usuario_re,fec_created_at,fec_actualizacion_reu,archivo_pdf_word) VALUES('$nom_re','$cos_re','$emp_id_re','$des_re','$fec_re','$id_eta_re','1',$this->idUsuarioSesion,CURRENT_TIMESTAMP,'1990-01-01 00:00:00','$archivo_pdf_word');";
     // echo $sql;   
        $resultado = ejecutarConsulta($sql);
        $id = obtenerLastId();
        $sql = 'INSERT INTO historico_reuniones (id_reunion, descripcion, tipo, fecha_modificacion, id_usuario) VALUES(\''.$id.'\', \'SE CREÓ LA REUNIÓN, CON ETAPA '.$etapa.'.\', \'alta\', \''.date('Y-m-d H:i:s').'\', \''.$this->idUsuarioSesion.'\')';
        ejecutarConsulta($sql);
        return $resultado;
    }
    // Metodo para editar reunion
    public function editar($id,$nom_re,$cos_re,$emp_id_re,$des_re,$fec_re,$id_eta_re,$archivo_pdf_word)
    {
        $sql = "SELECT valor FROM auxiliar WHERE id = $id_eta_re";
        $result = ejecutarConsultaSimpleFila($sql);
        $etapa = $result['valor'];

        $sql = 'INSERT INTO historico_reuniones (id_reunion, descripcion, tipo, fecha_modificacion, id_usuario) VALUES(\''.$id.'\', \'SE MODIFICÓ LA REUNIÓN, CON ETAPA '.$etapa.'.\', \'cambio\', \''.date('Y-m-d H:i:s').'\', \''.$this->idUsuarioSesion.'\')';
        ejecutarConsulta($sql);
        if($archivo_pdf_word == '' || $archivo_pdf_word == null){
            $sql = "UPDATE reuniones SET nom_re='$nom_re', cos_re='$cos_re', emp_id_re='$emp_id_re', des_re='$des_re', fec_re='$fec_re', id_eta_re='$id_eta_re', fec_actualizacion_reu=CURRENT_TIMESTAMP WHERE id='$id'";
            //  echo $sql;
            return ejecutarConsulta($sql);
        }else{
            
            $sql = "UPDATE reuniones SET nom_re='$nom_re', cos_re='$cos_re', emp_id_re='$emp_id_re', des_re='$des_re', fec_re='$fec_re', id_eta_re='$id_eta_re', archivo_pdf_word='$archivo_pdf_word',  fec_actualizacion_reu=CURRENT_TIMESTAMP WHERE id='$id'";
         // echo $sql;
            return ejecutarConsulta($sql);
        }
    }
    //Metodo para desactivar 
    public  function desactivar($id)
    {
        $sql = 'INSERT INTO historico_reuniones (id_reunion, descripcion, tipo, fecha_modificacion, id_usuario) VALUES(\''.$id.'\', \'SE DESACTIVÓ LA REUNIÓN\', \'cambio\', \''.date('Y-m-d H:i:s').'\', \''.$this->idUsuarioSesion.'\')';
        ejecutarConsulta($sql);
        $sql = "UPDATE reuniones SET con_re='0' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }
    // Eliminar
    public  function eliminar($id)
    {
        $sql = 'INSERT INTO historico_reuniones (id_reunion, descripcion, tipo, fecha_modificacion, id_usuario) VALUES(\''.$id.'\', \'SE ELIMINÓ LA REUNIÓN\', \'baja\', \''.date('Y-m-d H:i:s').'\', \''.$this->idUsuarioSesion.'\')';
        ejecutarConsulta($sql);
        $sql = "DELETE FROM reuniones WHERE id='$id'";
        return ejecutarConsulta($sql);
    }
    //Metodo para activar 
    public  function activar($id)
    {
        $sql = 'INSERT INTO historico_reuniones (id_reunion, descripcion, tipo, fecha_modificacion, id_usuario) VALUES(\''.$id.'\', \'SE ACTIVÓ LA REUNIÓN\', \'cambio\', \''.date('Y-m-d H:i:s').'\', \''.$this->idUsuarioSesion.'\')';
        $sql = "UPDATE reuniones SET con_re='1' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }
    // El metodo muestra los datos de un registro a modificar
    public function mostrar($id)
    {
        $sql="SELECT
        reuniones.id AS idreunion, 
        reuniones.id_usuario_re, 
        reuniones.nom_re, 
        reuniones.cos_re, 
        prospecto.nom_pr, 
        prospecto.ape_pr, 
        reuniones.des_re, 
        reuniones.fec_re, 
        auxiliar.valor AS nom_etapa, 
        reuniones.con_re, 
        usuario.id, 
        usuario.nom_us, 
        auxiliar.id AS idetapa, 
        reuniones.archivo_pdf_word AS archivo_pdf_word, 
        prospecto.id AS idempresa
    FROM
        reuniones
        INNER JOIN
        prospecto
        ON 
            reuniones.emp_id_re = prospecto.id
        INNER JOIN
        auxiliar
        ON 
            reuniones.id_eta_re = auxiliar.id
        INNER JOIN
        usuario
        ON 
            reuniones.id_usuario_re = usuario.id WHERE reuniones.id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // Metodo para listar los registros
    public function listar()
    {
        if($this->idRol == ROL_ADMINISTRADOR){

            $sql="SELECT
            reuniones.id AS idreunion, 
            reuniones.id_usuario_re, 
            reuniones.emp_id_re,
            reuniones.nom_re, 
            reuniones.cos_re, 
            reuniones.con_re,
            reuniones.frec_pago_re,
            reuniones.archivo_pdf_word AS archivo_pdf_word, 
            reuniones.des_re, 
            reuniones.fec_re,
            reuniones.fec_created_at,
            date_format( `reuniones`.`fec_re`, '%d-%m-%Y' ) AS `fec_re_`,
            reuniones.id_eta_re,
           cliente.id as idcliente,
           cliente.id_prospecto_cl,
           prospecto.id,
            prospecto.nom_pr, 
            prospecto.ape_pr,
            auxiliar.id AS idetapa,
            auxiliar.valor AS nom_etapa,
           usuario.id,
            usuario.nom_us
         
        FROM
       reuniones
       INNER JOIN
       cliente
       ON reuniones.emp_id_re = cliente.id
       INNER JOIN
       prospecto
       ON cliente.id_prospecto_cl = prospecto.id
       INNER JOIN
       auxiliar
       ON reuniones.id_eta_re = auxiliar.id
       INNER JOIN
       usuario
       ON  reuniones.id_usuario_re = usuario.id 
       WHERE auxiliar.valor = 'Cerrado'
       GROUP BY reuniones.id desc;";
            return ejecutarConsulta($sql);

        }else{
            $sql="SELECT
            reuniones.id AS idreunion, 
            reuniones.id_usuario_re, 
            reuniones.emp_id_re,
            reuniones.nom_re, 
            reuniones.cos_re, 
            reuniones.con_re,
            reuniones.frec_pago_re,
            reuniones.archivo_pdf_word AS archivo_pdf_word, 
            reuniones.des_re, 
            reuniones.fec_re,
            reuniones.fec_created_at,
            date_format( `reuniones`.`fec_re`, '%d-%m-%Y' ) AS `fec_re_`,
            reuniones.id_eta_re,
           cliente.id,
           cliente.id_prospecto_cl,
           prospecto.id,
            prospecto.nom_pr, 
            prospecto.ape_pr,
            auxiliar.id AS idetapa,
            auxiliar.valor AS nom_etapa,
           usuario.id,
            usuario.nom_us
         
        FROM
       reuniones
       INNER JOIN
       cliente
       ON reuniones.emp_id_re = cliente.id
       INNER JOIN
       prospecto
       ON cliente.id_prospecto_cl = prospecto.id
       INNER JOIN
       auxiliar
       ON reuniones.id_eta_re = auxiliar.id
       INNER JOIN
       usuario
       ON  reuniones.id_usuario_re = usuario.id
   WHERE reuniones.id>0 AND reuniones.id_usuario_re='$this->idUsuarioSesion' AND auxiliar.valor = 'Cerrado' GROUP BY reuniones.id desc;";
            return ejecutarConsulta($sql);
        }
    }

    public function listarHistorico($id)
    {
        if($this->idRol == ROL_ADMINISTRADOR){
            $sql="SELECT * FROM historico_reuniones WHERE id_reunion = $id";
            return ejecutarConsulta($sql);
        }else{
            $sql="SELECT * FROM historico_reuniones WHERE id_reunion = $id AND id_usuario = $this->idUsuarioSesion";
            return ejecutarConsulta($sql);
        }
    }
}
?>
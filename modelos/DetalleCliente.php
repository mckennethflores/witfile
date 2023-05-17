<?php
require "../config/Conexion.php";

class DetalleCliente{

    private $idUsuarioSesion;
    private $idRol;
    // Implementamos nuestro metodo constructor
    public function __construct(){
        $this->idUsuarioSesion = $_SESSION['idusuario'];
        $this->idRol = $_SESSION['rol_id_us'];
    }
    /* REUNIONES */

    public function obtenerRecordatorios()
    {
        $dateNow = date('Y-m-d');
        $date2Days = date('Y-m-d', strtotime($dateNow) + (24*60*60*2));
      
           // $sql = "SELECT * FROM reuniones R, act_reunion AR WHERE R.id = AR.id_reu_actreu AND AR.recordatorio >= '$dateNow' AND AR.recordatorio <= '$date2Days'";
            $sql = "SELECT * FROM 
            reuniones R,
       act_reunion AR,
              usuario U
  WHERE 
   R.id = AR.id_reu_actreu AND 
  U.id = R.id_usuario_re AND R.id_usuario_re= $this->idUsuarioSesion
  AND AR.recordatorio >= '$dateNow' AND AR.recordatorio <= '$date2Days'";
        //    $sql = "SELECT * FROM reuniones R, act_reunion AR WHERE R.id = AR.id_reu_actreu AND R.id_usuario_re = $this->idUsuarioSesion AND AR.recordatorio >= '$dateNow' AND AR.recordatorio <= '$date2Days'";
        $sql .= " ORDER BY AR.recordatorio ASC";
        return ejecutarConsulta($sql);
    }

    public function mostrarReuniones($id)
    {
        $sql="SELECT
        reuniones.id AS idreunion, 
        reuniones.id_usuario_re, 
        reuniones.nom_re, 
        reuniones.cos_re, 
        prospecto.nom_pr as nom_pr, 
        prospecto.ape_pr as ape_pr, 
        reuniones.des_re, 
        reuniones.fec_re,
        auxiliar.id AS idetapa,
        auxiliar.valor AS nom_etapa, 
        reuniones.con_re, 
        usuario.id, 
        usuario.nom_us, 
        reuniones.archivo_pdf_word AS archivo_pdf_word
        
    FROM
        reuniones
        INNER JOIN
        cliente
        ON 
        reuniones.emp_id_re = cliente.id
        INNER JOIN
        prospecto
        ON 
            cliente.id_prospecto_cl = prospecto.id
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

    public function listarReuniones()
    {
        if($this->idRol == ROL_ADMINISTRADOR){

            $sql="SELECT reuniones.id AS idreunion, reuniones.id_usuario_re, reuniones.nom_re, reuniones.cos_re, empresa.nom_em, reuniones.des_re, reuniones.fec_re,
            date_format( `reuniones`.`fec_re`, '%d-%m-%Y' ) AS `fec_re_`, auxiliar.valor AS idetapa, reuniones.con_re,reuniones.archivo_pdf_word, usuario.id, usuario.nom_us, empresa.id AS idempresa FROM reuniones INNER JOIN empresa ON reuniones.emp_id_re = empresa.id INNER JOIN auxiliar ON reuniones.id_eta_re = auxiliar.id INNER JOIN usuario ON reuniones.id_usuario_re = usuario.id";
            return ejecutarConsulta($sql);

        }else{
            $sql="SELECT reuniones.id AS idreunion, reuniones.id_usuario_re, reuniones.nom_re, reuniones.cos_re, empresa.nom_em, reuniones.des_re, reuniones.fec_re, auxiliar.valor AS idetapa, reuniones.con_re,reuniones.archivo_pdf_word, usuario.id, usuario.nom_us, empresa.id AS idempresa FROM reuniones INNER JOIN empresa ON reuniones.emp_id_re = empresa.id INNER JOIN auxiliar ON reuniones.id_eta_re = auxiliar.id INNER JOIN usuario ON reuniones.id_usuario_re = usuario.id WHERE reuniones.id>0 AND reuniones.id_usuario_re='$this->idUsuarioSesion' GROUP BY reuniones.id desc;";
            return ejecutarConsulta($sql);
        }
    }

    //ACTIVIDADES

    public function listarActividades($idReunion)
    {
        if($this->idRol == ROL_ADMINISTRADOR){

            $sql="SELECT
            act_reunion.id, 
            act_reunion.id_reu_actreu,
            reuniones.nom_re, 
            act_reunion.fecini_actreu, 
            act_reunion.fecfin_actreu, 
            act_reunion.asunto_actreu, 
            act_reunion.id_recorda_actreu, 
            act_reunion.dec_actreu, 
            act_reunion.fec_created_at,
            act_reunion.recordatorio
        FROM
            act_reunion
            INNER JOIN
            reuniones
            ON 
                act_reunion.id_reu_actreu = reuniones.id
                WHERE act_reunion.id_reu_actreu = '$idReunion'";
            return ejecutarConsulta($sql);

        }else{
             $sql="SELECT
            act_reunion.id, 
            act_reunion.id_reu_actreu,
            reuniones.nom_re, 
            act_reunion.fecini_actreu, 
            act_reunion.fecfin_actreu, 
            act_reunion.asunto_actreu, 
            act_reunion.id_recorda_actreu, 
            act_reunion.dec_actreu, 
            act_reunion.fec_created_at,
            act_reunion.recordatorio
        FROM
            act_reunion
            INNER JOIN
            reuniones
            ON 
                act_reunion.id_reu_actreu = reuniones.id AND reuniones.id_usuario_re = $this->idUsuarioSesion
                WHERE act_reunion.id_reu_actreu = '$idReunion'";
            return ejecutarConsulta($sql);
        }
    }
 
    public function insertarActividades($idActividadReunion,$asunto_actreu,$fecini_actreu,$fecfin_actreu,$dec_actreu,$recordatorio)
    {
        $sql="INSERT INTO `act_reunion` (`id_reu_actreu`, `fecini_actreu`, `fecfin_actreu`, `asunto_actreu`, `id_recorda_actreu`, `dec_actreu`, `fec_created_at`, `recordatorio`) VALUES ('$idActividadReunion', '$fecini_actreu', '$fecfin_actreu', '$asunto_actreu', '1', '$dec_actreu', current_timestamp(), '$recordatorio');";

        return ejecutarConsulta($sql);
    }
 
    public function editarActividades($id,$asunto_actreu,$fecini_actreu,$fecfin_actreu,$dec_actreu,$recordatorio)
    {
            $sql = "UPDATE act_reunion SET recordatorio='$recordatorio', asunto_actreu='$asunto_actreu', fecini_actreu='$fecini_actreu', fecfin_actreu='$fecfin_actreu', dec_actreu='$dec_actreu' WHERE id='$id'";
          
            return ejecutarConsulta($sql);
        
    }
    public function eliminarActividades($id)
    {
            $sql = "DELETE FROM act_reunion WHERE id='$id'";
          
            return ejecutarConsulta($sql);
        
    }
    public function mostrarActividad($id)
    {
        $sql="SELECT
        act_reunion.id, 
        reuniones.nom_re, 
        reuniones.id AS idReunion, 
        act_reunion.fecini_actreu, 
        act_reunion.fecfin_actreu, 
        act_reunion.asunto_actreu, 
        act_reunion.dec_actreu,
        act_reunion.recordatorio
    FROM
        act_reunion
        INNER JOIN
        reuniones
        ON 
            act_reunion.id_reu_actreu = reuniones.id WHERE act_reunion.id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // Verificar si hay fechas vencidas
    public function listarFechasVencidas()
    {
        $sql="SELECT
        act_reunion.id, 
        act_reunion.fecini_actreu, 
        act_reunion.fecfin_actreu, 
        act_reunion.asunto_actreu, 
        act_reunion.dec_actreu
    FROM
        act_reunion";
        return ejecutarConsulta($sql);
    }
     //ADJUNTOS

/*      act_reunion_files */
}
?>
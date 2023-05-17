<?php
require "../config/Conexion.php";

class Reportes{

	private $idUsuarioSesion;
    private $idRol;
    // Implementamos nuestro metodo constructor
    public function __construct(){
        $this->idUsuarioSesion = $_SESSION['idusuario'];
        $this->idRol = $_SESSION['rol_id_us'];
    }

	/* function print($name){
		$fileName = $name."-".date('d-m-Y').".xls";
		$datos = $this->getDatosClientes();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$fileName);
		//Set variable to false for heading
		$heading = false;
		$items = $datos[$name];
		//Add the MySQL table data to excel file
		if(!empty($items)) {
			foreach($items as $item) {
				$item = (array)$item;
				if(!$heading) {
					echo implode("\t", array_keys($item)) . "\n";
					$heading = true;
				}
				echo implode("\t", array_values($item)) . "\n";
			}
		}
		exit();
	} */

	public function printCerradosPrimeraCita()
	{
		return $this->print('primera_cita');
	}

	public function printCerradosSegundaCita()
	{
		return $this->print('segunda_cita');
	}

	public function printProspeccion()
	{
		return $this->print('prospeccion');
	}

	public function printCerrados()
	{
		return $this->print('cerrados');
	}

	public function printCerradosMes()
	{
		return $this->print('cerrados_mes');
	}

	public function printMontoMes()
	{
		return $this->print('monto_mes');
	}

	public function getDatosClientes()
	{
		if ($this->idRol == ROL_ADMINISTRADOR) {
			$sql = "SELECT R.id as idReunion, R.nom_re as Nombre_Reunion, A.valor as Estado_Reunion, R.fec_actualizacion_reu as fechaModificacion, R.cos_re as Costo_Reunion FROM reuniones R, auxiliar A WHERE R.id_eta_re = A.id ORDER BY R.fec_actualizacion_reu ASC";
		} else {
			$sql = "SELECT R.id as idReunion, R.nom_re as Nombre_Reunion, A.valor as Estado_Reunion, R.fec_actualizacion_reu as fechaModificacion, R.cos_re as Costo_Reunion FROM reuniones R, auxiliar A WHERE R.id_eta_re = A.id AND R.id_usuario_re = $this->idUsuarioSesion ORDER BY R.fec_actualizacion_reu ASC";
		}
		$result = ejecutarConsulta($sql);
		$datos = array('primera_cita' => array(), 'segunda_cita' => array(), 'prospeccion' => array(), 'cerrados' => array(), 'cerrados_mes' => array(), 'monto_mes' => array());
		$gananciasPorDia = array();
		$diaActual = date('d');
		$mesActual = date('m');
		for ($i=1; $i <= $diaActual; $i++) { 
			$diaARevisar = sprintf('%02d', $i);
			if (!isset($gananciasPorDia[$diaARevisar.'-'.$mesActual]) )  {
				$gananciasPorDia[$diaARevisar.'-'.$mesActual] = 0;
			}
		}
		while($res = $result->fetch_object()) {
			$sql = "SELECT * FROM act_reunion WHERE id_reu_actreu = $res->idReunion";
			$newRes = ejecutarConsulta($sql);
			$count = 0;
			while ($resx = $newRes->fetch_object()) {
				$count++;
			}
			if ($res->Estado_Reunion == 'Prospecto') {
				$datos['prospeccion'][] = $res;
			} else if ($res->Estado_Reunion == 'Ganado') {
				$datos['cerrados'][] = $res;
				$mesActual = date('m');
				$anyoActual = date('Y');
				$mesActualizacion = date('m', strtotime($res->fechaModificacion));
				$anyoActualizacion = date('Y', strtotime($res->fechaModificacion));
				if ($mesActual == $mesActualizacion && $anyoActualizacion == $anyoActual) { // SON DEL MISMO MES Y AÑO
					$dia = date('d', strtotime($res->fechaModificacion));
					if (isset($gananciasPorDia[$dia.'-'.$mesActual])) {
						$gananciasPorDia[$dia.'-'.$mesActual]+= $res->Costo_Reunion;
					} else {
						$gananciasPorDia[$dia.'-'.$mesActual]= $res->Costo_Reunion;
					}
					$datos['cerrados_mes'][] = $res;
				}
				if ($count == 0) {
					$datos['primera_cita'][] = $res;
				} else if ($count == 1){
					$datos['segunda_cita'][] = $res;
				} else {
					// NOTHING
				}
			}
		}
		
		for ($i=1; $i <= $diaActual; $i++) { 
			$diaARevisar = sprintf('%02d', $i);
			if (!isset($gananciasPorDia[$diaARevisar.'-'.$mesActual]) )  {
				$gananciasPorDia[$diaARevisar.'-'.$mesActual] = 0;
			}
		}
		$datos['monto_mes'] = $gananciasPorDia;
		return $datos;
	}

    public function contratosCerrados($fecha_inicio,$fecha_fin,$id_eta_re,$id_usuario_re){

		if($id_usuario_re == ''){
			$id_usuario_re = $this->idUsuarioSesion;
		}

		$sql="SELECT 
		reuniones.id,
		reuniones.nom_re,
		reuniones.cos_re,
		reuniones.emp_id_re, 
		reuniones.des_re, 
		reuniones.fec_re, 
		reuniones.id_eta_re, 
		reuniones.con_re, 
		reuniones.id_usuario_re, 
		reuniones.fec_created_at,
		reuniones.fec_actualizacion_reu, 
		auxiliar.id AS idetapa,
        auxiliar.valor AS nom_etapa,
		usuario.nom_us,
		cliente.id,
        cliente.id_prospecto_cl,
        prospecto.id,
        prospecto.nom_pr, 
        prospecto.ape_pr

		FROM reuniones 
		INNER JOIN
		cliente
		ON reuniones.emp_id_re = cliente.id
		INNER JOIN
		prospecto
		ON cliente.id_prospecto_cl = prospecto.id
		INNER JOIN auxiliar 
		ON reuniones.id_eta_re = auxiliar.id 
		INNER JOIN usuario
		ON reuniones.id_usuario_re = usuario.id 
		WHERE DATE(reuniones.fec_created_at)>='$fecha_inicio' AND DATE(reuniones.fec_created_at)<='$fecha_fin' AND reuniones.id_eta_re='$id_eta_re'";

		if ($id_usuario_re == '-1') {
			$sql.="";
		}else{
			$sql.=" AND reuniones.id_usuario_re = '$id_usuario_re'";
		}
		if ($this->idRol != ROL_ADMINISTRADOR) {
			$sql.=" AND reuniones.id_usuario_re = $this->idUsuarioSesion";
		}
	///	echo $sql;

		return ejecutarConsulta($sql);

	}
}

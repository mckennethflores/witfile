<?php
ob_start();
session_start();

if (!isset($_SESSION["nomusuario"]))
{
  header("Location: login.php");
}
else
{

require 'header.php';

if ($_SESSION['escritorio']==1)
{
?>
<!--Contenido-->
      <div class="content-wrapper">        
            
        <!-- Main content -->
   <!--      <section class="content">
            <div class="row">
                <div class="col-sm-4">
                    <a target="_blank" href="./../ajax/reportes.php?op=cerradosPrimeraCita" type="button" class="px-1 my-1 btn btn-success"><i class="fa fa-file-excel"></i> DESCARGAR PRIMERA CITA</a>
                </div>
                <div class="col-sm-4">
                    <a target="_blank" href="./../ajax/reportes.php?op=cerradosSegundaCita" type="button" class="px-1 my-1 btn btn-success"><i class="fa fa-file-excel"></i> DESCARGAR SEGUNDA CITA</a>
                </div>
                <div class="col-sm-4">
                    <a target="_blank" href="./../ajax/reportes.php?op=printProspeccion" type="button" class="px-1 my-1 btn btn-success"><i class="fa fa-file-excel"></i> DESCARGAR EN PROSPECCIÓN</a>
                </div>
                      <div class="col-lg-12">
                        <canvas id="barChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                      </div>
                <div class="col-sm-6">
                    <a target="_blank" href="./../ajax/reportes.php?op=cerrados" type="button" class="px-1 my-1 btn btn-success"><i class="fa fa-file-excel"></i> DESCARGAR CERRADOS EN TOTAL</a>
                </div>
                <div class="col-sm-6">
                    <a target="_blank" href="./../ajax/reportes.php?op=cerradosMes" type="button" class="px-1 my-1 btn btn-success"><i class="fa fa-file-excel"></i> DESCARGAR CERRADOS EN EL MES</a>
                </div>
                      <div class="col-lg-12">
                        <canvas id="barChart2" style="margin-top: 20px;min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                      </div>
                <div class="col-sm-12">
                    <a target="_blank" href="./../ajax/reportes.php?op=montoMes" type="button" class="px-1 my-1 btn btn-success"><i class="fa fa-file-excel"></i> DESCARGAR MONTO DEL MES</a>
                </div>
                      <div class="col-lg-12">
                        <canvas id="barChart3" style="margin-top: 20px;min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                      </div>
                    </div>
      </section> -->
      <!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php


/* 
echo var_dump($data); */
/* print_r($_SESSION['detalle_cliente']); */

}else{
    require 'noacceso.php';
  }
  require 'footer.php';
?>
<style>
.tienda {
    text-align: center;
}
</style>
<script src="../public/plugins/chartjs/Chart.min.js"></script>
<script type="text/javascript" src="scripts/escritorio.js"></script>

<?php 
}
ob_end_flush();
?>



<?php
ob_start();
session_start();

if (!isset($_SESSION["idusuario"]))
{
  header("Location: login.php");
}
else
{
require 'header.php';


?>
<!--Contenido-->
      <div class="content-wrapper">
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Reuniones</h1> <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                        <div class="box-tools pull-right">  </div>
                    </div>
                    <?php if (isset($_GET['op']) && $_GET['op'] == 'mostrarReuniones'): ?>
                      <?php if (isset($_GET['idReunion']) && $_GET['idReunion'] != '' && is_numeric($_GET['idReunion'])): ?>
                        <input type="hidden" id="mostrarReunionId" value="<?php echo $_GET['idReunion']; ?>">
                      <?php endif; ?>
                    <?php endif; ?>
                    <div class="panel-body table-responsive" id="listadoreuniones">
                        <table id="tbllistadoReuniones" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Costo</th>
                            <th>Empresa</th>
                            <th>Fecha</th>
                            <th>Etapa</th>
                            <th>Condición</th>
                            <th>Usuario</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Costo</th>
                            <th>Empresa</th>
                            <th>Fecha</th>
                            <th>Etapa</th>
                            <th>Condición</th>
                            <th>Usuario</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Titulo de la Reunión:</label>
                            <input type="hidden" name="idReunion" id="idReunion">
                            <input type="hidden" name="id_usuario_re" id="id_usuario_re" value="<?php echo $_SESSION['idusuario']; ?>">
                            <input type="text" class="form-control" name="nom_re" readonly placeholder="Titulo de la reunión" id="nom_re" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Etapa:</label>
                            <select id="id_eta_re" name="id_eta_re" class="form-control readonly selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Costo:</label>
                            <input type="text" class="form-control" name="cos_re" readonly  placeholder="S/ 10,000,000"  id="cos_re" placeholder="S/" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Cliente:</label>
                            <input type="text" class="form-control" name="emp_id_re" readonly placeholder="Cliente" id="emp_id_re" >
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripción:</label>
                            <textarea class="form-control" name="des_re" id="des_re" rows="6" readonly placeholder="Descripción de la reunión" ></textarea>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de cierre:</label>
                            <input required type="date" class="form-control" name="fec_re" id="fec_re" readonly required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Adjuntar archivo pdf o word:</label>
                            <input type="file" class="form-control" name="archivo_pdf_word" id="archivo_pdf_word">
                            <input type="hidden" name="archivo_pdf_word_actual" id="archivo_pdf_word_actual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary disabled" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button">
                            <i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    
                      <div id="acordeonContainerActividades" class="box box-success  box-solid">
                        <div class="box-header with-border">
                          <h3 class="box-title">Actividades</h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div  class="box-body" style="">
                        <table id="tbllistadoActividades" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                          
                            <th>Titulo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Asunto</th>
                            <th>Descripcion</th>
                          </thead>
                          <div id="btnActividades" class="btn-group">
                          <a data-toggle="modal" href="#modalProgramarReunion" href="#"><button type="button" class="btn btn-success">Nueva Tarea</button> 
                              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button></a>
                              <ul class="dropdown-menu" role="menu">
                                <li><a data-toggle="modal" href="#modalProgramarReunion" href="#"><b>Programar Reunión</b> </a></li>
                              <!--   <li><a href="#">Registrar Llamada</a></li> -->
                              </ul>
                          </div>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                      
                            <th>Titulo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Asunto</th>
                            <th>Descripcion</th>
                          </tfoot>
                        </table>
                        </div>
                        <!-- /.box-body -->
                      </div>

                      <div id="adjuntos" class="box box-success collapsed-box box-solid">
                        <div class="box-header with-border">
                          <h3 class="box-title">Documentos Adjuntos</h3>

                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                          </div>
                        <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div  class="box-body" style="">
                        <table id="tbllistado2" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Costo</th>
                            <th>Empresa</th>
                            <th>Fecha</th>
                            <th>Etapa</th>
                            <th>Condición</th>
                            <th>Usuario</th>
                          </thead>
                          <div class="btn-group">
                            <button type="button" class="btn btn-success">Agregar</button>
                              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Agregar Archivo</a></li>
                              </ul>
                          </div>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Costo</th>
                            <th>Empresa</th>
                            <th>Fecha</th>
                            <th>Etapa</th>
                            <th>Condición</th>
                            <th>Usuario</th>
                          </tfoot>
                        </table>
                        </div>
                        <!-- /.box-body -->
                      </div>                        
                  </div>
              </div>
          </div>
        </section>
    </div>
<!-- / Contenido-->
  <!-- Modal -->
  <div class="modal fade" id="modalProgramarReunion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Actividades</h4>
        </div>
                      <div id="formularioActividades" class="box box-success box-solid">
                          <form name="formularioActividad" id="formularioActividad" method="POST">
                              <div class="box-header with-border">
                              <h3 class="box-title">Basico</h3>
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                              </div>
                            </div>
                            <div  class="box-body" style="">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <label>Titulo de la Reunión:</label>
                              <input type="hidden" name="id" id="id">
                              <input type="hidden" name="idActividadReunion" id="idActividadReunion">
                              <input type="text" class="form-control" name="asunto_actreu" placeholder="Titulo de la reunión" id="asunto_actreu" required>
                            </div>                          
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Fecha Inicio:</label>
                              <input required type="date" class="form-control" name="fecini_actreu" id="fecini_actreu" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Fecha Fin:</label>
                              <input required type="date" class="form-control" name="fecfin_actreu" id="fecfin_actreu" required>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <label>Descripción:</label>
                              <textarea class="form-control" name="dec_actreu" id="dec_actreu" rows="8" placeholder="Descripción de la reunión" ></textarea>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Recordatorio:</label>
                              <input type="date" class="form-control" name="recordatorio" id="recordatorio">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                              <!--  <button class="btn btn-danger" onclick="cancelarform()" type="button">
                              <i class="fa fa-arrow-circle-left"></i> Cancelar</button> -->
                            </div>
                            </form>
                          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>
  <!-- Fin modal -->
   
<!-- Modal -->
<style>
  table#tbllistadoActividades {
    width: 100% !important;
}
</style>
<!-- Modal -->
<?php

require 'footer.php';
?>

<script type="text/javascript" src="scripts/detalleCliente.js"></script>
<?php 
}
ob_end_flush();
?>
<?php
ob_start();
session_start();

if (!isset($_SESSION['idusuario']))
{
  header("Location: login.php");
}
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
                          <h1 class="box-title">Actividades </h1>
                          <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Enlace</th>
                           
                            <th>Fecha</th>
                          
                            
                            <th>Condición</th>
                      
                            <th>Usuario</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Enlace</th>
                            
                            <th>Fecha</th>
                          
                            
                            <th>Condición</th>
                         
                            <th>Usuario</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body table-responsive" id="listadoHistoricoShow">
                        <table id="listadoHistorico" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Tipo de cambio</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Tipo de cambio</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                          </tfoot>
                        </table>
                        <button class="btn btn-danger" onclick="cancelarform()" type="button">
                            <i class="fa fa-arrow-circle-left"></i> Volver</button>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST" novalidate>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre: <span class="danger">*</span></label>
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="id_usuario_re" id="id_usuario_re" value="<?php echo $_SESSION['idusuario']; ?>">
                            <input type="text" class="form-control" name="nom_re"  id="nom_re"  value="" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden">
                            <label>Etapa:</label>
                            <select id="id_eta_re" name="id_eta_re" class="form-control selectpicker"  >
                            <option value="1" selected=""  >Prospecto</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden">
                            <label>Prima:</label>
                            <input type="text" class="form-control" name="cos_re" placeholder="Prima"  id="cos_re" value="1000" placeholder="S/" >
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden">
                            <label>Cliente: <span class="danger">*</span></label>
                            <select id="emp_id_re" name="emp_id_re" class="form-control selectpicker" required>
                            <option value="2" selected=""  >Clientes varios</option>
                            </select>
                            <!-- <select id="emp_id_re" name="emp_id_re" class="form-control selectpicker" data-live-search="true" required></select> -->
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden">
                            <label>Frecuencia de pago:</label>
                            <select id="frec_pago_re" name="frec_pago_re" class="form-control selectpicker" >
                            <option value="7" selected=""  >Mensual</option>
                            </select>
                         
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden">
                            <label>Descripción:</label>
                            <textarea class="form-control" name="des_re" id="des_re" rows="6" value="demo" placeholder="Descripción de la reunión" >adjunto</textarea>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 hidden">
                            <label>Fecha:</label>
                            <input required type="date" class="form-control" name="fec_re" id="fec_re" >
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Adjuntar archivo pdf o word:</label>
                            <input type="file" class="form-control" name="archivo_pdf_word" id="archivo_pdf_word">
                            <input type="hidden" name="archivo_pdf_word_actual" id="archivo_pdf_word_actual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button">
                            <i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
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
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
                      <div id="formularioActividades" class="box box-success box-solid">
                              <form name="formulario" id="formulario" method="POST">
                              <div class="box-header with-border">
                              <h3 class="box-title">Basico</h3>
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                              </div>
                            </div>
                            <div  class="box-body" style="">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Titulo de la Reunión:</label>
                              <input type="hidden" name="id" id="id">
                              
                              <input type="text" class="form-control" name="nom_re" placeholder="Titulo de la reunión" id="nom_re" required>
                            </div>                          
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Descripción:</label>
                              <textarea class="form-control" name="des_re" id="des_re" rows="6" placeholder="Descripción de la reunión" ></textarea>
                            </div> 
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Fecha:</label>
                              <input required type="date" class="form-control" name="fec_re" id="fec_re" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                              <label>Adjuntar archivo pdf o word:</label>
                              <input type="file" class="form-control" name="archivo_pdf_word" id="archivo_pdf_word">
                              <input type="hidden" name="archivo_pdf_word_actual" id="archivo_pdf_word_actual">
                              <img src="" width="150px" height="120px" id="imagenmuestra">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                              <button class="btn btn-danger" onclick="cancelarform()" type="button">
                              <i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
 
<!-- Modal -->
<?php

require 'footer.php';
?>

<script type="text/javascript" src="scripts/reuniones.js"></script>
<?php 
}
ob_end_flush();
?>
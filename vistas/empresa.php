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
                          <h1 class="box-title">Empresa <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)">
                          <i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Web</th>
                            <th>Condición</th>
                            <th>Usuario</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Web</th>
                            <th>Condición</th>
                            <th>Usuario</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="id_usuario_emp" id="id_usuario_emp" value="<?php echo $_SESSION['idusuario']; ?>">
                            <input type="text" class="form-control" name="nom_em" required placeholder="Nombre" id="nom_em">
                          </div>
                        
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Telefono:</label>
                            <input type="text" maxLength="9" class="form-control" name="tel_em"  placeholder="Nombre" id="tel_em">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Sitio Web:</label>
                            <input type="text" class="form-control" name="url_em" placeholder="Sitio Web" value="John" id="url_em">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="ema_em" placeholder="Email" id="ema_em">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="dir_em" placeholder="Dirección" id="dir_em">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>RUC:</label>
                            <input type="text" maxLength="11" class="form-control" name="ruc_em" placeholder="RUC" id="ruc_em">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Razon Social:</label>
                            <input type="text" maxLength="85" class="form-control" name="raz_em" placeholder="Razon Social" id="raz_em">
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
<?php

require 'footer.php';
?>
<script type="text/javascript" src="scripts/empresa.js"></script>
<?php 
}
ob_end_flush();

?>
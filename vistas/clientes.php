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
        <section class="content" style=" height: 580px;">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Clientes <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"> <i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Cliente</th>
                            <th>Dni</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Cliente</th>
                            <th>Dni</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario"  autocomplete="off" id="formulario" method="POST">
                        <div class="hidden form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="id_usuario_cl" id="id_usuario_cl" value="<?php echo $_SESSION['idusuario']; ?>">
                            <input type="hidden" name="idprospecto" id="idprospecto">
                        </div>
                         <!--  Datos del prospecto -->                
                         <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Nombres:</label>
                            <input type="text" class="form-control" placeholder="Nombres" name="nom_pr" id="nom_pr"  value="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Apellidos:</label>
                            <input type="text" class="form-control" placeholder="Apellidos" name="ape_pr" id="ape_pr"  value="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Dni:</label>
                            <input type="text" maxLength="8" class="form-control" placeholder="Dni" name="dni_pr" id="dni_pr"  value="" onkeyup="existCustomer()">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Email:</label>
                            <input type="email" class="form-control" placeholder="Email" name="ema_pr" id="ema_pr" value="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Telefono:</label>
                            <input type="text" maxLength="9" class="form-control" placeholder="Telefono" name="tel_pr" id="tel_pr" value="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Celular:</label>
                            <input type="text" maxLength="9" class="form-control" placeholder="Celular" name="cel_pr" id="cel_pr" value="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" placeholder="Dirección" name="dir_pr" id="dir_pr" value="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Descripción:</label>
                            <textarea class="form-control" name="des_pr" placeholder="Descripción" id="des_pr" rows="5" ></textarea>
                          </div>
                         <!-- / Datos del prospecto -->
                          <div class="hidden form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Empresa:</label>

                            <select id="id_em_cl" name="id_em_cl" class="form-control selectpicker"  data-live-search="true" required></select>
                          </div>
                          <!-- <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Cliente:</label>
                         
                            <select id="id_prospecto_cl" name="id_prospecto_cl" class="form-control selectpicker"  data-live-search="true" required></select>
                          </div> -->
                         <!--  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a data-toggle="modal" href="#myModal">
                                <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span>
                                Programar Reunion</button>
                                </a>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a data-toggle="modal" href="#myModal">
                                <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span>
                                Programar Llamada</button>
                                </a>
                          </div> -->
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

<script type="text/javascript" src="scripts/clientes.js"></script>
<?php 
}
ob_end_flush();
?>
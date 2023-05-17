<?php
ob_start();
session_start();

if (!isset($_SESSION["idusuario"]))
{
  header("Location: login.php");
}
else
{
/*     echo "<pre>";
print_r($_SESSION['idrol']);
echo "</pre>";
return; */
    require 'header.php';
if (($_SESSION['rol_id_us']==1) || ($_SESSION['rol_id_us']==2))
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row rorperfil">
                <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Mi Perfil</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="col-sm-1">

                    </div>
                    <div id="datosperfil" class="col-sm-10 col-md-10">
                        <ul class="nav-justified" id="ulavatar">
                            <li class="text-center"><img id="avatarperfil" width="110" class="img-circle"/>
                            <p>
                              <span id="usuarioavatar">...</span>
                              <a data-toggle="modal" data-target="#modalEditarAcceso" title="Editar acceso" ><i id="iconeditar" class="fa fa-pencil"></i>Editar Perfil </a>
                          </p>
                        </li>
                        </ul>
                        <div class="col-md-3 col-sm-2"></div>
                        <div class="col-md-9 col-sm-10">
                            <p class="datoperfil col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <strong>Nombres: </strong><span id="nombres" class="datosbd"></span>
                            </p>
                            <p class="datoperfil col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <strong>Usuario: </strong><span id="usuario" class="datosbd"></span>
                            </p>
                            <p class="datoperfil col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <strong>Role: </strong><span id="role" class="datosbd"></span>
                            </p>
                            
                        </div>
                    </div>
                    <div class="col-sm-1">


                    <!-- MODA PLAN DE ACCION -->
                    <div class="modal fade modal-default" id="modalEditarAcceso">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-window-close"></i></button>
                            <h4 class="modal-title"><span class="badge bg-green" id="span_plan_accion"></span></h4>
                        </div>
                        <div class="modal-body">
                            <form action="" role="form" id="formacceso" autocomplete="off">
                            <ul class="nav-justified" id="ulavatar2">
                                <li class="text-center"><img id="avatarperfil2" width="110" class="img-circle"/><p><span id="usuarioavatar2">...</span></p></li>
                            </ul>
                                <p class="text-center"><span class="text-danger" id="mensaje"></span></p>
                                <p class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label for="claveactual">Clave Actual</label>
                                    <input type="password" class="form-control" name="claveactual" id="claveactual"  placeholder="Clave">
                                </p>
                                <p class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label form="nuevaclave">Clave Nueva</label>
                                    <input type="password" class="form-control" name="nuevaclave" id="nuevaclave"  placeholder="Clave nueva">
                                </p>
                                <p class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label form="repetirclave">Repetir Clave</label>
                                    <input type="password" class="form-control" name="repetirclave" id="repetirclave"  placeholder="Repetir clave">
                                </p>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnactualizar">
                                        <!--<i class="fa fa-check-square-o">&nbsp;-->Cambiar Clave</i>
                                    </button>
                            <!-- pull-left determina posicion-->
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="btncancelar">
                                        <!--<i class="fa fa-close">&nbsp;--> Cancelar</i> 
                                    </button>
                        </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                    </div>

                    </div>
                    <!-- centro -->
            
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}else
{
  require 'noacceso.php';
}
require 'footer.php';
?>

<script type="text/javascript" src="scripts/perfil.js"></script>
<?php 
}
ob_end_flush();
?>



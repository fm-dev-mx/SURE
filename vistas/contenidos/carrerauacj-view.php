<?php 
  if($_SESSION['tipo_sbp']!="Administrador"){
    echo $lc->forzar_cierre_sesion_controlador();
  }

  $url=explode("/", $_GET['views']);  
?>

<div class="container-fluid">
<div class="page-header">
  <h1 class="text-titles"><i class="zmdi zmdi-bookmark zmdi-hc-fw"></i> Administración <small>Carreras - UACJ</small></h1>
</div>
<p class="lead"></p>
</div>

<div class="container-fluid">
	<div class="panel-body">
		<div class="container-fluid">
			<form action="<?php echo SERVERURL; ?>ajax/carrerauacjAjax.php" method="POST" data-form="Save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
									<label class="control-label">Agregar nueva carrera</label>
									<input class="form-control" type="text" name="nombreCarreraUacjAgregar" required="" maxlength="170">
								</div>
							</div>
						</div>
					</div>
					&nbsp&nbsp&nbsp<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Agregar</button>						
				</fieldset>
				<div class="RespuestaAjax"></div>					
			</form>
		</div>
	</div>
</div>

<div id="tabla">         
  <?php 
    require_once "./controladores/carreraUacjControlador.php";
    $insCarrera= new carreraUacjControlador();
  ?>

  <!-- Panel listado de carreras -->

  <div class="container-fluid">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp;LISTA DE CARRERAS</h3>
      </div>
      <div class="panel-body">
      <?php      

        if(isset($url[1])){
          $pagina=$url[1];
        }else{
          $pagina=1;
        }

        echo $insCarrera->paginador_carrera_uacj_controlador($pagina,10,1);
        ?>	
      </div>
    </div>
  </div>
</div>
	

<!--Ventana emergente para renombrar carrera-->

<form action="<?php echo SERVERURL; ?>ajax/carrerauacjAjax.php" method="POST" data-form='update' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
	<div class="modal fade" id="ren-carrera-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Renombrar carrera</h4>
				</div>
				<div class="modal-body">
					<input type="text" id="CarreraCodigoUpdate" name="CarreraCodigoUpdate" hidden="">
					<input type="text" id="CarreraPrivilegioUpdate" name="CarreraPrivilegioUpdate" hidden="">
					<input type="text" id="CarreraNombreUpdate" name="CarreraNombreUpdate" class="form-control input">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Actualizar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="RespuestaAjax"></div>
</form>

<script type="text/javascript">
  $(document).ready(function(){
    $('#uniSelect').select2();
  });

    $('#uniSelect').change(function(){
      $.ajax({
        type:"post",
        data:"uniSelect=" + $('#uniSelect').val(),
        url:"<?php echo SERVERURL; ?>ajax/carreraAjax.php",
        success:function(r){
          location.reload();
        }
      });
    });
  
</script>
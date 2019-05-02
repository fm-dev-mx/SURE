<?php 
  if($_SESSION['tipo_sbp']!="Administrador"){
    echo $lc->forzar_cierre_sesion_controlador();
  }
  
?>

<div class="container-fluid">
<div class="page-header">
  <h1 class="text-titles"><i class="zmdi zmdi-bookmark zmdi-hc-fw"></i> Administración <small>Carreras</small></h1>
</div>
<p class="lead"></p>
</div>

<?php 
  require_once "./controladores/universidadControlador.php";
  $insUniv= new universidadControlador();
  $url=explode("/", $_GET['views']);

  if(isset($_SESSION['uniSelect']))
    $codigoUni=$_SESSION['uniSelect'];
  else
    $codigoUni="";

  //Se obtiene un array con los datos de la universidad seleccionada
  $tipoConsulta="Unico";
  if(isset($codigoUni)){
    $datosUniv=$insUniv->datos_universidad_controlador($tipoConsulta,$codigoUni);
    if($datosUniv->rowCount()==1){
      $camposUniv=$datosUniv->fetch();
    }
  }

  //Se obtiene un array con los nombres de todas las universidades (para la lista desplegable)
  $tipoConsulta="Lista";
  $listaU=$insUniv->datos_universidad_controlador($tipoConsulta,$codigoUni);
  if($listaU->rowCount()>=1){
    $listaUniv=$listaU->fetchAll();
  }
?>

<div class="container-fluid">
	<div class="panel-body">
		<div class="pull-right">
			<select class="selectpicker" id="uniSelect" name="uniSelect" data-live-search="true">
				<option value="0">Seleciona un instituto</option>
			
				<!--listado de universidades - se valida con el url la que fue seleccionada-->
				<?php foreach($listaUniv as $rows){ ?> 
				<option value="<?php echo $lc->encryption($rows['UniversidadCodigo']);?>" <?php if($codigoUni==$lc->encryption($rows['UniversidadCodigo'])){echo ' selected';} ?>>
					<?php echo $rows['UniversidadNombre'];?>
				</option>	

				<?php } ?>	
			</select>
		</div>

		<p class="lead"></p>
		<br>
		<div class="container-fluid">
			<form action="<?php echo SERVERURL; ?>ajax/carreraAjax.php" method="POST" data-form="Save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
					<input class="form-control" type="hidden" name="codigoUniAgregarCarrera" value="<?php echo $codigoUni; ?>">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
									<label class="control-label">Agregar nueva carrera</label>
									<input class="form-control" type="text" name="nombreCarreraAgregar" required="" maxlength="170">
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
    require_once "./controladores/carreraControlador.php";
    $insCarrera= new carreraControlador();
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

        echo $insCarrera->paginador_carrera_controlador($pagina,3,1,$codigoUni);
        ?>	
      </div>
    </div>
  </div>
</div>
	

<!--Ventana emergente para renombrar carrera-->

<form action="<?php echo SERVERURL; ?>ajax/carreraAjax.php" method="POST" data-form='update' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
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
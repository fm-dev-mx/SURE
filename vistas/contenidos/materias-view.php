<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Administración <small>Materias</small></h1>
	</div>
	<p class="lead"></p>
</div>

<?php 
	require_once "./controladores/universidadControlador.php";
	require_once "./controladores/carreraControlador.php";
	$insUniv= new universidadControlador();
	$insCarrera= new carreraControlador();

	$url=explode("/", $_GET['views']);
	
	if(isset($_SESSION['uniSelect'])){
		$codigoUni=$_SESSION['uniSelect'];
	}else{
		$codigoUni="";
	}

	if(isset($_SESSION['carreraSelect']))	{
		$codigoCarrera=$_SESSION['carreraSelect'];
	}else{
		$codigoCarrera="";
	}

	$tipoConsulta="Unico";
	//Se obtiene un array con los datos de la universidad seleccionada
	if(isset($codigoUni)){
		$datosUniv=$insUniv->datos_universidad_controlador($tipoConsulta,$codigoUni);
		if($datosUniv->rowCount()==1){
			$camposUniv=$datosUniv->fetch();
		}
	}
	//Se obtiene un array con los datos de la carrera seleccionada
	if(isset($codigoCarrera)){
		$datosCarrera=$insCarrera->datos_carrera_controlador($tipoConsulta,$codigoCarrera);
		if($datosCarrera->rowCount()==1){
			$camposCarrera=$datosCarrera->fetch();
		}
	}

	$tipoConsulta="Lista";
	//Se obtiene un array con los nombres de todas las universidades (para la lista desplegable)
	$listaU=$insUniv->datos_universidad_controlador($tipoConsulta,$codigoUni);
	if($listaU->rowCount()>=1){
		$listaUniv=$listaU->fetchAll();
	}
	//Se obtiene un array con los nombres de todas las carreras (para la lista desplegable)
	$listaC=$insCarrera->datos_carrera_controlador($tipoConsulta,$codigoUni);
	if($listaC->rowCount()>=1){
		$listaCarrera=$listaC->fetchAll();
	}
?>

<div class="container-fluid">
	<div class="panel-body">

		<div class="pull-right">
			<!--listado de universidades ---------------------------------------------------------->
			<select class="selectpicker" id="uniSelect" name="uniSelect" data-live-search="true">
				<option value="0">Seleciona un instituto</option>						
				<?php foreach($listaUniv as $rows){ ?> 
					<option value="<?php echo $lc->encryption($rows['UniversidadCodigo']);?>" <?php if($codigoUni==$lc->encryption($rows['UniversidadCodigo'])){echo ' selected';} ?>>
						<?php echo $rows['UniversidadNombre'];?>
					</option>	
				<?php } ?>	
			</select>
			<!--listado de carreras ---------------------------------------------------------->
			<select class="selectpicker" id="carreraSelect" name="carreraSelect" data-live-search="true">
				<option value="0">Seleciona una carrera</option>			
				<?php foreach($listaCarrera as $rows){ ?> 
					<option value="<?php echo $rows['CarreraCodigo'];?>" <?php if($codigoCarrera==$rows['CarreraCodigo']){echo ' selected';} ?>>
						<?php echo $rows['CarreraNombre'];?>
					</option>	
				<?php } ?>	
			</select>
		</div>

		<p class="lead"></p>
		<br>
		<div class="container-fluid">
			<form action="<?php echo SERVERURL; ?>ajax/materiaAjax.php" method="POST" data-form="Save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
					<input class="form-control" type="hidden" name="codigoCarreraAgregarMateria" value="<?php echo $codigoCarrera; ?>">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
									<label class="control-label">Agregar nueva materia</label>
									<input class="form-control" type="text" name="nombreMateriaAgregar" required="" maxlength="170">
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
    require_once "./controladores/materiaControlador.php";
    $insMateria= new materiaControlador();
  ?>

  <!-- Panel listado de materias -->

  <div class="container-fluid">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp;LISTA DE MATERIAS</h3>
      </div>
      <div class="panel-body">
			<?php
      
        if(isset($url[1])){
          $pagina=$url[1];
        }else{
          $pagina=1;
        }
				
        echo $insMateria->paginador_materia_controlador($pagina,3,1,$codigoCarrera);
        ?>	
      </div>
    </div>
  </div>
</div>
	

<!--Ventana emergente para renombrar carrera-->

<form action="<?php echo SERVERURL; ?>ajax/materiaAjax.php" method="POST" data-form='update' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
	<div class="modal fade" id="ren-materia-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Renombrar materia</h4>
				</div>
				<div class="modal-body">
					<input type="text" id="MateriaCodigoUpdate" name="MateriaCodigoUpdate" hidden="">
					<input type="text" id="MateriaPrivilegioUpdate" name="MateriaPrivilegioUpdate" hidden="">
					<input type="text" id="MateriaNombreUpdate" name="MateriaNombreUpdate" class="form-control input">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Actualizar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="RespuestaAjax"></div>
</form>

<!--Ventana emergente para asignar-->

<form action="<?php echo SERVERURL; ?>ajax/materiaAjax.php" id="datos_cotizacion" method="POST" data-form='update' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
	<div class="modal fade" id="asignar-materia-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Asignar materia</h4>
					<?php echo $_SESSION['MateriaCodigoAsignar'];?>
					<input type="text" class="form-control" id="asignar">
				</div>
				<div class="modal-body">
					
					<div class="panel-body col-md-24 col-lg-24 col-xs-20 col-sm-20 col-lg-offset-1">
						<form class="form-horizontal" role="form" id="datos_cotizacion">			
							<div class="form-group row">				
								<div class="col-md-12">
									<input type="text" class="form-control" id="busqueda" placeholder="Selecciona materia" onkeyup='cargar();'>
								</div>																				
							</div>								
						</form>						
						<div class='outer_div'></div><!-- Carga los datos ajax -->
					</div>
						
				</div>				
			</div>
		</div>
	</div>
	<div class="RespuestaAjax"></div>
</form>




<script type="text/javascript">
  $(document).ready(function(){
    $('#uniSelect').select2();
	$('#carreraSelect').select2();
  });

    $('#uniSelect').change(function(){
      $.ajax({
        type:"post",
        data:"uniSelect=" + $('#uniSelect').val(),
        url:"<?php echo SERVERURL; ?>ajax/materiaAjax.php",
        success:function(r){
          location.reload();
        }
      });
    });

	$('#carreraSelect').change(function(){
      $.ajax({
        type:"post",
        data:"carreraSelect=" + $('#carreraSelect').val(),
        url:"<?php echo SERVERURL; ?>ajax/materiaAjax.php",
        success:function(r){
          location.reload();
        }
      });
    });  
    
</script>
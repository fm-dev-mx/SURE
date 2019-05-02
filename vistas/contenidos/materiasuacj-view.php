<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Administración <small>Materias - UACJ</small></h1>
	</div>
	<p class="lead"></p>
</div>

<?php 
	require_once "./controladores/carrerauacjControlador.php";
	$insCarrera= new carreraUacjControlador();

	$url=explode("/", $_GET['views']);
	
	if(isset($_SESSION['carreraUacjSelect']))	{
		$codigoCarrera=$_SESSION['carreraUacjSelect'];
	}else{
		$codigoCarrera="";
	}

	$tipoConsulta="Unico";
	//Se obtiene un array con los datos de la carrera seleccionada
	if(isset($codigoCarrera)){
		$datosCarrera=$insCarrera->datos_carrera_uacj_controlador($tipoConsulta,$codigoCarrera);
		if($datosCarrera->rowCount()==1){
			$camposCarrera=$datosCarrera->fetch();
		}
	}

	$tipoConsulta="Lista";
	//Se obtiene un array con los nombres de todas las carreras (para la lista desplegable)
	$listaC=$insCarrera->datos_carrera_uacj_controlador($tipoConsulta,"");
	if($listaC->rowCount()>=1){
		$listaCarrera=$listaC->fetchAll();
	}
?>

<div class="container-fluid">
	<div class="panel-body">
		<div class="pull-right">
			<?php echo $codigoCarrera;?>
			<!--listado de carreras ---------------------------------------------------------->
			<select class="selectpicker" id="carreraUacjSelect" name="carreraUacjSelect" data-live-search="true">
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
			<ul class="breadcrumb breadcrumb-tabs">
				<li>
					<a href="<?php echo SERVERURL; ?>materiasuacj/" class="btn btn-info">
						<i class="zmdi zmdi-plus"></i> &nbsp; AGREGAR MATERIA
					</a>
				</li>
				<li>
					<a href="<?php echo SERVERURL; ?>materiasuacjlist/" class="btn btn-success">
						<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MATERIAS
					</a>
				</li>
		</ul>
	</div>
</div>

<div id="tabla">         
  <?php 
    require_once "./controladores/materiauacjControlador.php";
    $insMateria= new materiaUacjControlador();
  ?>

<div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DE LA MATERIA</h3>
		</div>
		<div class="panel-body">
			<form action="<?php echo SERVERURL;?>ajax/materiauacjAjax.php" method="POST" data-form="Save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
					<legend><i class="zmdi zmdi-assignment"></i> &nbsp;</legend>
					<div class="container-fluid">
							<div class="col-xs-12">
								<div class="form-group label-floating">
									<label class="control-label">Nombre de la materia *</label>
									<input class="form-control" type="text" name="nombreMateriaAgregar" required="" maxlength="170">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Clave *</label>
									<input class="form-control" type="text" name="claveMateriaAgregar" required="" maxlength="15">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Créditos *</label>
									<input class="form-control" type="text" name="creditosMateriaAgregar" required="" maxlength="15">
								</div>
							</div>
							<div class="col-xs-6 col-sm-6">
								<div class="label-floating">
									<select class="form-control" name="semestreMateriaAgregar" required="">
										<option class="gris" value=0>Selecciona un semestre *</option>
										<option value=1>1er Semestre</option>
										<option value=2>2do Semestre</option>
										<option value=3>3er Semestre</option>
										<option value=4>4to Semestre</option>
										<option value=5>5to Semestre</option>
										<option value=6>6to Semestre</option>
										<option value=7>7mo Semestre</option>
										<option value=8>8vo Semestre</option>
										<option value=9>9no Semestre</option>
									</select>
								</div>
							</div>
							
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsObl" id="optionsRadios1" value="obl">
												Obligatoria
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsObl" id="optionsRadios2" value="opt">
												Optativa
										</label>
									</div>
								</div>
							</div>
					</div>
				</fieldset>
				<br>
				<p class="text-center" style="margin-top: 20px;">
					<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
				</p>
				<div class="RespuestaAjax"></div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#carreraUacjSelect').select2();
  });

	$('#carreraUacjSelect').change(function(){
      $.ajax({
        type:"post",
        data:"carreraUacjSelect=" + $('#carreraUacjSelect').val(),
        url:"<?php echo SERVERURL; ?>ajax/materiauacjAjax.php",
        success:function(r){
          location.reload();
        }
      });
    });  
</script>
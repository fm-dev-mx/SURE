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
        
        echo $insMateria->paginador_materia_uacj_controlador($pagina,3,1,$codigoCarrera);
        ?>	
      </div>
    </div>
  </div>
</div>
	

<!--Ventana emergente para renombrar carrera-->

<!--
		    		
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-xs-12">
						    	<div class="form-group label-floating">
								  	<label class="control-label">DNI/CEDULA *</label>
								  	<input pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-reg" required="" maxlength="30">
								</div>
		    				</div>
		    	
			-->
<form action="<?php echo SERVERURL; ?>ajax/materiauacjAjax.php" method="POST" data-form='update' class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
	
		<div class="modal fade" id="editar-materia-uacj-pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content form-group">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<legend><i class="zmdi zmdi-book"></i> &nbsp; Editar materia</legend>
					</div>
					<div class="modal-body">
						<div class="row">
							<input type="text" id="MateriaPrivilegioUpdate" name="MateriaPrivilegioUpdate" hidden="">
							<div class="col-xs-12">
								<label class="control-label">NOMBRE *</label>
								<input type="text" id="MateriaUacjNombre" name="MateriaUacjNombre" class="form-control input">
							</div>						
							<div class="col-xs-4">
								<label class="control-label">CLAVE *</label>
								<input type="text" id="MateriaUacjClave" name="MateriaUacjClave" class="form-control input" maxlength="10">
							</div>	
							<div class="col-xs-4">
								<label class="control-label">CREDITOS *</label>
								<input type="text" id="MateriaUacjCreditos" name="MateriaUacjCreditos" class="form-control input" maxlength="2">
							</div>	
							<div class="col-xs-4">								
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
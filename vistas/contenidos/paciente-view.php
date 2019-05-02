<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-accounts-alt zmdi-hc-fw"></i> Consultas <small>Primer contacto</small></h1>
	</div>
	<p class="lead"></p>
</div>

<?php 
	require_once "./controladores/pacienteControlador.php";
	$insPaciente= new pacienteControlador();
	$datos=explode("/", $_GET['views']);
	
	if(isset($datos[1])){
		$tipo="Unico";
		$filesPaciente=$insPaciente->datos_paciente_controlador($tipo,$datos[1]);
		if($filesPaciente->rowCount()==1){
			$campos=$filesPaciente->fetch();
		}
	}
?>

<!-- panel datos de la empresa -->
<div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DEL PACIENTE</h3>
		</div>
		<div class="panel-body">
		<form action="<?php echo SERVERURL; ?>ajax/universidadAjax.php" method="POST" data-form=<?php if(isset($campos['UniversidadNombre'])){echo 'Update';}else{echo 'Save';} ?> class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		    	<fieldset>
						<input class="form-control" type="hidden" name="agregarActualizar-reg" maxlength="170" value="<?php if(isset($campos['UniversidadNombre'])){echo "Actualizar";}else{echo "Agregar";} ?>">
						<input class="form-control" type="hidden" name="codigoUniversidad-up" value="<?php echo $datos[1]; ?>">
		    		<legend><i class="zmdi zmdi-assignment"></i> &nbsp;</legend>
		    		<div class="container-fluid">
		    			<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Nombre del instituto *</label>
								  	<input class="form-control" type="text" name="nombreUniversidad-reg" required="" maxlength="170" value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadNombre'];} ?>">
								</div>
		    				</div>
		    				<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Iniciales *</label>
								  	<input class="form-control" type="text" name="iniciales-reg" required="" maxlength="15"  value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadIniciales'];} ?>">
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Pais *</label>
								  	<input class="form-control" type="text" name="pais-reg" required="" maxlength="15"  value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadPais'];} ?>">
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Estado *</label>
								  	<input class="form-control" type="text" name="estado-reg" required="" maxlength="15"  value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadEstado'];} ?>">
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Ciudad *</label>
								  	<input class="form-control" type="text" name="ciudad-reg" required="" maxlength="15"  value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadCiudad'];} ?>">
								</div>
		    				</div>
		    				<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Dirección</label>
								  	<input class="form-control" type="text" name="direccion-reg" maxlength="170" value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadDireccion'];} ?>">
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<label class="control-label">Tipo de universidad</label>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsPublica" id="optionsRadios1" value="Publica" checked="" <?php if(isset($campos['UniversidadTipo'])){if($campos['UniversidadTipo']=="Publica"){ echo 'checked=""'; }} ?>>
											<i class="zmdi zmdi-male-alt"></i> &nbsp; Pública
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsPublica" id="optionsRadios2" value="Privada" <?php if(isset($campos['UniversidadTipo'])){if($campos['UniversidadTipo']=="Privada"){ echo 'checked=""'; }} ?>>
											<i class="zmdi zmdi-female"></i> &nbsp; Privada
										</label>
									</div>
								</div>
		    				</div>
								<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
								  	<label class="control-label">Teléfono</label>
								  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="50" value="<?php if(isset($campos['UniversidadNombre'])){ echo $campos['UniversidadTelefono'];} ?>">
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
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

<!--Se obtienen los datos del paciente enviado por URL	----------------->
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

		$tipo="Unico";
		$filesAlumno=$insPaciente->datos_alumno_controlador($tipo,$datos[1]);
		if($filesPaciente->rowCount()==1){
			$camposAlumno=$filesAlumno->fetch();
		}

		$tipo="Unico";
		$filesEmpleado=$insPaciente->datos_empleado_controlador($tipo,$datos[1]);
		if($filesPaciente->rowCount()==1){
			$camposEmpleado=$filesEmpleado->fetch();
		}

	}
?>

<!---- MENU     REGISTRAR CONSULTA / LISTA DE PACIENTES / BUSCAR PACIENTE --->
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
			<div class="container-fluid">	
				<div class="btn-group">
					<button class="btn btn-default btn-lg dropdown-toggle btn btn-info" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="zmdi zmdi-plus"></i> &nbsp; REGISTRAR CONSULTA <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="<?php echo SERVERURL; ?>paciente/">Primer contacto</a></li>
						<li><a href="<?php echo SERVERURL; ?>consulta/">Seguimiento</a></li>
					</ul>
				</div>
			</div>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>pacienteList/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PACIENTES
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>paciente/" class="btn btn-primary">
	  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR
	  		</a>
	  	</li>
	</ul>
</div>

<!-- panel datos del paciente -->
<div class="container-fluid">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DEL PACIENTE</h3>
		</div>
		<div class="panel-body">
			<form action="<?php echo SERVERURL; ?>ajax/pacienteAjax.php" method="POST" data-form=<?php if(isset($campos['PacienteNombre'])){echo 'Update';}else{echo 'Save';} ?> class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
					<input class="form-control" type="hidden" name="agregarActualizar" maxlength="12" value="<?php if(isset($campos['PacienteNombre'])){echo "Actualizar";}else{echo "Agregar";} ?>">
					<input class="form-control" type="hidden" name="PacienteCodigo" value="<?php echo $datos[1]; ?>">
					<legend><i class="zmdi zmdi-assignment"></i> &nbsp;</legend>
											
					<div class="container-fluid">
					
						<!--datos personales -->
						<div class="row-fluid">
							<!--datos personales (titulo)-->
							<div class="container-fluid">
								<h2 class="text-titles"><small><i class="zmdi zmdi-account-o"></i> Datos Personales</small></h2>
							</div>
							<!--nombre -->
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
										<label class="control-label">Nombre(s) *</label>
										<input class="form-control" type="text" name="PacienteNombre" required="" maxlength="50" value="<?php if(isset($campos['PacienteNombre'])){ echo $campos['PacienteNombre'];} ?>">
								</div>
							</div>
							
							<!--apellido-->
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Apellido(s) *</label>
									<input class="form-control" type="text" name="PacienteApellido" required="" maxlength="50"  value="<?php if(isset($campos['PacienteApellido'])){ echo $campos['PacienteApellido'];} ?>">
								</div>
							</div>																					
							<!--estado civil-->									
							<div class="col-xs-12 col-sm-2">
								<!--estado civil-->
								<div class="form-group">
									<label class="control-label">Estado civil *</label>
									<div class="radio radio-primary">
										<label>
											<input type="radio" required="" name="PacienteEstadoCivil" id="optionsRadios1" value="Soltero" <?php if(isset($campos['PacienteEstadoCivil'])){if($campos['PacienteEstadoCivil']=="Soltero"){ echo "checked";}} ?>>
												Soltero
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" required="" name="PacienteEstadoCivil" id="optionsRadios2" value="Casado" <?php if(isset($campos['PacienteEstadoCivil'])){if($campos['PacienteEstadoCivil']=="Casado"){ echo "checked";}} ?>>
												Casado
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" required="" name="PacienteEstadoCivil" id="optionsRadios1" value="Union Libre" <?php if(isset($campos['PacienteEstadoCivil'])){if($campos['PacienteEstadoCivil']=="Union Libre"){ echo "checked";}} ?>>
												Union Libre
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" required="" name="PacienteEstadoCivil" id="optionsRadios2" value="Divorciado" <?php if(isset($campos['PacienteEstadoCivil'])){if($campos['PacienteEstadoCivil']=="Divorciado"){ echo "checked";}} ?>>
												Divorciado
										</label>
									</div>									
									<div class="radio radio-primary">
										<label>
											<input type="radio" required="" name="PacienteEstadoCivil" id="optionsRadios2" value="Viudo" <?php if(isset($campos['PacienteEstadoCivil'])){if($campos['PacienteEstadoCivil']=="Viudo"){ echo "checked";}} ?>>
												Viudo
										</label>
									</div>									
								</div>
							</div>						
							<!--fecha de nacimiento-->					
							<div class="col-xs-12 col-sm-3" id="datecontainer">
								<div class="form-group label-floating">										
									<div class="input-group date">											
										<label class="control-label">Fecha de nacimiento *</label>
										<input class="form-control" name="PacienteFechaNac" value="<?php if(isset($campos['PacienteFechaNac'])){ echo $campos['PacienteFechaNac'];} ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
								</div>
							</div>									
							<!--lugar de nacimiento-->
							<div class="col-xs-12 col-sm-4">
								<div class="form-group label-floating">
									<label class="control-label">Lugar de nacimiento *</label>
									<input class="form-control" type="text" name="PacienteLugarNac" required="" maxlength="50" value="<?php if(isset($campos['PacienteLugarNac'])){ echo $campos['PacienteLugarNac'];} ?>">
								</div>
							</div>									
							<!--telefono-->			
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
									<label class="control-label">Teléfono *</label>
									<input class="form-control" type="tel" name="PacienteTelefono" required="" maxlength="10" value="<?php if(isset($campos['PacienteTelefono'])){ echo $campos['PacienteTelefono'];} ?>">
								</div>
							</div>									
							<!--correo electronico-->								
							<div class="col-xs-12 col-sm-5">
								<div class="form-group label-floating">
									<label class="control-label">Correo electrónico</label>
									<input class="form-control" type="email" name="PacienteEmail" maxlength="80" value="<?php if(isset($campos['PacienteEmail'])){ echo $campos['PacienteEmail'];} ?>">
								</div>
							</div>										
							<!--ocupacion-->				
							<div class="col-xs-12 col-sm-5">
								<div class="form-group label-floating">
									<label class="control-label">Ocupación *</label>
									<input class="form-control" type="text" name="PacienteOcupacion" required="" maxlength="30" value="<?php if(isset($campos['PacienteOcupacion'])){ echo $campos['PacienteOcupacion'];} ?>">
								</div>
							</div>																										
							<!--religion-->
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
									<label class="control-label">Religión *</label>
									<input class="form-control" type="text" name="PacienteReligion" required="" maxlength="30" value="<?php if(isset($campos['PacienteReligion'])){ echo $campos['PacienteReligion'];} ?>">
								</div>
							</div>									
							<!--servicio medico-->
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
									<label class="control-label">Servicio médico *</label>
									<input class="form-control" type="text" name="PacienteServicioMedico" required="" maxlength="40" value="<?php if(isset($campos['PacienteServicioMedico'])){ echo $campos['PacienteServicioMedico'];} ?>">
								</div>
							</div>
							<!--grado de estudios-->
							<div class="col-xs-12 col-sm-4">
								<div class="form-group label-floating">
									<label class="control-label">Grado de estudios *</label>
									<input class="form-control" type="text" name="PacienteGradoEstudios" required="" maxlength="40" value="<?php if(isset($campos['PacienteGradoEstudios'])){ echo $campos['PacienteGradoEstudios'];} ?>">
								</div>
							</div>
						</div>
						<!--domicilio -->
						<div class="row">
							<!--domicilio (titulo)-->
							<div class="container-fluid">
								<h2 class="text-titles"><small><i class="zmdi zmdi-home"></i> Domicilio</small></h2>
							</div>
							<!--ciudad-->
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
									<label class="control-label">Ciudad *</label>
									<input class="form-control" type="text" name="PacienteCiudad" required="" maxlength="30" value="<?php if(isset($campos['PacienteCiudad'])){ echo $campos['PacienteCiudad'];} ?>">
								</div>
							</div>
							<!--colonia-->								
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
									<label class="control-label">Colonia / Fraccionamiento *</label>
									<input class="form-control" type="text" name="PacienteColonia" required="" maxlength="40" value="<?php if(isset($campos['PacienteColonia'])){ echo $campos['PacienteColonia'];} ?>">
								</div>
							</div>
							<!--calle-->								
							<div class="col-xs-12 col-sm-2">
								<div class="form-group label-floating">
									<label class="control-label">Calle *</label>
									<input class="form-control" type="text" name="PacienteCalle" required="" maxlength="40" value="<?php if(isset($campos['PacienteCalle'])){ echo $campos['PacienteCalle'];} ?>">
								</div>
							</div>
							<!--numero-->								
							<div class="col-xs-12 col-sm-1">
								<div class="form-group label-floating">
									<label class="control-label">Numero *</label>
									<input class="form-control" type="text" name="PacienteNumero" required="" maxlength="20" value="<?php if(isset($campos['PacienteNumero'])){ echo $campos['PacienteNumero'];} ?>">
								</div>
							</div>
							<!--fecha de radicar en el domicilio-->
							<div class="form-group label-floating">
								<div class="col-xs-12 col-sm-3" id="datecontainer">
									<div class="input-group date">											
										<label class="control-label">Fecha en domicilio *</label>
										<input class="form-control" name="PacienteFechaRadica" required="" value="<?php if(isset($campos['PacienteFechaRadica'])){ echo $campos['PacienteFechaRadica'];} ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
									</div>
								</div>
							</div>																						
						</div>
						<!--contacto -->
						<div class="row">
							<!--contacto (titulo)-->
							<div class="container-fluid">
								<h2 class="text-titles"><small><i class="zmdi zmdi-account-box-phone"></i> Contacto</small></h2>
							</div>
							<!--nombre-->
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Nombre *</label>
									<input class="form-control" type="text" name="PacienteContacto" required="" maxlength="100" value="<?php if(isset($campos['PacienteContacto'])){ echo $campos['PacienteContacto'];} ?>">
								</div>
							</div>
							<!--parentesco-->								
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
									<label class="control-label">Parentesco *</label>
									<input class="form-control" type="text" name="PacienteContactoParentesco" maxlength="20" value="<?php if(isset($campos['PacienteContactoParentesco'])){ echo $campos['PacienteContactoParentesco'];} ?>">
								</div>
							</div>
							<!--telefono-->								
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
									<label class="control-label">Teléfono *</label>
									<input class="form-control" type="tel" name="PacienteContactoTelefono" maxlength="10" value="<?php if(isset($campos['PacienteContactoTelefono'])){ echo $campos['PacienteContactoTelefono'];} ?>">
								</div>
							</div>	
						</div>
						<!-- alumno / Empleado / externo-->
						<div class="panel panel-info">
							<div class="container-fluid">									
								<div class="row">											
									<!--seleccion-->
									<div class="container">
										<div class="form-group">
											<div class="col-sm-6" id="selectorAlumno">
												<label class="radio-inline"> 
													<input type="radio" name="alumno" id="alumno" value="alumno" required="" <?php if(isset($campos['PacienteAlumEmpl'])){if($campos['PacienteAlumEmpl']=="alumno"){ echo "checked";}} ?>> Alumno 
												</label>
												<label class="radio-inline"> 
													<input type="radio" name="alumno" id="empleado" value="empleado" required="" <?php if(isset($campos['PacienteAlumEmpl'])){if($campos['PacienteAlumEmpl']=="empleado"){ echo "checked";}} ?>> Empleado 
												</label>
												<label class="radio-inline"> 
													<input type="radio" name="alumno" id="externo" value="externo" required="" <?php if(isset($campos['PacienteAlumEmpl'])){if($campos['PacienteAlumEmpl']=="externo"){ echo "checked";}} ?>> Externo 
												</label>
												<br><br>
											</div>
										</div>
									</div>
									<!--alumno-->
									<div id="div-alumno" hidden>
										<!--matricula-->
										<div class="col-xs-12 col-sm-3">
											<div class="form-group label-floating">
												<label class="control-label">Matrícula *</label>
												<input class="form-control" type="text" id="AlumnoMatricula" name="AlumnoMatricula" maxlength="6" value="<?php if(isset($camposAlumno['AlumnoMatricula'])){ echo $camposAlumno['AlumnoMatricula'];} ?>">
											</div>
										</div>
										<!--carrera-->
										<div class="col-xs-12 col-sm-6">
											<div class="form-group label-floating">
												<label class="control-label">Carrera *</label>
												<input class="form-control" type="text" id="AlumnoCarrera" name="AlumnoCarrera" maxlength="50" value="<?php if(isset($camposAlumno['AlumnoCarrera'])){ echo $camposAlumno['AlumnoCarrera'];} ?>">
											</div>
										</div>
										<!--semestre-->
										<div class="col-xs-12 col-sm-3">
											<div class="form-group label-floating">
												<label class="control-label">Semestre *</label>
												<input class="form-control" type="text" id="AlumnoSemestre" name="AlumnoSemestre" maxlength="2" value="<?php if(isset($camposAlumno['AlumnoSemestre'])){ echo $camposAlumno['AlumnoSemestre'];} ?>">
											</div>
										</div>
									</div>
									<!--empleado-->
									<div id="div-empleado" hidden>
										<!--numero de empleado-->
										<div class="col-xs-12 col-sm-3">
											<div class="form-group label-floating">
												<label class="control-label">Número de empleado *</label>
												<input class="form-control" type="text" id="EmpleadoNumEmpl" name="EmpleadoNumEmpl" maxlength="8" value="<?php if(isset($camposEmpleado['EmpleadoNumero'])){ echo $camposEmpleado['EmpleadoNumero'];} ?>">
											</div>
										</div>
										<!--semestre-->
										<div class="col-xs-12 col-sm-3">
											<div class="form-group label-floating">
												<label class="control-label">Puesto *</label>
												<input class="form-control" type="text" id="EmpleadoPuesto" name="EmpleadoPuesto" maxlength="40" value="<?php if(isset($camposEmpleado['EmpleadoPuesto'])){ echo $camposEmpleado['EmpleadoPuesto'];} ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--atendido por: se muestra el ultimo terapeuta que modifico los datos del paciente -->
						<div class="row-fluid">
							<!--atendido por (titulo)-->
							<div class="container-fluid">
								<h2 class="text-titles"><small><i class="zmdi zmdi-seat"></i> Terapueta a cargo</small></h2>
							</div>
							<!--nombre -->
							<div class="col-xs-12 col-sm-10">
								<div class="form-group label-floating">
									<input class="form-control" type="text" id="PacienteTerapeuta" name="PacienteTerapeuta" value="<?php if(isset($campos['PacienteTerapeuta'])){ echo $campos['PacienteTerapeuta'];}else{echo $_SESSION['nombre_sbp'].' '.$_SESSION['apellido_sbp'];} ?>">
								</div>
							</div>
						</div>
						<br>
						<p class="text-center" style="margin-top: 5px;">
							<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
						</p>
						
					</div>						
				</fieldset>
				<div class="RespuestaAjax"></div>
			</form>
		</div>
	</div>
</div>
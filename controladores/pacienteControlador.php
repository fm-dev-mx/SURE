<?php
	
	if($peticionAjax){
		require_once "../modelos/pacienteModelo.php";
	}else{
		require_once "./modelos/pacienteModelo.php";
	}

    class pacienteControlador extends pacienteModelo{
		public function agregar_paciente_controlador(){
			$nombre=mainModel::limpiar_cadena($_POST['PacienteNombre']);
			$apellido=mainModel::limpiar_cadena($_POST['PacienteApellido']);
			$fechaNac=mainModel::limpiar_cadena($_POST['PacienteFechaNac']);
			$lugarNac=mainModel::limpiar_cadena($_POST['PacienteLugarNac']);
			$fechaNac=mainModel::limpiar_cadena($_POST['PacienteCiudad']);
			$colonia=mainModel::limpiar_cadena($_POST['PacienteColonia']);
			$calle=mainModel::limpiar_cadena($_POST['PacienteCalle']);
			$numero=mainModel::limpiar_cadena($_POST['PacienteNumero']);
			$fechaRadica=mainModel::limpiar_cadena($_POST['PacienteFechaRadica']);
			$telefono=mainModel::limpiar_cadena($_POST['PacienteTelefono']);
			$contacto=mainModel::limpiar_cadena($_POST['PacienteContacto']);
			$contactoParentesco=mainModel::limpiar_cadena($_POST['PacienteContactoParentesco']);
			$contactoTelefono=mainModel::limpiar_cadena($_POST['PacienteContactoTelefono']);
			$email=mainModel::limpiar_cadena($_POST['PacienteEmail']);
			$estadoCivil=mainModel::limpiar_cadena($_POST['PacienteEstadoCivil']);
			$gradoEstudios=mainModel::limpiar_cadena($_POST['PacienteGradoEstudios']);
			$ocupacion=mainModel::limpiar_cadena($_POST['PacienteOcupacion']);
			$religion=mainModel::limpiar_cadena($_POST['PacienteReligion']);
			$servicioMedico=mainModel::limpiar_cadena($_POST['PacienteServicioMedico']);
			$alumEmpl=mainModel::limpiar_cadena($_POST['alumno']);
			$terapeuta=mainModel::limpiar_cadena($_POST['PacienteTerapeuta']);

            $consulta1=mainModel::ejecutar_consulta_simple("SELECT PacienteCodigo FROM paciente WHERE (PacienteNombre='$nombre' AND PacienteApellido='$apellido' AND PacienteFechaNac='$fechaNac')");
				
			if($consulta1->rowCount()>=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El paciente ya existe en el sistema, favor de verificar los datos!",
                    "Tipo"=>"error"
                ];
			}else{				
				$consulta=mainModel::ejecutar_consulta_simple("SELECT PacienteCodigo FROM paciente");
				$numeroRegistro=($consulta->rowCount())+1;
				$codigo=mainModel::generar_codigo_aleatorio("PC",7,$numeroRegistro);
				$dataPaciente=[
					"Codigo"=>$codigo,
					"Nombre"=>$nombre,
					"Apellido"=>$apellido,
					"FechaNac"=>$fechaNac,		
					"LugarNac"=>$lugarNac,			
					"Ciudad"=>$fechaNac,
					"Colonia"=>$colonia,		
					"Calle"=>$calle,
					"Numero"=>$numero,	
					"FechaRadica"=>$fechaRadica,
					"Telefono"=>$telefono,			
					"Contacto"=>$contacto,			
					"ContactoParentesco"=>$contactoParentesco,
					"ContactoTelefono"=>$contactoTelefono,
					"Email"=>$email,
					"EstadoCivil"=>$estadoCivil,
					"GradoEstudios"=>$gradoEstudios,
					"Ocupacion"=>$ocupacion,				
					"Religion"=>$religion,			
					"ServicioMedico"=>$servicioMedico,
					"AlumEmpl"=>$alumEmpl,
					"Terapeuta"=>$terapeuta
				];

				//alumno
				if($_POST['AlumnoMatricula']!="" && $_POST['AlumnoCarrera']!=""){
					$matricula=mainModel::limpiar_cadena($_POST['AlumnoMatricula']);
					$carrera=mainModel::limpiar_cadena($_POST['AlumnoCarrera']);
					$semestre=mainModel::limpiar_cadena($_POST['AlumnoSemestre']);

					$dataAlumno=[
						"Codigo"=>$codigo,
						"Matricula"=>$matricula,
						"Carrera"=>$carrera,
						"Semestre"=>$semestre
					];

					$guardarAlumno=pacienteModelo::agregar_alumno_modelo($dataAlumno);
					if($guardarAlumno->rowCount()>=1){						
						$guardarPaciente=pacienteModelo::agregar_paciente_modelo($dataPaciente);
						if($guardarPaciente->rowCount()>=1){
							$alerta=[
								"Alerta"=>"recargar",
								"Titulo"=>"Paciente registrado!",
								"Texto"=>"Los datos del paciente han sido registrados con exito",
								"Tipo"=>"success"
							];
						}else{
							//borrar alumno (falta)
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"No hemos podido registrar el paciente, por favor intente nuevamente3333",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos podido registrar el alumno, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}					
				//Empleado	
				}elseif($_POST['EmpleadoNumEmpl']!="" && $_POST['EmpleadoPuesto']!=""){
					$numEmpl=mainModel::limpiar_cadena($_POST['EmpleadoNumEmpl']);
					$puesto=mainModel::limpiar_cadena($_POST['EmpleadoPuesto']);
					$dataEmpleado=[
						"Codigo"=>$codigo,
						"NumEmpl"=>$numEmpl,
						"Puesto"=>$puesto
					];
					$guardarEmpleado=pacienteModelo::agregar_empleado_modelo($dataEmpleado);
					if($guardarEmpleado->rowCount()>=1){
						$guardarPaciente=pacienteModelo::agregar_paciente_modelo($dataPaciente);
						if($guardarPaciente->rowCount()>=1){
							$alerta=[
								"Alerta"=>"recargar",
								"Titulo"=>"Paciente registrado!",
								"Texto"=>"Los datos del paciente han sido registrados con exito",
								"Tipo"=>"success"
							];
						}else{
							//borrar empleado (falta)
							$alerta=[
								"Alerta"=>"simple",
								"Titulo"=>"Ocurrió un error inesperado",
								"Texto"=>"No hemos podido registrar el empleado, por favor intente nuevamente",
								"Tipo"=>"error"
							];	
						}
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos podido registrar el empleado, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}					
				//externo
				}else{
					$guardarPaciente=pacienteModelo::agregar_paciente_modelo($dataPaciente);
					if($guardarPaciente->rowCount()>=1){
						$alerta=[
							"Alerta"=>"limpiar",
							"Titulo"=>"Paciente registrado",
							"Texto"=>"El paciente se registro con exito en el sistema",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos podido registrar el paciente, por favor intente nuevamente5555",
							"Tipo"=>"error"
						];
					}
				}								
			}
            return mainModel::sweet_alert($alerta);
        }

		// Controlador para paginar pacientes
		public function paginador_paciente_controlador($pagina,$registros,$privilegio,$busqueda){
			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$busqueda=mainModel::limpiar_cadena($busqueda);
			$tabla="";
			
			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM paciente WHERE (PacienteNombre LIKE '%$busqueda%' OR PacienteApellido LIKE '%$busqueda%' OR PacienteTelefono LIKE '%$busqueda%' OR PacienteEmail LIKE '%$busqueda%') ORDER BY PacienteApellido ASC LIMIT $inicio,$registros";
				$paginaurl="univSearch";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM paciente ORDER BY PacienteApellido ASC LIMIT $inicio,$registros";
				$paginaurl="univList";
			}

			$conexion = mainModel::conectar();

			$datos = $conexion->query($consulta);
			$datos= $datos->fetchAll();

			$total= $conexion->query("SELECT FOUND_ROWS()");
			$total= (int) $total->fetchColumn();

			$Npaginas= ceil($total/$registros);

			$tabla.='
			<div class="table-responsive">
				<table class="table table-hover text-center">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">NOMBRE</th>
							<th class="text-center">APELLIDO</th>
							<th class="text-center">FECHA DE NAC</th>
							<th class="text-center">TELEFONO</th>
							<th class="text-center">TERAPEUTA</th>';
						if($privilegio<=2){
							$tabla.='
								<th class="text-center">SELECCIONAR</th>
							';
						}
						if($privilegio==1){
							$tabla.='
								<th class="text-center">ELIMINAR</th>
							';
						}
							
			$tabla.='</tr>
					</thead>
					<tbody>
			';
			if($total>=1 && $pagina<=$Npaginas){
				$contador=$inicio+1;
				foreach($datos as $rows){
					$tabla.='
						<tr>
							<td>'.$contador.'</td>
							<td>'.$rows['PacienteNombre'].'</td>
							<td>'.$rows['PacienteApellido'].'</td>
							<td>'.$rows['PacienteFechaNac'].'</td>
							<td>'.$rows['PacienteTelefono'].'</td>
							<td>'.$rows['PacienteTerapeuta'].'</td>';
							if($privilegio<=2){
								$tabla.='
									<td>
										<a href="'.SERVERURL.'paciente/'.mainModel::encryption($rows['PacienteCodigo']).'/" class="btn btn-success btn-raised btn-xs">
											<i class="zmdi zmdi-refresh"></i>
										</a>
									</td>
									';
							}
							if($privilegio==1){
								$tabla.='
									<td>
										<form action="'.SERVERURL.'ajax/pacienteAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
											<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['PacienteCodigo']).'">
											<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
											<button type="submit" class="btn btn-danger btn-raised btn-xs">
												<i class="zmdi zmdi-delete"></i>
											</button>
											<div class="RespuestaAjax"></div>
										</form>
									</td>
								';	
							}
					$tabla.='</tr>';
					$contador++;
				}
			}else{
				if($total>=1){
					$tabla.='
						<tr>
							<td colspan="5">
								<a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
									Haga clic aca para recargar el listado
								</a>
							</td>
						</tr>
					';
				}else{
					$tabla.='
						<tr>
							<td colspan="5">No hay registros en el sistema</td>
						</tr>
					';	
				}
			}

			$tabla.='</tbody></table></div>';

			if($total>=1 && $pagina<=$Npaginas){
				$tabla.='<nav class="text-center"><ul class="pagination pagination-sm">';

				if($pagina==1){
					$tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>';
				}else{
					$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
				}

				for($i=1; $i<=$Npaginas; $i++){
					if($pagina==$i){
						$tabla.='<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
					}else{
						$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($pagina==$Npaginas){
					$tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
				}else{
					$tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i></a></li>';
				}
				$tabla.='</ul></nav>';
			}

			return $tabla;
		}

		public function eliminar_paciente_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if($adminPrivilegio==1){
				
				$DelPaciente=pacienteModelo::eliminar_paciente_modelo($codigo);
				
				if($DelPaciente->rowCount()>=1){
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Paciente eliminado",
						"Texto"=>"El paciente fue eliminado del sistema con éxito",
						"Tipo"=>"success"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No podemos eliminar este paciente en este momento, favor de intentar nuevamente!!",
						"Tipo"=>"error"
					];
				}
				return mainModel::sweet_alert($alerta);
			}
		}

		public function datos_paciente_controlador($tipo,$codigo){
			$tipo=mainModel::limpiar_cadena($tipo);
			$codigo=mainModel::decryption($codigo);

			return pacienteModelo::datos_paciente_modelo($tipo,$codigo);
		}

		public function datos_alumno_controlador($tipo,$codigo){
			$tipo=mainModel::limpiar_cadena($tipo);
			$codigo=mainModel::decryption($codigo);

			return pacienteModelo::datos_alumno_modelo($tipo,$codigo);
		}

		public function datos_empleado_controlador($tipo,$codigo){
			$tipo=mainModel::limpiar_cadena($tipo);
			$codigo=mainModel::decryption($codigo);

			return pacienteModelo::datos_empleado_modelo($tipo,$codigo);
		}

		public function actualizar_paciente_controlador(){
			$codigo=mainModel::limpiar_cadena($_POST['PacienteCodigo']);
			$nombre=mainModel::limpiar_cadena($_POST['PacienteNombre']);
			$apellido=mainModel::limpiar_cadena($_POST['PacienteApellido']);
			$fechaNac=mainModel::limpiar_cadena($_POST['PacienteFechaNac']);
			$lugarNac=mainModel::limpiar_cadena($_POST['PacienteLugarNac']);
			$fechaNac=mainModel::limpiar_cadena($_POST['PacienteCiudad']);
			$colonia=mainModel::limpiar_cadena($_POST['PacienteColonia']);
			$calle=mainModel::limpiar_cadena($_POST['PacienteCalle']);
			$numero=mainModel::limpiar_cadena($_POST['PacienteNumero']);
			$fechaRadica=mainModel::limpiar_cadena($_POST['PacienteFechaRadica']);
			$telefono=mainModel::limpiar_cadena($_POST['PacienteTelefono']);
			$contacto=mainModel::limpiar_cadena($_POST['PacienteContacto']);
			$contactoParentesco=mainModel::limpiar_cadena($_POST['PacienteContactoParentesco']);
			$contactoTelefono=mainModel::limpiar_cadena($_POST['PacienteContactoTelefono']);
			$email=mainModel::limpiar_cadena($_POST['PacienteEmail']);
			$estadoCivil=mainModel::limpiar_cadena($_POST['PacienteEstadoCivil']);
			$gradoEstudios=mainModel::limpiar_cadena($_POST['PacienteGradoEstudios']);
			$ocupacion=mainModel::limpiar_cadena($_POST['PacienteOcupacion']);
			$religion=mainModel::limpiar_cadena($_POST['PacienteReligion']);
			$servicioMedico=mainModel::limpiar_cadena($_POST['PacienteServicioMedico']);
			$alumEmpl=mainModel::limpiar_cadena($_POST['alumno']);
			$terapeuta=mainModel::limpiar_cadena($_POST['PacienteTerapeuta']);
			
			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM paciente WHERE PacienteCodigo='$codigo'");
			$DatosPaciente=$query1->fetch();

			if($nombre!=$DatosPaciente['PacienteNombre'] || $apellido!=$DatosPaciente['PacienteApellido'] || $fechaNac!=$DatosPaciente['PacienteFechaNac']){
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT PacienteNombre FROM paciente WHERE PacienteNombre='$nombre'");
				$consulta2=mainModel::ejecutar_consulta_simple("SELECT PacienteApellido FROM paciente WHERE PacienteApellido='$apellido'");
				$consulta3=mainModel::ejecutar_consulta_simple("SELECT PacienteFechaNac FROM paciente WHERE PacienteFechaNac='$fechaNac'");
		
				if(($consulta1->rowCount()>=1) && ($consulta2->rowCount()>=1) && ($consulta3->rowCount()>=1)){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"Los datos del paciente que acaba de ingresar ya se encuentran registrados en el sistema",
						"Tipo"=>"error"
					];
					return mainModel::sweet_alert($alerta);
					exit();
				}
			}

			$dataPaciente=[
				"Codigo"=>$codigo,
				"Nombre"=>$nombre,
				"Apellido"=>$apellido,
				"FechaNac"=>$fechaNac,		
				"LugarNac"=>$lugarNac,			
				"Ciudad"=>$fechaNac,
				"Colonia"=>$colonia,		
				"Calle"=>$calle,
				"Numero"=>$numero,	
				"FechaRadica"=>$fechaRadica,
				"Telefono"=>$telefono,			
				"Contacto"=>$contacto,			
				"ContactoParentesco"=>$contactoParentesco,
				"ContactoTelefono"=>$contactoTelefono,
				"Email"=>$email,
				"EstadoCivil"=>$estadoCivil,
				"GradoEstudios"=>$gradoEstudios,
				"Ocupacion"=>$ocupacion,				
				"Religion"=>$religion,			
				"ServicioMedico"=>$servicioMedico,
				"AlumEmpl"=>$alumEmpl,
				"Terapeuta"=>$terapeuta
			];

			if(pacienteModelo::actualizar_paciente_modelo($dataPaciente)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos actualizados!",
					"Texto"=>"Los datos del paciente han sido actualizados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido actualizar los datos del paciente, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}
			return mainModel::sweet_alert($alerta);
		}

	}
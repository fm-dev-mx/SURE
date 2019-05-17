<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class pacienteModelo extends mainModel{
		protected function agregar_paciente_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO paciente (PacienteCodigo,PacienteNombre,PacienteApellido,PacienteFechaNac,PacienteLugarNac,PacienteCiudad,PacienteColonia,PacienteCalle,PacienteNumero,PacienteFechaRadica,PacienteTelefono,PacienteContacto,PacienteContactoParentesco,PacienteContactoTelefono,PacienteEmail,PacienteEstadoCivil,PacienteGradoEstudios,PacienteOcupacion,PacienteReligion,PacienteServicioMedico,PacienteAlumEmpl,PacienteTerapeuta) VALUES(:Codigo,:Nombre,:Apellido,:FechaNac,:LugarNac,:Ciudad,:Colonia,:Calle,:Numero,:FechaRadica,:Telefono,:Contacto,:ContactoParentesco,:ContactoTelefono,:Email,:EstadoCivil,:GradoEstudios,:Ocupacion,:Religion,:ServicioMedico,:AlumEmpl,:Terapeuta)");
		
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Apellido",$datos['Apellido']);
			$sql->bindParam(":FechaNac",$datos['FechaNac']);
			$sql->bindParam(":LugarNac",$datos['LugarNac']);
			$sql->bindParam(":Ciudad",$datos['Ciudad']);
			$sql->bindParam(":Colonia",$datos['Colonia']);
			$sql->bindParam(":Calle",$datos['Calle']);
			$sql->bindParam(":Numero",$datos['Numero']);
			$sql->bindParam(":FechaRadica",$datos['FechaRadica']);
			$sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":Contacto",$datos['Contacto']);
			$sql->bindParam(":ContactoParentesco",$datos['ContactoParentesco']);
			$sql->bindParam(":ContactoTelefono",$datos['ContactoTelefono']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":EstadoCivil",$datos['EstadoCivil']);
			$sql->bindParam(":GradoEstudios",$datos['GradoEstudios']);
			$sql->bindParam(":Ocupacion",$datos['Ocupacion']);
			$sql->bindParam(":Religion",$datos['Religion']);
			$sql->bindParam(":ServicioMedico",$datos['ServicioMedico']);
			$sql->bindParam(":AlumEmpl",$datos['AlumEmpl']);
			$sql->bindParam(":Terapeuta",$datos['Terapeuta']);
			$sql->execute();
			return $sql;			
		}

		protected function agregar_alumno_modelo($datos){
			
			$sql=mainModel::conectar()->prepare("INSERT INTO alumno (AlumnoCodigoPaciente,AlumnoMatricula,AlumnoCarrera,AlumnoSemestre) VALUES(:Codigo,:Matricula,:Carrera,:Semestre)");

			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":Matricula",$datos['Matricula']);
			$sql->bindParam(":Carrera",$datos['Carrera']);
			$sql->bindParam(":Semestre",$datos['Semestre']);
			$sql->execute();
			return $sql;			
		}
		
		protected function agregar_empleado_modelo($datos){
			
			$sql=mainModel::conectar()->prepare("INSERT INTO empleado (EmpleadoCodigoPaciente,EmpleadoNumero,EmpleadoPuesto) VALUES(:Codigo,:NumEmpl,:Puesto)");
		
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->bindParam(":NumEmpl",$datos['NumEmpl']);
			$sql->bindParam(":Puesto",$datos['Puesto']);
			$sql->execute();
			return $sql;			
		}

		protected function eliminar_paciente_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM paciente WHERE PacienteCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_paciente_modelo($datos){
			$query=mainModel::conectar()->prepare("UPDATE universidad SET UniversidadNombre=:Nombre,UniversidadTelefono=:Telefono,UniversidadDireccion=:Direccion,UniversidadIniciales=:Iniciales,UniversidadTipo=:Tipo,UniversidadPais=:Pais,UniversidadEstado=:Estado,UniversidadCiudad=:Ciudad WHERE UniversidadCodigo=:Codigo");
			$query->bindParam(":Codigo",$datos['Codigo']);
			$query->bindParam(":Nombre",$datos['Nombre']);
			$query->bindParam(":Telefono",$datos['Telefono']);
			$query->bindParam(":Direccion",$datos['Direccion']);
			$query->bindParam(":Iniciales",$datos['Iniciales']);
			$query->bindParam(":Tipo",$datos['Tipo']);
			$query->bindParam(":Pais",$datos['Pais']);
			$query->bindParam(":Estado",$datos['Estado']);
			$query->bindParam(":Ciudad",$datos['Ciudad']);
			$query->execute();
			return $query;
		}

		protected function datos_paciente_modelo($tipo,$codigo){
			if($tipo=="Unico"){
				$query=mainModel::conectar()->prepare("SELECT * FROM paciente WHERE PacienteCodigo=:Codigo");
				$query->bindParam(":Codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT PacienteCodigo FROM paciente");
			}
			$query->execute();
			return $query;
		}

		protected function datos_alumno_modelo($tipo,$codigo){
			if($tipo=="Unico"){
				$query=mainModel::conectar()->prepare("SELECT * FROM alumno WHERE AlumnoCodigoPaciente=:Codigo");
				$query->bindParam(":Codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT AlumnoCodigoPaciente FROM alumno");
			}
			$query->execute();
			return $query;
		}

		protected function datos_empleado_modelo($tipo,$codigo){
			if($tipo=="Unico"){
				$query=mainModel::conectar()->prepare("SELECT * FROM empleado WHERE EmpleadoCodigoPaciente=:Codigo");
				$query->bindParam(":Codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT EmpleadoCodigoPaciente FROM empleado");
			}
			$query->execute();
			return $query;
		}
	}
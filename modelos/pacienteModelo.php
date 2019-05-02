<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class pacienteModelo extends mainModel{
		protected function agregar_universidad_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO universidad (UniversidadNombre,UniversidadTelefono,UniversidadDireccion,UniversidadIniciales,UniversidadTipo,UniversidadPais,UniversidadEstado,UniversidadCiudad,UniversidadCodigo) VALUES(:Nombre,:Telefono,:Direccion,:Iniciales,:Tipo,:Pais,:Estado,:Ciudad,:Codigo)");
			$sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":Direccion",$datos['Direccion']);
			$sql->bindParam(":Iniciales",$datos['Iniciales']);
			$sql->bindParam(":Tipo",$datos['Tipo']);
			$sql->bindParam(":Pais",$datos['Pais']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Ciudad",$datos['Ciudad']);
			$sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->execute();
			return $sql;
		}
		
		protected function eliminar_universidad_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM universidad WHERE UniversidadCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_universidad_modelo($datos){
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

		protected function datos_universidad_modelo($tipo,$codigo){
			if($tipo=="Unico"){
				$query=mainModel::conectar()->prepare("SELECT * FROM universidad WHERE UniversidadCodigo=:Codigo");
				$query->bindParam(":Codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT id FROM universidad");
			}elseif($tipo=="Lista"){
				$query=mainModel::conectar()->prepare("SELECT UniversidadCodigo,UniversidadNombre FROM universidad ORDER BY UniversidadNombre ASC");
			}
			$query->execute();
			return $query;
		}
	}
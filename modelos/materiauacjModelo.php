<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class materiaUacjModelo extends mainModel{
		protected function agregar_materia_uacj_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO materiauacj (MateriaUacjNombre,MateriaUacjClave,MateriaUacjCreditos,MateriaUacjObligatoria,MateriaUacjSemestre,MateriaUacjCarrera) VALUES(:Nombre,:Clave,:Creditos,:Obligatoria,:Semestre,:Carrera)");
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Clave",$datos['Clave']);
			$sql->bindParam(":Creditos",$datos['Creditos']);
			$sql->bindParam(":Obligatoria",$datos['Obligatoria']);
			$sql->bindParam(":Semestre",$datos['Semestre']);
			$sql->bindParam(":Carrera",$datos['CodigoCarrera']);
			$sql->execute();
			return $sql;
		}
		
		protected function eliminar_materia_uacj_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM materiauacj WHERE MateriaUacjClave=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_materia_uacj_modelo($codigo,$nombre){
			$query=mainModel::conectar()->prepare("UPDATE materiauacj SET MateriaNombre=:Nombre WHERE MateriaCodigo=:Codigo");
			$query->bindParam(":Nombre",$nombre);
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

	}
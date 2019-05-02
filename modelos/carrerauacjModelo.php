<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class carreraUacjModelo extends mainModel{
		protected function agregar_carrera_uacj_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO carrerauacj (CarreraNombre,CarreraCodigo) VALUES(:Nombre,:Codigo)");
			$sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Codigo",$datos['Codigo']);
			$sql->execute();
			return $sql;
		}
		
		protected function eliminar_carrera_uacj_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM carrerauacj WHERE CarreraCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function actualizar_carrera_uacj_modelo($codigo,$nombre){
			$query=mainModel::conectar()->prepare("UPDATE carrerauacj SET CarreraNombre=:Nombre WHERE CarreraCodigo=:Codigo");
			$query->bindParam(":Nombre",$nombre);
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}

		protected function datos_carrera_uacj_modelo($tipo,$codigo){
			if($tipo=="Unico"){
				$query=mainModel::conectar()->prepare("SELECT * FROM carrerauacj WHERE CarreraCodigo=:Codigo");
				$query->bindParam(":Codigo",$codigo);
			}elseif($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT id FROM carrerauacj");
			}elseif($tipo=="Lista"){
				$query=mainModel::conectar()->prepare("SELECT CarreraCodigo,CarreraNombre FROM carrerauacj ORDER BY CarreraNombre ASC");
				$query->bindParam(":Codigo",$codigo);
			}
			$query->execute();
			return $query;
		}

	}
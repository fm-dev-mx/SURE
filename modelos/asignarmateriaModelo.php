<?php
	if($peticionAjax){
		require_once "../core/mainModel.php";
	}else{
		require_once "./core/mainModel.php";
	}

	class asignarmateriaModelo extends mainModel{

		protected function buscar_materia_modelo($tipo,$busqueda){
			if($tipo=="Conteo"){
				$query=mainModel::conectar()->prepare("SELECT MateriaUacjNombre FROM materiauacj");
			}elseif($tipo=="Lista"){
				if($busqueda!=""){
					$query=mainModel::conectar()->prepare("SELECT * FROM materiauacj WHERE MateriaUacjNombre like '%$busqueda%' or MateriaUacjClave like '%$busqueda%' ORDER BY MateriaUacjNombre ASC");
				}else{
					$query=mainModel::conectar()->prepare("SELECT * FROM materiauacj ORDER BY MateriaUacjNombre ASC");
				}				
			}
			$query->execute();
			return $query;
		}

		protected function asignar_materia_modelo($materia,$codigo){
			$query=mainModel::conectar()->prepare("UPDATE materia SET MateriaUacj=:Materia WHERE MateriaCodigo=:Codigo");
			
			$query->bindParam(":Materia",$materia);
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}
	}

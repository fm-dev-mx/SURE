<?php
	if($peticionAjax){
		session_start(['name'=>'SBP']);
		require_once "../modelos/materiauacjModelo.php";
	}else{
		require_once './modelos/materiauacjModelo.php';
	}

    class materiaUacjControlador extends materiaUacjModelo{
		public function agregar_materia_uacj_controlador(){
			
			$nombre=mainModel::limpiar_cadena($_POST['nombreMateriaAgregar']);
			$clave=mainModel::limpiar_cadena($_POST['claveMateriaAgregar']);
			$creditos=mainModel::limpiar_cadena($_POST['creditosMateriaAgregar']);
			$semestre=mainModel::limpiar_cadena($_POST['semestreMateriaAgregar']);
			$obl=mainModel::limpiar_cadena($_POST['optionsObl']);            

			if(!isset($_SESSION['carreraUacjSelect'])){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Favor de seleccionar una carrera!!",
					"Tipo"=>"error"
				];
			}else{				
				$codigoCarrera=mainModel::limpiar_cadena($_SESSION['carreraSelect']);
				$consulta1=mainModel::ejecutar_consulta_simple("SELECT MateriaUacjNombre FROM materiauacj WHERE (MateriaUacjNombre='$nombre' OR MateriaUacjClave='$clave') AND MateriaUacjCarrera='$codigoCarrera'");
		
				if($consulta1->rowCount()>=1){
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"La materia ya existe en el sistema, favor de intentar nuevamente!",
						"Tipo"=>"error"
					];
				}else{
					$dataAc=[
						"Nombre"=>$nombre,
						"Clave"=>$clave,
						"Creditos"=>$creditos,
						"Semestre"=>$semestre,
						"Obligatoria"=>$obl,
						"CodigoCarrera"=>$codigoCarrera
					];

					$guardarMateria=MateriaUacjModelo::agregar_materia_uacj_modelo($dataAc);

					if($guardarMateria->rowCount()>=1){
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Materia registrada",
							"Texto"=>"La materia se registro con exito en el sistema",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos podido registrar la materia, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}
				}
			}
            return mainModel::sweet_alert($alerta);
        }

		public function paginador_materia_uacj_controlador($pagina,$registros,$privilegio,$carrera){
			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			$codigoCarrera=mainModel::limpiar_cadena($carrera);			

			$tabla="";

			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

			$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM materiauacj WHERE MateriaUacjCarrera='$codigoCarrera' ORDER BY MateriaUacjNombre ASC LIMIT $inicio,$registros";
			
			$paginaurl="materiasuacjlist";			

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
							<th class="text-center">CLAVE</th>
							<th class="text-center">NOMBRE</th>
							<th class="text-center">CREDITOS</th>
							<th class="text-center">OBL/OPT</th>';
						if($privilegio<=2){
							$tabla.='								
								<th class="text-center">EDITAR</th>
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

					$datosRen=$rows['MateriaUacjClave'].'||'.$rows['MateriaUacjNombre'].'||'.$rows['MateriaUacjCreditos'].'||'.$rows['MateriaUacjObligatoria'].'||'.mainModel::encryption($privilegio);

					$tabla.='	
								<tr>
									<td>'.$contador.'</td>
									<td>'.$rows['MateriaUacjClave'].'</td>
									<td>'.$rows['MateriaUacjNombre'].'</td>
									<td>'.$rows['MateriaUacjCreditos'].'</td>
									<td>'.$rows['MateriaUacjObligatoria'].'</td>
									'
									;
					if($privilegio<=2){
						$tabla.='<td>									
									<button class="btn btn-success btn-raised btn-xs" data-toggle="modal" data-target="#editar-materia-uacj-pop" data-dismiss="modal" data-backdrop="false" onclick="ModalEditarMateriaUacj(\'' . $datosRen . '\')">
									<i class="zmdi zmdi-refresh"></i></button>
								</td>
								';
					}
					if($privilegio==1){
						$tabla.='
									<td>
										<form action="'.SERVERURL.'ajax/materiauacjAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
											<input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['MateriaUacjClave']).'">
											<input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
											<button type="submit" class="btn btn-danger btn-raised btn-xs">
												<i class="zmdi zmdi-delete"></i>
											</button>
											<div class="RespuestaAjax"></div>
										</form>
									</td>
								';	
					}

					$contador++;
				}
				
				$tabla.='</tr>';
				
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
							<td colspan="7">No hay registros en el sistema</td>
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
				$tabla.='</ul></nav>	
						';
				$contador++;
			}

			return $tabla;
		}		

		public function eliminar_materia_uacj_controlador(){
			$codigo=mainModel::decryption($_POST['codigo-del']);
			$adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

			$codigo=mainModel::limpiar_cadena($codigo);
			$adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

			if($adminPrivilegio==1){
				
				$DelMateria=materiaUacjModelo::eliminar_materia_uacj_modelo($codigo);
				
				if($DelMateria->rowCount()>=1){
					unset($codigo);	
					$alerta=[
						"Alerta"=>"recargar",
						"Titulo"=>"Materia eliminada",
						"Texto"=>"La materia fue eliminado del sistema con éxito",
						"Tipo"=>"success"
					];
				}else{
					$alerta=[
						"Alerta"=>"simple",
						"Titulo"=>"Ocurrió un error inesperado",
						"Texto"=>"No podemos eliminar esta materia, favor de intentar nuevamente!!",
						"Tipo"=>"error"
					];
				}
				return mainModel::sweet_alert($alerta);
			}
		}

		public function actualizar_materia_uacj_controlador(){
			$nombre=mainModel::limpiar_cadena($_POST['MateriaNombreUpdate']);
			$codigo=mainModel::decryption($_POST['MateriaCodigoUpdate']);
			$adminPrivilegio=mainModel::decryption($_POST['MateriaPrivilegioUpdate']);

			$query1=mainModel::ejecutar_consulta_simple("SELECT * FROM materia WHERE MateriaCodigo='$codigo'");
			$DatosMateria=$query1->fetch();

			if($adminPrivilegio==1){

				if($nombre!=$DatosMateria['MateriaNombre']){
					$consulta1=mainModel::ejecutar_consulta_simple("SELECT MateriaNombre FROM materiauacj WHERE MateriaNombre='$nombre'");
					
					if($consulta1->rowCount()>=1)
					{
						$alert=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"El nombre de la materia que acaba de ingresar ya se encuentran registrado en esta carrera",
							"Tipo"=>"error"
						];
						return mainModel::sweet_alert($alert);
						exit();
					}
					
					$guardarMateria=materiaModelo::actualizar_materia_uacj_modelo($codigo,$nombre);
				
					if($guardarMateria->rowCount()>=1){
						unset($codigo);	
						$alerta=[
							"Alerta"=>"recargar",
							"Titulo"=>"Datos actualizados!",
							"Texto"=>"El nombre de la materia ha sido actualizado correctamente",
							"Tipo"=>"success"
						];
					}else{
						$alerta=[
							"Alerta"=>"simple",
							"Titulo"=>"Ocurrió un error inesperado",
							"Texto"=>"No hemos podido actualizar el nombre de la materia, por favor intente nuevamente",
							"Tipo"=>"error"
						];
					}
					return mainModel::sweet_alert($alerta);
				}
			}
		}
	}
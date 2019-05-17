<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['agregarActualizar']) || isset($_POST['PacienteNombre']) || isset($_POST['codigo-del'])){

		require_once "../controladores/pacienteControlador.php";
		$InsPaciente= new pacienteControlador();
	
		if(isset($_POST['agregarActualizar']) && isset($_POST['PacienteNombre'])){
			if ($_POST['agregarActualizar']=="Agregar"){
				echo $InsPaciente->agregar_paciente_controlador();			
			}elseif($_POST['agregarActualizar']=='Actualizar'){
				echo $InsPaciente->actualizar_paciente_controlador();
			}	
		}

		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsPaciente->eliminar_paciente_controlador();
		}

	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
	}
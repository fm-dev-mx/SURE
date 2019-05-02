<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombre']) || isset($_POST['codigo-del']) || isset($_POST['nombreCarreraAgregar']) || isset($_POST['privilegio-admin']) || isset($_POST['codigo-actu']) || isset($_POST['CarreraNombreUpdate']) || isset($_POST['uniSelect']) || isset($_POST['carreraSelect'])){

		require_once "../controladores/carreraControlador.php";
		$InsCarrera= new carreraControlador();

		if(isset($_POST['nombreCarreraAgregar']) && isset($_POST['codigoUniAgregarCarrera'])){
			echo $InsCarrera->agregar_carrera_controlador();
		}
		
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsCarrera->eliminar_carrera_controlador();
		}

		if(isset($_POST['CarreraNombreUpdate']) && isset($_POST['CarreraCodigoUpdate'])){
			echo $InsCarrera->actualizar_carrera_controlador();
		}

		if(isset($_POST['uniSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['uniSelect']=$_POST['uniSelect'];		
		}

		if(isset($_POST['carreraSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['carreraSelect']=$_POST['carreraSelect'];		
			echo '<script> window.location.href="'.SERVERURL.'materias/" </script>';
		}
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }
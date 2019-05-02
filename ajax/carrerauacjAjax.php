<?php
	$peticionAjax=true;
	require_once "../core/configGeneral.php";
	if(isset($_POST['nombreCarreraUacjAgregar']) || isset($_POST['codigo-del']) || isset($_POST['privilegio-admin']) || isset($_POST['CarreraNombreUpdate']) || isset($_POST['CarreraCodigoUpdate']) || isset($_POST['uniSelect']) || isset($_POST['carreraUacjSelect']) ){

		require_once "../controladores/carrerauacjControlador.php";
		$InsCarreraUacj= new carreraUacjControlador();

		if(isset($_POST['nombreCarreraUacjAgregar'])){
			echo $InsCarreraUacj->agregar_carrera_uacj_controlador();
		}
		
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $InsCarreraUacj->eliminar_carrera_uacj_controlador();
		}

		if(isset($_POST['CarreraNombreUpdate']) && isset($_POST['CarreraCodigoUpdate'])){
			echo $InsCarreraUacj->actualizar_carrera_uacj_controlador();
		}

		if(isset($_POST['carreraUacjSelect'])){
			session_start(['name'=>'SBP']);
			$_SESSION['carreraUacjSelect']=$_POST['carreraUacjSelect'];		
			echo '<script> window.location.href="'.SERVERURL.'materiasuacjlist/" </script>';
		}
	}else{
		session_start(['name'=>'SBP']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }
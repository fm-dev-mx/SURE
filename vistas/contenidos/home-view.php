<?php 
    if($_SESSION['tipo_sbp']!="Administrador"){
        echo $lc->forzar_cierre_sesion_controlador();
    }
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles">Sistema de equivalencias <small>UACJ</small></h1>
	</div>
</div>

<?php
	require "./controladores/administradorControlador.php";
	$IAdmin= new administradorControlador();
	$CAdmin=$IAdmin->datos_administrador_controlador("Conteo",0);
	require "./controladores/pacienteControlador.php";
	$IPaciente= new pacienteControlador();
	$CPaciente=$IPaciente->datos_paciente_controlador("Conteo",0);
	require "./controladores/carreraControlador.php";
	$ICarrera= new carreraControlador();
	$CCarrera=$ICarrera->datos_carrera_controlador("Conteo",0);
?>

<div class="container-fluid">	
	<div class="btn-group">
		<button class="btn btn-default btn-lg dropdown-toggle btn btn-info" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="zmdi zmdi-plus"></i> &nbsp; REGISTRAR CONSULTA <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="<?php echo SERVERURL; ?>paciente/">Primer contacto</a></li>
			<li><a href="<?php echo SERVERURL; ?>consulta/">Seguimiento</a></li>
		</ul>
	</div>
</div>

<div class="full-box text-center" style="padding: 30px 10px;">
	<a href="<?php echo SERVERURL; ?>adminlist/">
		<article class="full-box tile">
			<div class="full-box tile-title text-center text-titles text-uppercase">
				Administradores
			</div>
			<div class="full-box tile-icon text-center">
				<i class="zmdi zmdi-account"></i>
			</div>
			<div class="full-box tile-number text-titles">
				<p class="full-box"><?php echo $CAdmin->rowCount(); ?></p>
				<small>Registrados</small>
			</div>
		</article>
	</a>
	<a href="<?php echo SERVERURL; ?>univList/">
		<article class="full-box tile">
			<div class="full-box tile-title text-center text-titles text-uppercase">
				Universidades
			</div>
			<div class="full-box tile-icon text-center">
				<i class="zmdi zmdi-balance"></i>
			</div>
			<div class="full-box tile-number text-titles">
				<p class="full-box"><?php echo $CUniv->rowCount(); ?></p>
				<small>Register</small>
			</div>
		</article>
	</a>
	<a href="<?php echo SERVERURL; ?>carrera/">
		<article class="full-box tile">
			<div class="full-box tile-title text-center text-titles text-uppercase">
				Carreras
			</div>
			<div class="full-box tile-icon text-center">
				<i class="zmdi zmdi-library"></i>
			</div>
			<div class="full-box tile-number text-titles">
				<p class="full-box"><?php echo $CCarrera->rowCount(); ?></p>
				<small>Register</small>
			</div>
		</article>
	</a>
</div>


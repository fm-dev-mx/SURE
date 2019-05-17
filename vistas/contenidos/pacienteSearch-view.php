<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-library zmdi-hc-fw"></i> Pacientes <small></small></h1>
	</div>
</div>

<?php 
	require_once "./controladores/pacienteControlador.php";
	$insPaciente= new pacienteControlador();

	if(isset($_POST['busqueda_inicial_paciente'])){
		$_SESSION['busqueda_paciente']=$_POST['busqueda_inicial_paciente'];
	}

	if(isset($_POST['eliminar_busqueda_paciente'])){
		unset($_SESSION['busqueda_paciente']);
	}

	if(!isset($_SESSION['busqueda_paciente']) && empty($_SESSION['busqueda_paciente'])):
?>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
			<div class="container-fluid">	
				<div class="btn-group">
					<button class="btn btn-default btn-lg dropdown-toggle btn btn-info" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="zmdi zmdi-plus"></i> &nbsp; REGISTRAR CONSULTA <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="<?php echo SERVERURL; ?>primerContacto/">Primer contacto</a></li>
						<li><a href="<?php echo SERVERURL; ?>consulta/">Seguimiento</a></li>
					</ul>
				</div>
			</div>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>pacienteList/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PACIENTES
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>pacienteSearch/" class="btn btn-primary">
	  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR
	  		</a>
	  	</li>
	</ul>
</div>

<div class="container-fluid">
	<form class="well" method="POST" action="" autocomplete="off">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="form-group label-floating">
					<span class="control-label">¿A quién estas buscando?</span>
					<input class="form-control" type="text" name="busqueda_inicial_paciente" required="">
				</div>
			</div>
			<div class="col-xs-12">
				<p class="text-center">
					<button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> &nbsp; Buscar</button>
				</p>
			</div>
		</div>
	</form>
</div>
<?php else: ?>
<div class="container-fluid">
	<form class="well" method="POST" action="">
		<p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['busqueda_paciente']; ?>”</strong></p>
		<div class="row">
			<input class="form-control" type="hidden" name="eliminar_busqueda_paciente" value="1">
			<div class="col-xs-12">
				<p class="text-center">
					<button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
				</p>
			</div>
		</div>
	</form>
</div>

<!-- Panel listado de busqueda de pacientes -->
<div class="container-fluid">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR PACIENTE</h3>
		</div>
		<div class="panel-body">
			<?php 
				$pagina = explode("/", $_GET['views']);
				echo $insPaciente->paginador_paciente_controlador($pagina[1],10,$_SESSION['privilegio_sbp'],$_SESSION['busqueda_paciente']);
			?>
		</div>
	</div>
</div>
<?php endif; ?>
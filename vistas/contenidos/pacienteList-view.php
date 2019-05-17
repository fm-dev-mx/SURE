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

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
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
<?php 
	require_once "./controladores/pacienteControlador.php";
	$insPaciente= new pacienteControlador();
?>
<!-- Panel listado de pacientes -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PACIENTES</h3>
		</div>
		<div class="panel-body">
			<?php 
				$pagina = explode("/", $_GET['views']);
				echo $insPaciente->paginador_paciente_controlador($pagina[1],10,$_SESSION['privilegio_sbp'],"");
			?>	
		</div>
	</div>
</div>
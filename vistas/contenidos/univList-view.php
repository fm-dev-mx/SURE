<?php 
	if($_SESSION['tipo_sbp']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Administración <small>Universidades</small></h1>
	</div>
	<p class="lead"></p>
</div>

<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>univ/" class="btn btn-info">
	  			<i class="zmdi zmdi-plus"></i> &nbsp; AGREGAR INSTITUTO
	  		</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>univList/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE INSTITUTOS
	  		</a>
	  	</li>
		<li>
	  		<a href="<?php echo SERVERURL; ?>univSearch/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; BUSCAR INSTITUTOS
	  		</a>
	  	</li>  
	</ul>
</div>

<?php 
	require_once "./controladores/universidadControlador.php";
	$insUniv= new universidadControlador();
?>

<!-- Panel listado de universidades -->
<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE UNIVERSIDADES</h3>
		</div>
		<div class="panel-body">
			<?php 
				$pagina = explode("/", $_GET['views']);
				echo $insUniv->paginador_universidad_controlador($pagina[1],10,$_SESSION['privilegio_sbp'],"");
			?>	
		</div>
	</div>
</div>
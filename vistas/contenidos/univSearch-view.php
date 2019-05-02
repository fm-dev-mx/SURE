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

	if(isset($_POST['busqueda_inicial_univ'])){
		$_SESSION['busqueda_univ']=$_POST['busqueda_inicial_univ'];
	}

	if(isset($_POST['eliminar_busqueda_univ'])){
		unset($_SESSION['busqueda_univ']);
	}

	if(!isset($_SESSION['busqueda_univ']) && empty($_SESSION['busqueda_univ'])):
?>
<div class="container-fluid">
	<form class="well" method="POST" action="" autocomplete="off">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="form-group label-floating">
					<span class="control-label">Ingresa algún dato de tu universidad:</span>
					<input class="form-control" type="text" name="busqueda_inicial_univ" required="">
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
		<p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['busqueda_univ']; ?>”</strong></p>
		<div class="row">
			<input class="form-control" type="hidden" name="eliminar_busqueda_univ" value="1">
			<div class="col-xs-12">
				<p class="text-center">
					<button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
				</p>
			</div>
		</div>
	</form>
</div>

<!-- Panel listado de busqueda de universidades -->
<div class="container-fluid">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR INSTITUTOS</h3>
		</div>
		<div class="panel-body">
			<?php 
				$pagina = explode("/", $_GET['views']);
				echo $insUniv->paginador_universidad_controlador($pagina[1],10,$_SESSION['privilegio_sbp'],$_SESSION['busqueda_univ']);
			?>
		</div>
	</div>
</div>
<?php endif; ?>
<section class="full-box cover dashboard-sideBar">
	<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
	<div class="full-box dashboard-sideBar-ct">
		<!--SideBar Title -->
		<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
			<?php echo COMPANY; ?> <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
		</div>
		<!-- SideBar User info -->
		<div class="full-box dashboard-sideBar-UserInfo">
			<figure class="full-box">
				<BR>
				<img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $_SESSION['foto_sbp']; ?>" alt="UserIcon">
				<br>
				<figcaption class="text-center text-titles"><?php echo $_SESSION['nombre_sbp']; ?></figcaption>
			</figure>
			<?php 
				if($_SESSION['tipo_sbp']=="Administrador"){
					$tipo="admin";
				}else{
					$tipo="user";
				}
			?>
			<ul class="full-box list-unstyled text-center">
				<li>
					<a href="<?php echo SERVERURL; ?>mydata/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_sbp']); ?>/" title="Mis datos">
						<i class="zmdi zmdi-account-circle"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo SERVERURL; ?>myaccount/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_sbp']); ?>/" title="Mi cuenta">
						<i class="zmdi zmdi-settings"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo $lc->encryption($_SESSION['token_sbp']); ?>" title="Salir del sistema" class="btn-exit-system">
						<i class="zmdi zmdi-power"></i>
					</a>
				</li>
			</ul>
		</div>
		<!-- SideBar Menu -->
		<ul class="list-unstyled full-box dashboard-sideBar-Menu">
			<?php if($_SESSION['tipo_sbp']=="Administrador"): ?>
			<li>
				<a href="<?php echo SERVERURL; ?>home/">
					<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Dashboard
				</a>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-case zmdi-hc-fw"></i> Administración <i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php echo SERVERURL; ?>univList/"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Universidades</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>carrera/"><i class="zmdi zmdi-bookmark zmdi-hc-fw"></i> Carreras</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>materias/"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Materias</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>carrerauacj/"><i class="zmdi zmdi-bookmark zmdi-hc-fw"></i> Carreras - UACJ</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>materiasuacjlist/"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Materias - UACJ</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php echo SERVERURL; ?>admin/"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Administradores</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>home/"><i class="zmdi zmdi-male-female zmdi-hc-fw"></i> Clientes</a>
					</li>
				</ul>
			</li>
			<?php endif; ?>
		</ul>
	</div>
</section>
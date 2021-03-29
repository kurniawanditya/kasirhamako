<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>HAMAKO APPLICATION</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">


	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green-light sidebar-mini">

	<div class="wrapper">
		<header class="main-header">
			<a href="#" class="logo" disable>
				<span class="logo-mini"><img src="<?=base_url()?>assets/dist/img/icon2.png" class="logo-lg" height="40px" style="margin:auto" ></span>
				<img src="<?=base_url()?>assets/dist/img/logo3.png" class="logo-lg" height="50px" >
			</a>
			<nav class="navbar navbar-static-top">
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">

						<!-- User Account -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?=base_url()?>assets/dist/img/user.jpg" class="user-image">
								<span class="hidden-xs"><?=$this->fungsi->user_login()->username?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="<?=base_url()?>assets/dist/img/user.jpg" class="img-circle">
									<p><?=$this->fungsi->user_login()->name?>
										<small><?=$this->fungsi->user_login()->address?></small>
									</p>
								</li>
								<li class="user-footer">
									<div class="pull-left">
										<a href="#" class="btn btn-default btn-flat">Profile</a>
									</div>
									<div class="pull-right">
										<a href="<?=site_url('Auth/logout')?>" class="btn btn-flat bg-red">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- Left side column -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?=base_url()?>assets/dist/img/user.jpg" class="img-circle">
					</div>
					<div class="pull-left info">
						<p><?=ucfirst($this->fungsi->user_login()->username)?></p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>
				<!-- <form action="#" method="get" class="sidebar-form">
					<div class="input-group">
						<input type="text" name="q" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form> -->
				<!-- sidebar menu -->
				<!--FULLADMIN-->
				<?php if($this->fungsi->user_login()->level  == 1) { ?>
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MAIN NAVIGATION</li>
					<li <?=$this->uri->segment(1) == 'Dashboard' || $this->uri->segment(1) == '' ? 'class="active"' : '';?>>
						<a href="<?=site_url('Dashboard')?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
					</li>
					<li <?=$this->uri->segment(1) == 'Supplier' ? 'class="active"' : '';?>>
						<a href="<?=site_url('Supplier')?>"><i class="fa fa-truck"></i> <span>Suppliers</span></a>
					</li>
					<li <?=$this->uri->segment(1) == 'Customer' ? 'class="active"' : '';?>>
						<a href="<?=site_url('Customer')?>">
							<i class="fa fa-users"></i> <span>Customers</span>
						</a>
					</li>
					<li class="treeview <?=$this->uri->segment(1) == 'Item' || $this->uri->segment(1) == 'Material'
					|| $this->uri->segment(1) == 'Aksesorisin' || $this->uri->segment(1) == 'Accout'
					|| $this->uri->segment(1) == 'Jenis' || $this->uri->segment(1) == 'Merk' || $this->uri->segment(1) == 'Koleksi'
					|| $this->uri->segment(1) == 'Material' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-archive"></i> <span>Products</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Item' ? 'class="active"' : '';?>><a href="<?=site_url('Item')?>"><i class="fa fa-circle-o"></i> Item</a></li>
							<li <?=$this->uri->segment(1) == 'Jenis' ? 'class="active"' : '';?>><a href="<?=site_url('Jenis')?>"><i class="fa fa-circle-o"></i> Jenis</a></li>
							<li <?=$this->uri->segment(1) == 'Merk' ? 'class="active"' : '';?>><a href="<?=site_url('Merk')?>"><i class="fa fa-circle-o"></i> Merk</a></li>
							<li <?=$this->uri->segment(1) == 'Koleksi' ? 'class="active"' : '';?>><a href="<?=site_url('Koleksi')?>"><i class="fa fa-circle-o"></i> Koleksi</a></li>
							<li class="header">Material & Aksesoris</li>
							<li <?=$this->uri->segment(1) == 'Material' ? 'class="active"' : '';?>><a href="<?=site_url('Material')?>"><i class="fa fa-circle-o"></i> Data Aksesoris</a></li>
							<li <?=$this->uri->segment(1) == 'Aksesorisin' ? 'class="active"' : '';?>><a href="<?=site_url('Aksesorisin')?>"><i class="fa fa-circle-o"></i> In </a></li>
							<li <?=$this->uri->segment(1) == 'Accout' ? 'class="active"' : '';?>><a href="<?=site_url('Accout')?>"><i class="fa fa-circle-o"></i> Out </a></li>
						</ul>
					</li>
					<li class="treeview  <?=$this->uri->segment(1) == 'Sales' || $this->uri->segment(1) == 'Stockin' || $this->uri->segment(1) == 'Stockout' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-shopping-cart"></i> <span>Transaction</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Sales' ? 'class="active"' : '';?>><a href="<?=site_url('Sales')?>"><i class="fa fa-circle-o"></i> Sales</a></li>
							<li <?=$this->uri->segment(1) == 'Barangmasuk' ? 'class="active"' : '';?>><a href="<?=site_url('Barangmasuk')?>"><i class="fa fa-circle-o"></i> Barang Masuk</a></li>
						</ul>
					</li>
					<li class="treeview  <?=$this->uri->segment(1) == 'Rsales' || $this->uri->segment(1) == 'Rstock' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-pie-chart"></i> <span>Reports</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Rsales' ? 'class="active"' : '';?>><a href="<?=site_url('Report/Rsales')?>"><i class="fa fa-circle-o"></i> Sales</a></li>
						</ul>
					</li>

					<li class="header">SETTINGS</li>
					<li><a href="<?=site_url('User')?>"><i class="fa fa-user"></i> <span>Users</span></a></li>
				</ul>
				<?php } ?>
				<?php if($this->fungsi->user_login()->level  == 3) { ?>
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MAIN NAVIGATION</li>
					<li <?=$this->uri->segment(1) == 'Dashboard' || $this->uri->segment(1) == '' ? 'class="active"' : '';?>>
						<a href="<?=site_url('Dashboard')?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
					</li>
					<li <?=$this->uri->segment(1) == 'Supplier' ? 'class="active"' : '';?>>
						<a href="<?=site_url('Supplier')?>"><i class="fa fa-truck"></i> <span>Suppliers</span></a>
					</li>
					<li <?=$this->uri->segment(1) == 'Customer' ? 'class="active"' : '';?>>
						<a href="<?=site_url('Customer')?>">
							<i class="fa fa-users"></i> <span>Customers</span>
						</a>
					</li>
					<li class="treeview <?=$this->uri->segment(1) == 'Item' || $this->uri->segment(1) == 'Material'
					|| $this->uri->segment(1) == 'Aksesorisin' || $this->uri->segment(1) == 'Aksesorisout'
					|| $this->uri->segment(1) == 'Jenis' || $this->uri->segment(1) == 'Merk' || $this->uri->segment(1) == 'Koleksi'
					|| $this->uri->segment(1) == 'Material' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-archive"></i> <span>Products</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Item' ? 'class="active"' : '';?>><a href="<?=site_url('Item')?>"><i class="fa fa-circle-o"></i> Item</a></li>
							<li <?=$this->uri->segment(1) == 'Jenis' ? 'class="active"' : '';?>><a href="<?=site_url('Jenis')?>"><i class="fa fa-circle-o"></i> Jenis</a></li>
							<li <?=$this->uri->segment(1) == 'Merk' ? 'class="active"' : '';?>><a href="<?=site_url('Merk')?>"><i class="fa fa-circle-o"></i> Merk</a></li>
							<li <?=$this->uri->segment(1) == 'Koleksi' ? 'class="active"' : '';?>><a href="<?=site_url('Koleksi')?>"><i class="fa fa-circle-o"></i> Koleksi</a></li>
						<li class="header">Material & Aksesoris</li>
							<li <?=$this->uri->segment(1) == 'Material' ? 'class="active"' : '';?>><a href="<?=site_url('Material')?>"><i class="fa fa-circle-o"></i> Data Aksesoris</a></li>
							<li <?=$this->uri->segment(1) == 'Aksesorisin' ? 'class="active"' : '';?>><a href="<?=site_url('Aksesorisin')?>"><i class="fa fa-circle-o"></i> In </a></li>
							<li <?=$this->uri->segment(1) == 'Accout' ? 'class="active"' : '';?>><a href="<?=site_url('Accout')?>"><i class="fa fa-circle-o"></i> Out </a></li>
						</ul>
					</li>
					<li class="treeview  <?=$this->uri->segment(1) == 'Sales' || $this->uri->segment(1) == 'Stockin' || $this->uri->segment(1) == 'Stockout' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-shopping-cart"></i> <span>Transaction</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Sales' ? 'class="active"' : '';?>><a href="<?=site_url('Sales')?>"><i class="fa fa-circle-o"></i> Sales</a></li>
							<li <?=$this->uri->segment(1) == 'Barangmasuk' ? 'class="active"' : '';?>><a href="<?=site_url('Barangmasuk')?>"><i class="fa fa-circle-o"></i> Barang Masuk</a></li>
						</ul>
					</li>
					<li class="treeview  <?=$this->uri->segment(1) == 'Rsales' || $this->uri->segment(1) == 'Rstock' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-pie-chart"></i> <span>Reports</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Rsales' ? 'class="active"' : '';?>><a href="<?=site_url('Report/Rsales')?>"><i class="fa fa-circle-o"></i> Sales</a></li>
						</ul>
					</li>
				</ul>
				<?php }
				if($this->fungsi->user_login()->level  == 4) { ?>
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MAIN NAVIGATIONaa</li>
					<li class="treeview <?=$this->uri->segment(1) == 'Item' || $this->uri->segment(1) == 'Jenis' || $this->uri->segment(1) == 'Merk' || $this->uri->segment(1) == 'Koleksi' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-archive"></i> <span>Products</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Item' ? 'class="active"' : '';?>><a href="<?=site_url('Item')?>"><i class="fa fa-circle-o"></i> Item</a></li>
						</ul>
					</li>
				</ul>
				<?php } ?>
				<?php if($this->fungsi->user_login()->level  == 2) { ?>
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MAIN NAVIGATIOasdasN</li>
					<li <?=$this->uri->segment(1) == 'Customer' ? 'class="active"' : '';?>>
						<a href="<?=site_url('Customer')?>">
							<i class="fa fa-users"></i> <span>Customers</span>
						</a>
					</li>
					<li class="treeview  <?=$this->uri->segment(1) == 'Sales' || $this->uri->segment(1) == 'Stockin' || $this->uri->segment(1) == 'Stockout' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-shopping-cart"></i> <span>Transaction</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Sales' ? 'class="active"' : '';?>><a href="<?=site_url('Sales')?>"><i class="fa fa-circle-o"></i> Sales</a></li>

						</ul>
					</li>
					<li class="treeview  <?=$this->uri->segment(1) == 'Rsales' || $this->uri->segment(1) == 'Rstock' ? 'active' : ''?>">
						<a href="#">
							<i class="fa fa-pie-chart"></i> <span>Reports</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?=$this->uri->segment(1) == 'Rsales' ? 'class="active"' : '';?>><a href="<?=site_url('Report/Rsales')?>"><i class="fa fa-circle-o"></i> Sales</a></li>
						</ul>
					</li>

					<li class="header">SETTINGS</li>
					<li><a href="<?=site_url('User')?>"><i class="fa fa-user"></i> <span>Users</span></a></li>
				</ul>
				<?php } ?>
			</section>
		</aside>
		<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Content Wrapper -->
		<div class="content-wrapper">
			<?php echo $contents ?>
		</div>

		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 1.0
			</div>
			<strong>Copyright &copy; 2020 <a href="https://hamakoecolife.com">PT Hamako Apparel Indonesia</a>.</strong> All rights reserved.
		</footer>

	</div>


	<script src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

	<script src="<?=base_url()?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?=base_url()?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

	<script src="<?=base_url()?>assets/dist/js/adminlte.min.js"></script>

	<script src="<?=base_url()?>assets/bower_components/fastclick/lib/fastclick.js"></script>
	<!-- Sparkline -->
	<script src="<?=base_url()?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
	<!-- jvectormap  -->
	<script src="<?=base_url()?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<!-- ChartJS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<!-- <script src="<?=base_url()?>assets/dist/js/pages/dashboard.js"></script> -->
	<script src="<?=base_url()?>assets/bower_components/chart.js/Chart.js"></script>
	<script src="https://cdn.datatables.net/plug-ins/1.10.22/dataRender/datetime.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>

	<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

	<script>

		$(document).ready(function(){
			$('#table1').DataTable();
			$('#table3').DataTable( {
				columnDefs: [ {
				targets: 1,
				render: $.fn.dataTable.render.moment( 'D MMM YYYY' )
				} ]
			} );
			$('#table2').DataTable( {
				columnDefs: [ {
				targets: 2,
				render: $.fn.dataTable.render.moment( 'D MMM YYYY' )
				} ]
			} );
			$('#tablesales').DataTable( {
				columnDefs: [
						{ targets: 2, render: $.fn.dataTable.render.moment( 'D MMM YYYY' ) },
						{ targets: [5,6,7,8,9], render: $.fn.dataTable.render.number(',', '.', 0,'Rp ') }
					]
			} );
			$('#mtable').DataTable( {
				columnDefs: [
						{ targets: 6, render: $.fn.dataTable.render.number(',', '.', 0,'Rp ') }
					]
			} );
		});

	</script>

</body>
</html>

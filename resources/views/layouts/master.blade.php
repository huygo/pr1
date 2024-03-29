<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title> @yield('title')</title>
	<link rel="shortcut icon" type="image/jpg" href="https://www.positronx.io/wp-content/themes/positronx/favicon-32x32.png"/>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="{{ asset('template') }}/plugins/fontawesome-free/css/all.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ asset('template') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('template') }}/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="{{ asset('custom') }}/custom.css">
	<!-- <link rel="stylesheet" href="{{ asset('template') }}/dist/css/adminlte.min.css"> -->

	<!-- jQuery -->
	<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="{{ asset('template') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->

	<!-- PAGE PLUGINS -->
	<!-- jQuery Mapael -->
	<script src="{{ asset('template') }}/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
	<script src="{{ asset('template') }}/plugins/raphael/raphael.min.js"></script>
	<script src="{{ asset('template') }}/plugins/jquery-mapael/jquery.mapael.min.js"></script>
	<script src="{{ asset('template') }}/plugins/jquery-mapael/maps/usa_states.min.js"></script>
	<!-- ChartJS -->
	<script src="{{ asset('template') }}/plugins/chart.js/Chart.min.js"></script>

	<!-- AdminLTE for demo purposes -->
	<script src="{{ asset('template') }}/dist/js/demo.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="{{ asset('template') }}/dist/js/pages/dashboard2.js"></script>

	<script src="{{ asset('custom') }}/custom.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/alasql/0.4.2/alasql.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.core.min.js"></script>


</head><!--/head-->

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">
	<!--/header-->
	@include("layouts.elements.header")
	<!--/slider-->

	@yield('content')

	@include("layouts.elements.footer")
	<!--/Footer-->
	</div>
	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="{{ asset('template') }}/dist/js/adminlte.js"></script>
</body>
</html>

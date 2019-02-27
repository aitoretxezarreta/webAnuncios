<?php
	require("../../modelos/clase_usuario.php");

	session_start();

	if(isset($_SESSION["usuario"])) {
		$usuario = unserialize($_SESSION["usuario"]);
	} else {
		header("Location:../home.php");
	}

	if(isset($_SESSION["totalAnuncios"])) {
		$totalAnuncios =$_SESSION["totalAnuncios"];
	}

	if(isset($_SESSION["totalChollos"])) {
		$totalChollos =$_SESSION["totalChollos"];
	}

	if(isset($_SESSION["totalCorrecto"])) {
		$totalCorrecto =$_SESSION["totalCorrecto"];
	}

	if(isset($_SESSION["totalAlto"])) {
		$totalAlto =$_SESSION["totalAlto"];
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	</head>
	<body>
		<!-- MENU SUPERIOR -->
		<div class="menu">
			<span><b>WEB ANUNCIOS</b></span>
			<a href="../../controladores/controlador_web.php?op=2">Webs</a>
			<a href="../../controladores/controlador_categoria.php?op=2">Categorías</a>
			<a href="../../controladores/controlador_usuario.php?op=4">Anuncios</a>
			<a href="datos_personales.php">Datos personales</a>
			<a style="float: right;" href="../../controladores/controlador_usuario.php?op=5">LOGOUT</a>
		</div>
		
		<!-- CONTENIDO PÁGINA ADMINNISTRADOR -->
		<div class="contenido">
			<!--
			<ul>
				<li>Total de anuncios disponibles: <?php echo $totalAnuncios; ?></li>
				<li>Precio chollo: <?php echo $totalChollos; ?></li>
				<li>Precio correcto: <?php echo $totalCorrecto; ?></li>
				<li>Precio alto: <?php echo $totalAlto; ?></li>
			</ul>
			-->
			<h3>Anuncios disponibles</h3>
			<canvas id="bar-chart" width="3" height="1"></canvas>
		</div>

		<script type="text/javascript">
			var total = '<?php echo $totalAnuncios;?>';
			var chollo = '<?php echo $totalChollos;?>';
			var correcto = '<?php echo $totalCorrecto;?>';
			var alto = '<?php echo $totalAlto;?>';

			new Chart(document.getElementById("bar-chart"), {
				type: 'horizontalBar',
				data: {
					labels: ["Total", "Chollos", "Correctos", "Altos"],
					datasets: [
						{
						label: "Anuncios",
						backgroundColor: ['rgba(54, 162, 235, 0.5)','rgba(75, 192, 192, 0.5)','rgba(255, 206, 86, 0.5)','rgba(255, 99, 132, 0.5)'],
						data: [total,chollo,correcto,alto]
						}
					]
				},
				options: {
					legend: { display: false },
					title: { display: false },
					scales: {
						xAxes: [{
							ticks: {
								beginAtZero: true,
								stepSize: 1
							}
						}]
					}
				}
			});
		</script>
	</body>
</html>
<?php
	require_once("../../modelos/clase_usuario.php");
	require_once("../../modelos/clase_web.php");

	session_start();

	if(isset($_SESSION["usuario"])) {
		$usuario = unserialize($_SESSION["usuario"]);
	} else {
		header("Location:../home.php");
	}
	
 	if(isset($_SESSION["webs"])) {
		$webs = unserialize($_SESSION["webs"]);
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Webs</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
	</head>
	<body>
		<!-- MENU SUPERIOR -->
		<div class="menu">
			<a href="../../controladores/controlador_anuncio.php?op=5"><b>WEB ANUNCIOS</b></a>
			<span>Webs</span>
			<a href="../../controladores/controlador_categoria.php?op=2">Categorías</a>
			<a href="../../controladores/controlador_usuario.php?op=4">Anuncios</a>
			<a href="datos_personales.php">Datos personales</a>
			<a style="float: right;" href="../../controladores/controlador_usuario.php?op=5">LOGOUT</a>
		</div>
		
		<!-- CONTENIDO PÁGINA ADMINNISTRADOR -->
		<div class="contenido">
			<div style="overflow-x:auto;">
				<table cellpadding='8' cellspacing='0' class="tablaMovimientos">
					<tr>
						<th>Web</th>
						<th>URL</th>
						<th colspan="2"></th>
					</tr>
					<form method="POST" action="../../controladores/controlador_web.php?op=1">
						<tr>
							<td><input type="text" id="web_nombre" name="web_nombre" required/></td>
							<td><input type="text" id="web_url" name="web_url" required/></td>
							<td><button class="btn" type="submit"><i class="fas fa-plus"></i></button></td>
							<td></td>
						</tr>
					</form>
<?php
					$edit_id = 0;
					if (isset($_GET["id"])) {
						$edit_id = $_GET["id"];
					}

					for($x = 0; $x < count($webs); $x++) {
						if ($edit_id == $webs[$x]->id) { //Editamos directamente en la fila: ?>
							<tr>
								<form method="POST" action="../../controladores/controlador_web.php?op=3">
									<input type="hidden" id="web_id" name="web_id" value="<?php echo $webs[$x]->id; ?>"/>
									<td>
										<input type="text" id="web_nombre" name="web_nombre" value="<?php echo $webs[$x]->nombre; ?>" required/>
									</td>
									<td>
										<input type="text" id="web_url" name="web_url" value="<?php echo $webs[$x]->url; ?>" required/>
									</td>
									<td>
										<button type="submit" class="btn"><i class="fas fa-save"></i></button>
									</td>
								</form>
								<td>
									<button class="btn" onclick="document.location.href='mantenimiento_webs.php'"><i class="fas fa-times"></i></button>
								</td>
							</tr>
						<?php } else {
							echo "<tr>";
								echo "<td>" . $webs[$x]->nombre . "</td>";
								echo "<td><a href='https://" . $webs[$x]->url . "' target='_blank'>Ir a " . $webs[$x]->url . "</a></td>";
?>
								<td><button class='btn' onclick="document.location.href='mantenimiento_webs.php?id=<?php echo $webs[$x]->id; ?>'"><i class='fas fa-pen'></i></button></td>
								<td><button class='btn' onclick="document.location.href='../../controladores/controlador_web.php?op=4&id=<?php echo $webs[$x]->id; ?>'"><i class='fas fa-trash'></i></button></td>
							</tr>
<?php
						}
					}
?>
				</table>
			</div>
		</div>
	</body>
</html>
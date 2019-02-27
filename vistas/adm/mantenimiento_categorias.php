<?php
	require_once("../../modelos/clase_usuario.php");
	require_once("../../modelos/clase_categoria.php");

	session_start();

	if(isset($_SESSION["usuario"])) {
		$usuario = unserialize($_SESSION["usuario"]);
	} else {
		header("Location:../home.php");
	}
	
 	if(isset($_SESSION["categorias"])) {
		$categorias = unserialize($_SESSION["categorias"]);
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Categorias</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
	</head>
	<body>
		<!-- MENU SUPERIOR -->
		<div class="menu">
			<a href="../../controladores/controlador_anuncio.php?op=5"><b>WEB ANUNCIOS</b></a>
			<a href="../../controladores/controlador_web.php?op=2">Webs</a>
			<span>Categorías</span>
			<a href="../../controladores/controlador_usuario.php?op=4">Anuncios</a>
			<a href="datos_personales.php">Datos personales</a>
			<a style="float: right;" href="../../controladores/controlador_usuario.php?op=5">LOGOUT</a>
		</div>
		
		<!-- CONTENIDO PÁGINA ADMINNISTRADOR -->
		<div class="contenido">
			<div style="overflow-x:auto;">
				<table cellpadding='8' cellspacing='0' class="tablaMovimientos">
					<tr>
						<th>Categoria</th>
						<th colspan="2"></th>
					</tr>
					<form method="POST" action="../../controladores/controlador_categoria.php?op=1" enctype="multipart/form-data">
						<tr>
							<td><input type="file" id="categoria_imagenUrl" name="categoria_imagenUrl"/></td>
							<td><input type="text" id="categoria_categoria" name="categoria_categoria" required/></td>
							<td><button class="btn" type="submit"><i class="fas fa-plus"></i></button></td>
							<td></td>
						</tr>
					</form>
<?php
					$edit_id = 0;
					if (isset($_GET["id"])) {
						$edit_id = $_GET["id"];
					}

					for($x = 0; $x < count($categorias); $x++) {
						if ($edit_id == $categorias[$x]->id) { //Editamos directamente en la fila: ?>
							<tr>
								<form method="POST" action="../../controladores/controlador_categoria.php?op=3"  enctype="multipart/form-data">
									<input type="hidden" id="categoria_id" name="categoria_id" value="<?php echo $categorias[$x]->id; ?>"/>
									<td>
										<input type="file" id="categoria_imagenUrl" name="categoria_imagenUrl"/>
									</td>
									<td>
										<input type="text" id="categoria_categoria" name="categoria_categoria" value="<?php echo $categorias[$x]->categoria; ?>" required/>
									</td>
									<td>
										<button type="submit" class="btn"><i class="fas fa-save"></i></button>
									</td>
								</form>
								<td>
									<button class="btn" onclick="document.location.href='mantenimiento_categorias.php'"><i class="fas fa-times"></i></button>
								</td>
							</tr>
						<?php } else {
							echo "<tr>";
								echo "<td><img src='../../img/categorias/" . $categorias[$x]->imagen_url . "' alt='img categoria " . strtolower($categorias[$x]->categoria) . "' style='width: 100px;'></td>";
								echo "<td>" . $categorias[$x]->categoria . "</td>";
?>
								<td><button class='btn' onclick="document.location.href='mantenimiento_categorias.php?id=<?php echo $categorias[$x]->id; ?>'"><i class='fas fa-pen'></i></button></td>
								<td><button class='btn' onclick="document.location.href='../../controladores/controlador_categoria.php?op=4&id=<?php echo $categorias[$x]->id; ?>'"><i class='fas fa-trash'></i></button></td>
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
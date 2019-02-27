<?php
	require_once("../../modelos/clase_usuario.php");
	require_once("../../modelos/clase_categoria.php");
	require_once("../../modelos/clase_web.php");

	session_start();

	if(isset($_SESSION["usuario"])) {
		$usuario = unserialize($_SESSION["usuario"]);
	} else {
		header("Location:../home.php");
	}
	
 	if(isset($_SESSION["anuncios"])) {
		$anuncios = unserialize($_SESSION["anuncios"]);
	}
	
 	if(isset($_SESSION["categorias"])) {
		$categorias = unserialize($_SESSION["categorias"]);
	}
	
 	if(isset($_SESSION["webs"])) {
		$webs = unserialize($_SESSION["webs"]);
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Anuncios</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
	</head>
	<body>
		<!-- MENU SUPERIOR -->
		<div class="menu">
			<a href="../../controladores/controlador_anuncio.php?op=5"><b>WEB ANUNCIOS</b></a>
			<a href="../../controladores/controlador_web.php?op=2">Webs</a>
			<a href="../../controladores/controlador_categoria.php?op=2">Categorías</a>
			<span>Anuncios</span>
			<a href="datos_personales.php">Datos personales</a>
			<a style="float: right;" href="../../controladores/controlador_usuario.php?op=5">LOGOUT</a>
		</div>
		
		<!-- CONTENIDO PÁGINA ADMINNISTRADOR -->
		<div class="contenido">
			<div style="overflow-x:auto;">
				<table cellpadding='8' cellspacing='0' class="tablaMovimientos">
					<tr>
						<th>Nombre</th>
						<th>Precio</th>
						<th>Precio Correcto Mínimo</th>
						<th>Precio Correcto Máximo</th>
						<th>Categoría</th>
						<th>URL Foto</th>
						<th>Web</th>
						<th>URL Anuncio</th>
						<th colspan="2"></th>
					</tr>
					<form method="POST" action="../../controladores/controlador_anuncio.php?op=1">
						<tr>
							<td><input type="text" id="anuncio_nombre" name="anuncio_nombre" required/></td>
							<td><input type="text" id="anuncio_precio" name="anuncio_precio" required/></td>
							<td><input type="text" id="anuncio_precio_correcto_min" name="anuncio_precio_correcto_min" required/></td>
							<td><input type="text" id="anuncio_precio_correcto_max" name="anuncio_precio_correcto_max" required/></td>
							<td>
								<select id="anuncio_categoria_id" name="anuncio_categoria_id">
									<?php for($y = 0; $y < count($categorias); $y++) { ?>
										<option value="<?php echo $categorias[$y]->id; ?>"><?php echo $categorias[$y]->categoria; ?></option>
									<?php } ?>
								</select>
							</td>
							<td><input type="text" id="anuncio_url_foto" name="anuncio_url_foto"/></td>
							<td>
								<select id="anuncio_web_id" name="anuncio_web_id">
									<?php for($y = 0; $y < count($webs); $y++) { ?>
										<option value="<?php echo $webs[$y]->id; ?>"><?php echo $webs[$y]->nombre; ?></option>
									<?php } ?>
								</select>
							</td>
							<td><input type="text" id="anuncio_url_anuncio" name="anuncio_url_anuncio" required/></td>
							<td><button id="login_btn" name="login_btn" class="btn" type="submit"><i class="fas fa-plus"></i></button></td>
							<td></td>
						</tr>
					</form>
<?php
					$edit_id = 0;
					if (isset($_GET["id"])) {
						$edit_id = $_GET["id"];
					}

					if($anuncios != 0) {
						for($x = 0; $x < count($anuncios); $x++) {
							if ($edit_id == $anuncios[$x]->id) { //Editamos directamente en la fila: ?>
								<tr>
									<form method="POST" action="../../controladores/controlador_anuncio.php?op=2">
										<input type="hidden" id="anuncio_id" name="anuncio_id" value="<?php echo $anuncios[$x]->id; ?>"/>
										<td>
											<input type="text" id="anuncio_nombre" name="anuncio_nombre" value="<?php echo $anuncios[$x]->nombre; ?>" required/>
										</td>
										<td>
											<input type="text" id="anuncio_precio" name="anuncio_precio" value="<?php echo $anuncios[$x]->precio; ?>" required/>
										</td>
										<td>
											<input type="text" id="anuncio_precio_correcto_min" name="anuncio_precio_correcto_min" value="<?php echo $anuncios[$x]->precio_correcto_min; ?>" required/>
										</td>
										<td>
											<input type="text" id="anuncio_precio_correcto_max" name="anuncio_precio_correcto_max" value="<?php echo $anuncios[$x]->precio_correcto_max; ?>" required/>
										</td>
										<td>
											<select id="anuncio_categoria_id" name="anuncio_categoria_id">
												<?php for($y = 0; $y < count($categorias); $y++) { ?>
													<?php if($anuncios[$x]->categoria_id == $categorias[$y]->id) { ?>
														<option value="<?php echo $categorias[$y]->id; ?>" selected><?php echo $categorias[$y]->categoria; ?></option>
													<?php } else { ?>
														<option value="<?php echo $categorias[$y]->id; ?>"><?php echo $categorias[$y]->categoria; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
										<td>
											<input type="text" id="anuncio_url_foto" name="anuncio_url_foto" value="<?php echo $anuncios[$x]->url_foto; ?>"/>
										</td>
										<td>
											<select id="anuncio_web_id" name="anuncio_web_id">
												<?php for($y = 0; $y < count($webs); $y++) { ?>
													<?php if($anuncios[$x]->web_id == $webs[$y]->id) { ?>
														<option value="<?php echo $webs[$y]->id; ?>" selected><?php echo $webs[$y]->nombre; ?></option>
													<?php } else { ?>
														<option value="<?php echo $webs[$y]->id; ?>"><?php echo $webs[$y]->nombre; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
										<td>
											<input type="text" id="anuncio_url_anuncio" name="anuncio_url_anuncio" value="<?php echo $anuncios[$x]->url_anuncio; ?>" required/>
										</td>
										<td>
											<button type="submit" class="btn"><i class="fas fa-save"></i></button>
										</td>
									</form>
									<td>
										<button class="btn" onclick="document.location.href='mantenimiento_anuncios.php'"><i class="fas fa-times"></i></button>
									</td>
								</tr>
							<?php } else {
								echo "<tr>";
									echo "<td>" . $anuncios[$x]->nombre . "</td>";
									echo "<td>" . $anuncios[$x]->formatearPrecio() . "</td>";
									echo "<td>" . $anuncios[$x]->formatearPrecioCorrectoMin() . "</td>";
									echo "<td>" . $anuncios[$x]->formatearPrecioCorrectoMax() . "</td>";
									echo "<td>" . $anuncios[$x]->getCategoria() . "</td>";
									echo "<td><img src='" . $anuncios[$x]->url_foto . "' style='width:50%'></td>";
									echo "<td>" . $anuncios[$x]->getWeb() . "</td>";
									echo "<td><a href='" . $anuncios[$x]->url_anuncio . "' target='_blank'>Link anuncio</a></td>";
									?>
									<td><button class='btn' onclick="document.location.href='mantenimiento_anuncios.php?id=<?php echo $anuncios[$x]->id; ?>'"><i class='fas fa-pen'></i></button></td>
									<td><button class='btn' onclick="document.location.href='../../controladores/controlador_anuncio.php?op=3&id=<?php echo $anuncios[$x]->id; ?>'"><i class='fas fa-trash'></i></button></td>
								</tr>
<?php
							}
						}
					}
?>
				</table>
			</div>
		</div>
	</body>
</html>
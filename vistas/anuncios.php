<?php
	require_once("../modelos/clase_usuario.php");
	require_once("../modelos/clase_anuncio.php");
	require_once("../modelos/clase_categoria.php");

	session_start();

	if(isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];
	}
	
 	if(isset($_SESSION["anuncios"])) {
		$anuncios = unserialize($_SESSION["anuncios"]);
	}
	
 	if(isset($_SESSION["categorias"])) {
		$categorias = unserialize($_SESSION["categorias"]);
	}
	
 	if(isset($_SESSION["categoria_id"])) {
		$categoria_id = $_SESSION["categoria_id"];
	} else {
		$categoria_id = 0;
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="../css/estilos.css">
	</head>
	<body>
		<!-- MENU SUPERIOR -->
		<div class="menu">
			<a href="../controladores/controlador_anuncio.php?op=6"><b>WEB ANUNCIOS</b></a>
			<span>Anuncios</span>
			<div class="login-container">
				<form action="../controladores/controlador_usuario.php?op=2" method="POST">
					<input type="text" placeholder="Usuario..." id="login_usuario" name="login_usuario" required>
					<input type="password" placeholder="Contraseña..." id="login_contrasenna" name="login_contrasenna" required>
					<button id="registro_btn" name="registro_btn" type="submit" class="btn" onclick="document.location.href='registro.php'">Registrarse</button>
					<button id="login_btn" name="login_btn" class="btn" type="submit">Login</button>
				</form>
			</div>
		</div>
		
		<!-- CONTENIDO PÁGINA PÚBLICA -->
		<div class="contenido">
			<div>
				<label for="home_categoria_id">CATEGORIA: </label>
				<select id="home_categoria_id" name="home_categoria_id" onchange="seleccionarCategoria(this)">
					<option value="0">Todas</option>
					<?php for($y = 0; $y < count($categorias); $y++) { ?>
						<?php if($categoria_id == $categorias[$y]->id) { ?>
							<option value="<?php echo $categorias[$y]->id; ?>" selected><?php echo $categorias[$y]->categoria; ?></option>
						<?php } else { ?>
							<option value="<?php echo $categorias[$y]->id; ?>"><?php echo $categorias[$y]->categoria; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
			<?php
				for($x = 0; $x < count($anuncios); $x++) {

					$color = "amarillo";

					if($anuncios[$x]->precio < $anuncios[$x]->precio_correcto_min) {
						$color = "verde";
					} else if($anuncios[$x]->precio > $anuncios[$x]->precio_correcto_max) {
						$color = "rojo";
					}


					echo "<div class='card $color'>";
						echo "<img src='" . $anuncios[$x]->url_foto . "' style='width:100%'>";
						echo "<h2>" . $anuncios[$x]->nombre . "</h2>";
						echo "<p class='price'>" . $anuncios[$x]->formatearPrecio() . "€</p>";
						?>
						<p><button onclick="window.open('<?php echo $anuncios[$x]->url_anuncio; ?>','_blank')">Ir a la web del anuncio</button></p>
						<?php
					echo "</div>";

				}
			?>
		</div>

		<script type="text/javascript">
			function seleccionarCategoria(selectObject) {
				document.location.href='../controladores/controlador_anuncio.php?op=4&categoria_id=' + selectObject.value;
			}
		</script>
	</body>
</html>
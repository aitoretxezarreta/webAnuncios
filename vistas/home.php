<?php
	require_once("../modelos/clase_usuario.php");
	require_once("../modelos/clase_anuncio.php");

	session_start();

	if(isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];
	}

	if(isset($_SESSION["minCategorias"])) {
		$minCategorias =$_SESSION["minCategorias"];
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
			<span><b>WEB ANUNCIOS</b></span>
			<a href="../controladores/controlador_anuncio.php?op=4">Anuncios</a>
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
			<h3>Bienvenido a WEB ANUNCIOS, la web donde encontrarás...</h3>
			<h3>Categorías:</h3>
			<ul>
<?php
				for($x = 0; $x < count($minCategorias); $x++) {
					echo "<li><b>" . $minCategorias[$x]->getCategoria() . "</b>: <i>" . $minCategorias[$x]->nombre . "</i> desde " . $minCategorias[$x]->formatearPrecio() . "€</li>";
					echo "<br>";
				}
?>
			</ul>
		</div>
	</body>
</html>
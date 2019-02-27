<?php
	require("../../modelos/clase_usuario.php");

	session_start();

	if(isset($_SESSION["usuario"])) {
		$usuario = unserialize($_SESSION["usuario"]);
	} else {
		header("Location:../home.php");
	}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Datos Personales</title>
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css">
	</head>
	<body style="text-align: center;">
		<!-- MENU SUPERIOR -->
		<div class="menu">
			<a href="../../controladores/controlador_anuncio.php?op=5"><b>WEB ANUNCIOS</b></a>
			<a href="../../controladores/controlador_web.php?op=2">Webs</a>
			<a href="../../controladores/controlador_categoria.php?op=2">Categorías</a>
			<a href="../../controladores/controlador_usuario.php?op=4">Anuncios</a>
			<span>Datos personales</span>
			<a style="float: right;" href="../../controladores/controlador_usuario.php?op=5">LOGOUT</a>
		</div>
		
		<!-- CONTENIDO PÁGINA ADMINNISTRADOR -->
		<div class="contenido">
			<h3>DATOS PERSONALES</h3>
			<hr>
			<form action="../../controladores/controlador_usuario.php?op=3" method="POST">
				<label for="actualizar_usuario"><b>Usuario</b></label>
				<br>
				<input type="text" placeholder="Usaurio..." id="actualizar_usuario" name="actualizar_usuario" value="<?php echo $usuario->usuario ?>" readonly>
				<br><br>
				<label for="actualizar_contrasenna"><b>Contraseña</b></label>
				<br>
				<input type="text" placeholder="Contraseña..." id="actualizar_contrasenna" name="actualizar_contrasenna" value="<?php echo $usuario->pass ?>" required>
				<br><br>
				<button id="actualizar_usuario_btn" name="actualizar_usuario_btn" type="submit" class="btn">Actualizar</button>
			</form>
		</div>
	</body>
</html>
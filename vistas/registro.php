<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Registro</title>
		<link rel="stylesheet" type="text/css" href="../css/estilos.css">
	</head>
	<body>
		<!-- FORMULARIO DEL REGISTRO -->
		<div id="registro" class="popup">
			<form action="../controladores/controlador_usuario.php?op=1" method="POST" class="popup-contenido">
				<div class="titular">
					<h3>Registro</h3>
				</div>
				<div>
					<label for="registro_usuario"><b>Usuario</b></label>
					<br>
					<input type="text" placeholder="Usaurio..." id="registro_usuario" name="registro_usuario" required autofocus>
					<br><br>
					<label for="registro_contrasenna"><b>Contraseña</b></label>
					<br>
					<input type="text" placeholder="Contraseña..." id="registro_contrasenna" name="registro_contrasenna" required>
					<br>
				</div>
				<div>
					<button id="registro_btn" name="registro_btn" type="submit" class="btn">Registrarse</button>
					<button id="atras_btn" name="atras_btn" type="submit" class="btn" onclick="document.location.href='home.php'">Atras</button>
				</div>
			</form>
		</div>
	</body>
</html>
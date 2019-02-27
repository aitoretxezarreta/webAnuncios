<?php
	require_once("../modelos/clase_usuario.php");
	require_once("../modelos/clase_categoria.php");
	require_once("../modelos/clase_web.php");

	session_start();

	if(isset($_GET["op"])) {
		$op = $_GET["op"];
	}

	switch ($op) {
		case 1:	// REGISTRO

			$usuario = new CUsuario();

			$usuario->registrar($_POST["registro_usuario"], $_POST["registro_contrasenna"]);
			$_SESSION["usuario"] = serialize($usuario);

			$pag = "../vistas/adm/home.php";

			break;

		case 2:	// LOGIN

			$usuario = new CUsuario();

			$res = $usuario->login($_POST["login_usuario"], $_POST["login_contrasenna"]);
			$_SESSION["usuario"] = serialize($usuario);

			if($res == 1) {
				$pag = "controlador_anuncio.php?op=5";
			} else {
				$pag = "controlador_anuncio.php?op=6";
			}

			break;

		case 3:	// ACTUALIZAR USUARIO

			$usuario = unserialize($_SESSION["usuario"]);
			$usuario->cambiarPassword($_POST["actualizar_contrasenna"]);
			$_SESSION["usuario"] = serialize($usuario);

			$pag = "../vistas/adm/datos_personales.php";

			break;

		case 4:	// MOSTRAR ANUNCIOS

			$usuario = unserialize($_SESSION["usuario"]);
			$anuncios = $usuario->listarAnuncios();
			$_SESSION["usuario"] = serialize($usuario);
			$_SESSION["anuncios"] = serialize($anuncios);

			$categoria = new CCategoria();

			$categorias = $categoria->listarCategorias();
			$_SESSION["categorias"] = serialize($categorias);

			$web = new CWeb();

			$webs = $web->listarWebs();
			$_SESSION["webs"] = serialize($webs);

			$pag = "../vistas/adm/mantenimiento_anuncios.php";

			break;

		case 5:	// LOGOUT

			session_destroy();
			$pag = "controlador_anuncio.php?op=6";

			break;
	}

	header("Location:$pag");
?>
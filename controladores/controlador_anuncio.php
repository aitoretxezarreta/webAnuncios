<?php
	require_once("../modelos/clase_usuario.php");
	require_once("../modelos/clase_anuncio.php");

	session_start();

	if(isset($_GET["op"])) {
		$op = $_GET["op"];
	}

	switch ($op) {
		case 1:	// INSERT

			$anuncio = new CAnuncio();

			$usuario = unserialize($_SESSION["usuario"]);
			$usuario_id = $usuario->id;
			$_SESSION["usuario"] = serialize($usuario);

			$anuncio->insertar($_POST["anuncio_nombre"], $_POST["anuncio_precio"], $_POST["anuncio_precio_correcto_min"], $_POST["anuncio_precio_correcto_max"], $_POST["anuncio_categoria_id"], $_POST["anuncio_url_foto"], $_POST["anuncio_web_id"], $_POST["anuncio_url_anuncio"], $usuario_id);

			$pag = "controlador_usuario.php?op=4";

			break;
		case 2:	// UPDATE

			$anuncio = new CAnuncio();

			$usuario = unserialize($_SESSION["usuario"]);
			$usuario_id = $usuario->id;
			$_SESSION["usuario"] = serialize($usuario);

			$anuncio->actualizar($_POST["anuncio_nombre"], $_POST["anuncio_precio"], $_POST["anuncio_precio_correcto_min"], $_POST["anuncio_precio_correcto_max"], $_POST["anuncio_categoria_id"], $_POST["anuncio_url_foto"], $_POST["anuncio_web_id"], $_POST["anuncio_url_anuncio"], $usuario_id, $_POST["anuncio_id"]);

			$pag = "controlador_usuario.php?op=4";

			break;
		case 3:	// DELETE

			$anuncio = new CAnuncio();

			$anuncio->eliminar($_GET["id"]);

			$pag = "controlador_usuario.php?op=4";

			break;

		case 4:	// SELECT

			$anuncio = new CAnuncio();

			$anuncios = $anuncio->listarAnuncios($_GET["categoria_id"]);
			$_SESSION["anuncios"] = serialize($anuncios);
			$_SESSION["categoria_id"] = $_GET["categoria_id"];

			$pag = "../vistas/anuncios.php";

			break;

		case 5:	// RESUMEN ANUNCIOS

			$anuncio = new CAnuncio();

			$usuario = unserialize($_SESSION["usuario"]);
			$usuario_id = $usuario->id;
			$_SESSION["usuario"] = serialize($usuario);

			$totalAnuncios = $anuncio->total($usuario_id);
			$_SESSION["totalAnuncios"] = $totalAnuncios;

			$totalChollos = $anuncio->totalChollos($usuario_id);
			$_SESSION["totalChollos"] = $totalChollos;

			$totalCorrecto = $anuncio->totalCorrecto($usuario_id);
			$_SESSION["totalCorrecto"] = $totalCorrecto;
			
			$totalAlto = $anuncio->totalAlto($usuario_id);
			$_SESSION["totalAlto"] = $totalAlto;

			$pag = "../vistas/adm/home.php";

			break;

		case 6:	// LISTAR MINIMO PRECIO POR CATEGORIA

			$anuncio = new CAnuncio();

			$minCategorias = $anuncio->listarMinPrecioPorCategoria();
			$_SESSION["minCategorias"] = $minCategorias;

			$pag = "../vistas/home.php";

			break;
	}

	header("Location:$pag");
?>
<?php
	require_once("../modelos/clase_web.php");

	session_start();

	if(isset($_GET["op"])) {
		$op = $_GET["op"];
	}

	switch ($op) {
		case 1:	// INSERT

			$web = new CWeb();

			$web->insertarWeb($_POST["web_nombre"], $_POST["web_url"]);

			$pag = "controlador_web.php?op=2";

			break;

		case 2:	// SELECT

			$web = new CWeb();

			$webs = $web->listarWebs();
			$_SESSION["webs"] = serialize($webs);

			$pag = "../vistas/adm/mantenimiento_webs.php";

			break;
			break;

		case 3:	// UPDATE

			$web = new CWeb();

			$web->actualizarWeb($_POST["web_nombre"], $_POST["web_url"], $_POST["web_id"]);

			$pag = "controlador_web.php?op=2";

			break;

		case 4:	// DELETE

			$web = new CWeb();

			$web->eliminarWeb($_GET["id"]);

			$pag = "controlador_web.php?op=2";

			break;
	}

	header("Location:$pag");
?>
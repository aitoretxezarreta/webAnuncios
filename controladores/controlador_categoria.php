<?php
	require_once("../modelos/clase_categoria.php");

	session_start();

	if(isset($_GET["op"])) {
		$op = $_GET["op"];
	}

	switch ($op) {
		case 1:	// INSERT

			$categoria = new CCategoria();

			$dir_subida = 'C:/xampp/htdocs/ejer12-p2/img/categorias/';
			$nombre_fichero = $_POST["categoria_categoria"];
			$extension = strtolower(pathinfo(basename($_FILES['categoria_imagenUrl']['name']),PATHINFO_EXTENSION));

			$origen = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ· ";
			$remplazo = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn-_";

			$nombre_fichero = $nombre_fichero;
			$nombre_fichero = utf8_decode($nombre_fichero);
			$nombre_fichero = strtr($nombre_fichero, utf8_decode($origen), utf8_decode($remplazo));
			$nombre_fichero =  utf8_encode($nombre_fichero);

			$fichero = strtolower($nombre_fichero) . "." . $extension;

			$fichero_subido = $dir_subida . $fichero;

			if (move_uploaded_file($_FILES['categoria_imagenUrl']['tmp_name'], $fichero_subido)) {
				echo "El fichero es válido y se subió con éxito.\n";

				$categoria->insertarCategoria($_POST["categoria_categoria"], $fichero);
			} else {
				echo "¡Posible ataque de subida de ficheros!\n";
			}

			$pag = "controlador_categoria.php?op=2";

			break;

		case 2:	// SELECT

			$categoria = new CCategoria();

			$categorias = $categoria->listarCategorias();
			$_SESSION["categorias"] = serialize($categorias);

			$pag = "../vistas/adm/mantenimiento_categorias.php";

			break;

		case 3:	// UPDATE

			$categoria = new CCategoria();

			$dir_subida = 'C:/xampp/htdocs/ejer12-p2/img/categorias/';
			$nombre_fichero = $_POST["categoria_categoria"];
			$extension = strtolower(pathinfo(basename($_FILES['categoria_imagenUrl']['name']),PATHINFO_EXTENSION));

			$origen = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ· ";
			$remplazo = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn-_";

			$nombre_fichero = $nombre_fichero;
			$nombre_fichero = utf8_decode($nombre_fichero);
			$nombre_fichero = strtr($nombre_fichero, utf8_decode($origen), utf8_decode($remplazo));
			$nombre_fichero =  utf8_encode($nombre_fichero);

			$fichero = strtolower($nombre_fichero) . "." . $extension;

			$fichero_subido = $dir_subida . $fichero;

			if (move_uploaded_file($_FILES['categoria_imagenUrl']['tmp_name'], $fichero_subido)) {
				echo "El fichero es válido y se subió con éxito.\n";

				$categoria->actualizarCategoria($_POST["categoria_categoria"], $fichero, $_POST["categoria_id"]);
			} else {
				echo "¡Posible ataque de subida de ficheros!\n";
			}

			$pag = "controlador_categoria.php?op=2";

			break;

		case 4:	// DELETE

			$categoria = new CCategoria();

			$res = $categoria->eliminarCategoria($_GET["id"]);
			//echo $res;exit();

			$pag = "controlador_categoria.php?op=2";

			break;
	}

	header("Location:$pag");
?>
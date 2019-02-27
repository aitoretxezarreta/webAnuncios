<?php
require_once("clase_baseDatos.php");

class CCategoria extends CBaseDatos {

	/*--------------- ATRIBUTOS ---------------*/
	public $id;
	public $categoria;
	public $imagen_url;

	/*--------------- FUNCIONES ---------------*/
	public function setID($id) {
		$this->id = $id;
	}

	public function setCategoria($categoria) {
		$this->categoria = $categoria;
	}

	public function setImagen_url($imagen_url) {
		$this->imagen_url = $imagen_url;
	}

	public function insertarCategoria($categoria, $imagen_url) {
		//Inserta un nuevo anuncio en la BBDD

		$this->id = $this->consultaInsert("tbl_categorias", "categoria, imagen_url", "'$categoria', '$imagen_url'");
	}

	public function listarCategorias() {

		$this->consultaSelect("*", "tbl_categorias");

		if ($this->registros->num_rows > 0) {

			while($row = $this->registros->fetch_assoc()) {
				$categoria = new CCategoria();

				$categoria->setID($row["id"]);
				$categoria->setCategoria($row["categoria"]);
				$categoria->setImagen_url($row["imagen_url"]);

				$respuesta[] = $categoria;
			}
		} else {
			$respuesta = 0;
		}

		return $respuesta;
	}

	public function actualizarCategoria($categoria, $imagen_url, $id) {
		//Actualizar un anuncio en la BBDD

		$this->consultaUpdate("tbl_categorias", "categoria='$categoria', imagen_url='$imagen_url'", "WHERE id='$id'");
	}

	public function eliminarCategoria($id) {
		//Actualizar un anuncio en la BBDD
		
		//$this->consultaDelete("tbl_categorias", "WHERE id='$id'");

		$sqls[] = "DELETE FROM tbl_anuncios WHERE categoria_id=$id";
		$sqls[] = "DELETE FROM tbl_categorias WHERE id=$id";

		$this->transaccion($sqls);
	}
}
?>
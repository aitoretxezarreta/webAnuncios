<?php
require_once("clase_baseDatos.php");

class CWeb extends CBaseDatos {

	/*--------------- ATRIBUTOS ---------------*/
	public $id;
	public $nombre;
	public $url;

	/*--------------- FUNCIONES ---------------*/
	public function setID($id) {
		$this->id = $id;
	}

	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	public function setUrl($url) {
		$this->url = $url;
	}

	public function insertarWeb($nombre, $url) {
		//Inserta un nuevo anuncio en la BBDD

		$this->id = $this->consultaInsert("tbl_webs", "nombre, url", "'$nombre', '$url'");
	}

	public function listarWebs() {

		$this->consultaSelect("*", "tbl_webs");

		if ($this->registros->num_rows > 0) {

			while($row = $this->registros->fetch_assoc()) {
				$web = new CWeb();

				$web->setID($row["id"]);
				$web->setNombre($row["nombre"]);
				$web->setUrl($row["url"]);

				$respuesta[] = $web;
			}
		} else {
			$respuesta = 0;
		}

		return $respuesta;
	}

	public function actualizarWeb($nombre, $url, $id) {
		//Actualizar un anuncio en la BBDD

		$this->consultaUpdate("tbl_webs", "nombre='$nombre', url='$url'", "WHERE id='$id'");
	}

	public function eliminarWeb($id) {
		//Actualizar un anuncio en la BBDD
		//$this->consultaDelete("tbl_webs", "WHERE id='$id'");

		$sqls[] = "DELETE FROM tbl_anuncios WHERE web_id=$id";
		$sqls[] = "DELETE FROM tbl_webs WHERE id=$id";

		$this->transaccion($sqls);
	}
}
?>
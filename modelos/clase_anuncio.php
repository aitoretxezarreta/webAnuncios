<?php
require_once("clase_baseDatos.php");

class CAnuncio extends CBaseDatos {

	/*--------------- ATRIBUTOS ---------------*/
	public $id;
	public $nombre;
	public $precio;
	public $precio_correcto_min;
	public $precio_correcto_max;
	public $categoria_id;
	public $url_foto;
	public $web_id;
	public $url_anuncio;
	public $usuario_id;

	/*--------------- FUNCIONES ---------------*/
	public function setID($id) {
		$this->id = $id;
	}

	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	public function setPrecio($precio) {
		$this->precio = $precio;
	}

	public function setPrecioCorrectoMin($precio_correcto_min) {
		$this->precio_correcto_min = $precio_correcto_min;
	}

	public function setPrecioCorrectoMax($precio_correcto_max) {
		$this->precio_correcto_max = $precio_correcto_max;
	}

	public function setCategoriaId($categoria_id) {
		$this->categoria_id = $categoria_id;
	}

	public function setUrlFoto($url_foto) {
		$this->url_foto = $url_foto;
	}

	public function setWebId($web_id) {
		$this->web_id = $web_id;
	}

	public function setWebUrl($url_anuncio) {
		$this->url_anuncio = $url_anuncio;
	}

	public function setUsuarioId($usuario_id) {
		$this->usuario_id = $usuario_id;
	}

	public function getCategoria() {
		$this->consultaSelect("*", "tbl_categorias", "WHERE id='$this->categoria_id'");

		if ($this->registros->num_rows > 0) {
			while($row = $this->registros->fetch_assoc()) {
				$respuesta = $row["categoria"];
			}
		}

		return $respuesta;
	}

	public function getWeb() {
		$this->consultaSelect("*", "tbl_webs", "WHERE id='$this->web_id'");

		if ($this->registros->num_rows > 0) {
			while($row = $this->registros->fetch_assoc()) {
				$respuesta = $row["nombre"];
			}
		}

		return $respuesta;
	}

	public function listarAnuncios($categoria_id = 0) {

		$condicion = "ORDER BY ID DESC";

		if($categoria_id != 0) {
			$condicion = "WHERE categoria_id='$categoria_id' ORDER BY ID DESC";
		}

		$this->consultaSelect("*", "tbl_anuncios", $condicion);

		if ($this->registros->num_rows > 0) {

			while($row = $this->registros->fetch_assoc()) {
				$anuncio = new CAnuncio();

				$anuncio->setID($row["id"]);
				$anuncio->setNombre($row["nombre"]);
				$anuncio->setPrecio($row["precio"]);
				$anuncio->setPrecioCorrectoMin($row["precio_correcto_min"]);
				$anuncio->setPrecioCorrectoMax($row["precio_correcto_max"]);
				$anuncio->setCategoriaId($row["categoria_id"]);
				$anuncio->setUrlFoto($row["url_foto"]);
				$anuncio->setWebId($row["web_id"]);
				$anuncio->setWebUrl($row["url_anuncio"]);
				$anuncio->setUsuarioId($row["usuario_id"]);

				$respuesta[] = $anuncio;
			}
		} else {
			$respuesta = 0;
		}

		return $respuesta;
	}

	public function listarAnuncios_sw() {
		$lista = array();
		try {
			$this->consultaSelect("*", "tbl_anuncios");

			if ($this->registros->num_rows > 0) {
				
				while ($fila = $this->registros->fetch_assoc()){
					array_push($lista, $fila);
				}
			}
		} catch (Exception $e) {
			throw new Exception($e);
		}
		return $lista;
	}

	public function insertar($nombre,$precio,$precio_correcto_min,$precio_correcto_max,$categoria_id,$url_foto,$web_id,$url_anuncio,$usuario_id) {
		//Inserta un nuevo anuncio en la BBDD

		$this->id = $this->consultaInsert("tbl_anuncios", "nombre, precio, precio_correcto_min, precio_correcto_max, categoria_id, url_foto, web_id, url_anuncio,usuario_id", "'$nombre', $precio, $precio_correcto_min, $precio_correcto_max, $categoria_id, '$url_foto', $web_id, '$url_anuncio', $usuario_id");
	}

	public function actualizar($nombre,$precio,$precio_correcto_min,$precio_correcto_max,$categoria_id,$url_foto,$web_id,$url_anuncio,$usuario_id, $id) {
		//Actualizar un anuncio en la BBDD

		$this->consultaUpdate("tbl_anuncios", "nombre='$nombre',precio='$precio',precio_correcto_min='$precio_correcto_min',precio_correcto_max='$precio_correcto_max',categoria_id='$categoria_id',url_foto='$url_foto',web_id='$web_id',url_anuncio='$url_anuncio',usuario_id='$usuario_id'", "WHERE id='$id'");
	}

	public function eliminar($id) {
		//Actualizar un anuncio en la BBDD
		$this->consultaDelete("tbl_anuncios", "WHERE id='$id'");
	}

	public function total($usuario_id) {
		//Actualizar un anuncio en la BBDD
		return $this->consultaCount("tbl_anuncios", "id", "WHERE usuario_id=$usuario_id");
	}

	public function totalChollos($usuario_id) {
		//Actualizar un anuncio en la BBDD
		return $this->consultaCount("tbl_anuncios", "id", "WHERE usuario_id=$usuario_id AND precio<precio_correcto_min");
	}

	public function totalCorrecto($usuario_id) {
		//Actualizar un anuncio en la BBDD
		return $this->consultaCount("tbl_anuncios", "id", "WHERE usuario_id=$usuario_id AND precio>=precio_correcto_min AND precio<=precio_correcto_max");
	}

	public function totalAlto($usuario_id) {
		//Actualizar un anuncio en la BBDD
		return $this->consultaCount("tbl_anuncios", "id", "WHERE usuario_id=$usuario_id AND precio>precio_correcto_max");
	}

	public function listarMinPrecioPorCategoria() {

		$this->consultaSelect("nombre, precio, categoria_id, MIN(precio)", "tbl_anuncios", "GROUP BY categoria_id");

		if ($this->registros->num_rows > 0) {

			while($row = $this->registros->fetch_assoc()) {
				$anuncio = new CAnuncio();

				$anuncio->setNombre($row["nombre"]);
				$anuncio->setPrecio($row["precio"]);
				$anuncio->setCategoriaId($row["categoria_id"]);

				$respuesta[] = $anuncio;
			}
		} else {
			$respuesta = 0;
		}

		return $respuesta;
	}

	public function formatearPrecio() {
		return number_format($this->precio,2,",",".");
	}

	public function formatearPrecioCorrectoMin() {
		return number_format($this->precio_correcto_min,2,",",".");
	}

	public function formatearPrecioCorrectoMax() {
		return number_format($this->precio_correcto_max,2,",",".");
	}
}
?>
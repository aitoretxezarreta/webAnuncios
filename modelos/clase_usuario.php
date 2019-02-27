<?php
require_once("clase_baseDatos.php");
require_once("clase_anuncio.php");

class CUsuario extends CBaseDatos {

	/*--------------- ATRIBUTOS ---------------*/
	public $id;
	public $usuario;
	private $pass;
	public $token;
	public $token_expire;

	/*--------------- FUNCIONES ---------------*/
	/*
	+ mostrarAnuncios(): array(CAnuncio)
	Devuelve los anuncios que ha creado el usuario*/

	public function registrar($usuario, $pass) {
		//Inserta un nuevo usuario en la BBDD

		$this->usuario = $usuario;
		$this->pass = $pass;

		$this->id = $this->consultaInsert("tbl_usuarios", "nombre, password", "'$this->usuario', '$this->pass'");
	}

	public function login($usuario, $pass) {
		//Comprueba si usuario y el password son correctos, OK => 1, X => 0

		$respuesta = 0;

		$this->consultaSelect("*", "tbl_usuarios", "WHERE nombre='$usuario' AND password='$pass'");

		if($this->registros->num_rows > 0) {
			$respuesta = 1;

			while($row = $this->registros->fetch_assoc()) {
				$this->id = $row["id"];
				$this->usuario = $row["nombre"];
				//$this->pass = $row["password"];
				$this->token = $row["token"];
				$this->token_expire = $row["token_expire"];
			}
		}

		return $respuesta;
	}

	public function cargarUsuario($id) {
		$respuesta = 0;

		$this->consultaSelect("*", "tbl_usuarios", "WHERE id='$id'");

		if($this->registros->num_rows > 0) {
			$respuesta = 1;

			while($row = $this->registros->fetch_assoc()) {
				$this->id = $row["id"];
				$this->usuario = $row["nombre"];
				$this->token = $row["token"];
				$this->token_expire = $row["token_expire"];
			}

			
		}

		return $respuesta;
	}

	public function sw_validar($usuario,$pass,$tiempoExpirarToken) {
		$respuesta = $this->login($usuario,$pass);
		if ($respuesta>0) {
			//Validación correcta, generamos el token:

			$fecha = new DateTime();
			$timestamp = $fecha->getTimestamp();

			$token_expire = $timestamp + $tiempoExpirarToken;

			$this->token = $this->generarToken(50);
			$this->consultaUpdate("tbl_usuarios", "token='$this->token', token_expire='$token_expire'", "WHERE id='$this->id'");
		}

		return $respuesta;
	}

	public function cambiarPassword($pass) {
		// Actualiza el valor del password por el password que se le pasa por parámetro

		$this->pass = $pass;

		$this->consultaUpdate("tbl_usuarios", "password='$this->pass'", "WHERE id='$this->id'");
	}

	public function listarAnuncios() {

		$this->consultaSelect("*", "tbl_anuncios", "WHERE usuario_id=$this->id");

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

	function generarToken($longitud) {
		return bin2hex(random_bytes($longitud/2));
	}
}
?>
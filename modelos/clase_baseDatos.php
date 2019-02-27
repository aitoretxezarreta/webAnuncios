<?php
class CBaseDatos {

	/*--------------- ATRIBUTOS ---------------*/
	private const HOST = 'localhost';
	private const USER = 'root';
	private const PASS = '';
	private const BBDD = 'bbdd_anuncios';
	private $conn;

	protected $registros;

	/*--------------- FUNCIONES ---------------*/
	private function abrirConexion() {
		// Abre la conexión con la base de datos
		$this->conn = new mysqli(self::HOST, self::USER, self::PASS, self::BBDD);

		if($this->conn->connect_error) {
			die("Error de conexión: " . $this->conn->connect_error);
		}

		$this->conn->set_charset('utf8');	
	}

	private function cerrarConexion() {
		// Cierra la conexión con la base de datos
		$this->conn->close();
	}

	protected function consultaInsert($tabla, $campos, $valores) {
		$respuesta = 0;

		$this->abrirConexion();

		$sql = "INSERT INTO $tabla ($campos) VALUES ($valores)";
		$this->conn->query($sql);

		$respuesta = $this->conn->insert_id;

		$this->cerrarConexion();

		return $respuesta;
	}

	protected function consultaSelect($campos, $tabla, $condiciones = '') {
		$this->abrirConexion();

		$sql = "SELECT $campos FROM $tabla $condiciones";

		$this->registros = $this->conn->query($sql);

		$this->cerrarConexion();
	}

	protected function consultaUpdate($tabla, $campos, $condiciones = '') {
		$this->abrirConexion();

		$sql = "UPDATE $tabla SET $campos $condiciones";
		$this->conn->query($sql);

		$this->cerrarConexion();
	}

	protected function consultaDelete($tabla, $condiciones) {
		$this->abrirConexion();

		$sql = "DELETE FROM $tabla $condiciones";
		$this->conn->query($sql);

		$this->cerrarConexion();
	}

	protected function consultaCount($tabla, $campo, $condiciones = '') {
		$this->abrirConexion();

		$sql = "SELECT COUNT($campo) total FROM $tabla $condiciones";
		$fila = $this->conn->query($sql)->fetch_assoc();

		$this->cerrarConexion();

		return $fila['total'];
	}

	protected function transaccion($sqls) {
		$respuesta = 0;

		$this->abrirConexion();

		try {
			$this->conn->begin_transaction();

			for($i = 0; $i < count($sqls); $i++) {
				$this->conn->query($sqls[$i]);
			}

			$this->conn->commit();

			$respuesta = 1;
		} catch (Exception $e) {
			$this->conn->rollback();
		}

		$this->cerrarConexion();

		return $respuesta;
	}
}
?>
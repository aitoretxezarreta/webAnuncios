<?php
header("Content-Type: application/json; charset=UTF-8");

include("../modelos/clase_anuncio.php");
include("../modelos/clase_usuario.php");

try {
	if (!$_POST["token"]) {
		$respuesta = array('res'=>'-1','info'=>'Falta token');
	} else if (!$_POST["id"]) {
		$respuesta = array('res'=>'-1','info'=>'Falta el ID del usuario');
	} else {
		$token = $_POST["token"];
		$id = $_POST["id"];

		$obj_usuario = new CUsuario();
		$obj_usuario->cargarUsuario($id);

		$fecha = new DateTime();
		$timestamp = $fecha->getTimestamp();

		if($token != $obj_usuario->token) {
			$respuesta = array('res'=>'-1','info'=>'Validación incorrecta');
		} else if ($obj_usuario->token_expire < $timestamp) {
			$respuesta = array('res'=>'-2','info'=>'Token expirado');
		} else {
			$anuncio = new CAnuncio();
			$respuesta = array('res'=>'1','info'=>$anuncio->listarAnuncios_sw());
		}
	}

	$status = 200;
} catch(Exception $e) {

	$respuesta = array('res'=>'-1','info'=>$e);
	$status = 500;
}

http_response_code($status);
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>
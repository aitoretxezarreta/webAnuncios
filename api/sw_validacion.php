<?php
header("Content-Type: application/json; charset=UTF-8");

include("../modelos/clase_usuario.php");

try {
	if (!$_POST["usuario"]) {
		$respuesta = array('res'=>'-1','info'=>'Falta usuario');
	} else if (!$_POST["pass"]) {
		$respuesta = array('res'=>'-1','info'=>'Falta contraseña');
	} else {
		$usuario = $_POST["usuario"];
		$pass = $_POST["pass"];

		$obj_usuario = new CUsuario();
		$token = $obj_usuario->sw_validar($usuario,$pass,60);
		if($token == 0) {
			$respuesta = array('res'=>'-1','info'=>'Validación incorrecta');
		} else {
			$array_token = array('token'=>$obj_usuario->token);
			$respuesta = array('res'=>'0','info'=>$array_token);
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
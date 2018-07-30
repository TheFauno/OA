<?php

namespace App\Login;

use \Firebase\JWT\JWT;

class Login{

	private $db;
	private $secret;

	public function __construct($db){
		$this->db = $db;
		$this->secret = 'asudj9a8d89a7hs89dja9s';
	}

	public function doLogin($rut, $password){
		$query = $this->db->prepare('SELECT rut, CONCAT(nombre, \' \', apaterno, \' \', amaterno) AS nombre, password FROM jefe_carrera WHERE rut = :rut');
		$query -> bindParam(':rut', $rut);

		if( $query -> execute() ){
			$user = $query->fetch();
			/* El usuario existe en la base de datos */
			if($user){
				return $this->verificarPassword($password, $user);
			}else{
				return array(
					'status' => 'error',
					'message' => 'Usuario o password incorrectos'
				);
			}
		}else
			return array(
				'status' => 'error',
				'message' => 'Ocurrió un error inesperado'
			);
	}

	public function doLogout($headers){
		$token = explode(" ", $headers['HTTP_AUTHORIZATION'][0]);
        $decoded = JWT::decode($token[1], $this->secret, array('HS256'));

		//Update token
		/*
        $query = $this->db->prepare('	UPDATE usuario SET TOKEN = null
										WHERE UID = :uid');
		$query->bindParam(':uid', $decoded->uid);

        if( $query->execute() ){
			return array(
				"status" => "success"
			);
		}else{
			return array(
				'status' => 'error',
				'message' => 'Ocurrió un error al cerrar sesión'
			);
		}*/
		return array(
			"status" => "success"
		);
	}

	private function verificarPassword($password, $user){
		if(password_verify($password, $user['password'])){
	        $usuario['iat'] = time();
            $usuario['exp'] = time() + (12 * 60 * 60);
            //$usuario['type'] = intval($user['user_profile']);
	        //$usuario['username'] = $user['username'];
	        $usuario['rut'] = $user['rut'];

			$jwt = JWT::encode($usuario, $this->secret);
			return array(
				"status" => "success",
				"message" => "bienvenido",
				"token" => $jwt
			);
			// guardar token en la bd
			/*
			$query = $this->db->prepare('UPDATE user SET token = :token
										 WHERE id = :id');
			$query->bindParam(':token', $jwt);
			$query->bindParam(':id', $user['id']);

			if( $query->execute() ){
				return array(
					"status" => "success",
					"message" => "bienvenido",
					"token" => $jwt
				);
			}else{
				return array(
					'status' => 'error',
					'message' => 'ocurrió un error al generar el token'
				);
			}
			*/
		}else
			return array(
				'status' => 'error',
				'message' => 'usuario o password incorrectos'
			);
	}	

}
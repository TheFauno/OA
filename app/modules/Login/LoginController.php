<?php

namespace App\Login;

use App\Login\Login;

class LoginController{

	private $login;

	public function __construct($db){
		$this->login = new Login($db);
	}

	public function doLogin($credenciales){		
		if(!isset($credenciales['rut']) || !isset($credenciales['password'])){
			return array(
				'status' 	=> 'error', 
				'message' 	=> 'usuario o contraseña incorrectos'
			);
		}

		$rut = filter_var($credenciales['rut'], FILTER_SANITIZE_STRING);
    	$password = filter_var($credenciales['password'], FILTER_SANITIZE_STRING);

		return $this->login->doLogin($rut, $password);
	}

	public function doLogout($headers){		
		return $this->login->doLogout($headers);
	}

}
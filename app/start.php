<?php
require __DIR__ . '/vendor/autoload.php';

$config['displayErrorDetails'] = true;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "";	
$config['db']['dbname'] = "oirs_ambiental";

//Instancia de Slim
$app = new Slim\App(["settings" => $config]);
$container = $app->getContainer();

//Configuración de la BD con PDO dentro del container
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    try{
	    $pdo = new PDO("mysql:host=" . $db['host'] . ";
				    	dbname=" . $db['dbname'], 
				    	$db['user'], 
				    	$db['pass'],
				    	array('charset'=>'utf8'));

		$pdo->query("SET CHARACTER SET utf8");
		$pdo->query("SET lc_time_names = 'es_ES'");
	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);    	
    }
    catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
    return $pdo;
};
    require 'routes.php';

$app->run();
<?php

use App\Comment\CommentController;

$app->get('/area', function($request, $response, $args){
	try {
        $cc = new CommentController($this->db);
        $data = $cc->getAllArea();
    	$response->write(utf8_encode(json_encode($data)));
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
});

$app->get('/tipo_comentario', function($request, $response, $args){
    try {
        $cc = new CommentController($this->db);
        $data = $cc->getAllCommentTypes();
    	$response->write(utf8_encode(json_encode($data)));
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
});

$app->get('/form', function($request, $response, $args){
	try {
        $cc = new CommentController($this->db);
        $data1 = $cc->getAllArea();
		$data2 = $cc->getAllCommentTypes();
		$data = array("areas" => $data1, "tipos_comentario" => $data2);
    	$response->write(utf8_encode(json_encode($data)));
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
});

$app->post('/', function($request, $response, $args){
    try {
        $cc = new CommentController($this->db);
        $body = $request->getParsedBody();
        $data = $cc->insertComment($body);
    	$response->write(utf8_encode(json_encode($data)));
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
});
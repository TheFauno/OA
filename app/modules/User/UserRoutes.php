<?php

use App\User\UserController;

$app->group('/users', function() use ($app){

    $this->post('', function($request, $response, $args){
        $body = $request->getParsedBody();
        $user_controller = new UserController($this->get('db'));
        $data = $user_controller->createUser($body);
        return $response->withJson($data);
    });

    $this->get('', function($request, $response, $args){
        $user_controller = new UserController($this->get('db'));
        $users = $user_controller->getUsers();
        return $response->withJson($users);
    });

    $this->get('/{id}', function($request, $response, $args){
        $user_controller = new UserController($this->get('db'));
        $user = $user_controller->getUser($args['id']);
        return $response->withJson($user);
    });

    $this->put('/{id}', function($request, $response, $args){
        $body = $request->getParsedBody();
        $body['id'] = $args['id'];
        $user_controller = new UserController($this->get('db'));
        $data = $user_controller->updateUser($body);
        return $response->withJson($data);
    });

    $this->delete('/{id}', function($request, $response, $args){
        $user_controller = new UserController($this->get('db'));
        $data = $user_controller->deleteUser($args['id']);
        return $response->withJson($data);
    });

});
<?php

namespace App\User;

use App\User\User;

class UserController{

    private $user;

    public function __construct($db){
        $this->user = new User($db);
    }

    public function createUser($data){
        $this->user->username = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $this->user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->user->user_profile = filter_var($data['user_profile'], FILTER_SANITIZE_STRING);
        $exist = $this->user->getUserByUsername();
        $status = array();
        if (!$exist){
            $status = $this->user->createUser();
        } else {
            $status = array('status' => 409);
        }
        return $status; 
    }

    public function getUsers(){
        $users = $this->user->getUsers();
        for ($i=0; $i < count($users); $i++){
            $users[$i]['user_profile'] = intval($users[$i]['user_profile']);
        }
        return $users;
    }

    public function getUser($id){
        $this->user->id = filter_var($id, FILTER_SANITIZE_STRING);
        $user = $this->user->getUser(); 
        $user['user_profile'] = intval($user['user_profile']);
        return $user;
    }

    public function updateUser($data){
        $this->user->id = filter_var($data['id'], FILTER_SANITIZE_STRING);
        $this->user->username = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $this->user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->user->user_profile = filter_var($data['user_profile'], FILTER_SANITIZE_STRING);

        return $this->user->updateUser();
    }

    public function deleteUser($id){
        $this->user->id = filter_var($id, FILTER_SANITIZE_STRING);
        return $this->user->deleteUser();
    }

}
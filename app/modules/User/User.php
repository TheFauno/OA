<?php

namespace App\User;

class User{

    private $db;
    public $id;
    public $username;
    public $user_profile;

    public function __construct($db){
        $this->db = $db;
    }

    public function createUser(){

        $status = "";
        $query = 'INSERT INTO user (username, password, user_profile)
        VALUES(:username, :password, :user_profile)';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->bindParam(':username', $this->username);
        $prepared_statement->bindParam(':password', $this->password);
        $prepared_statement->bindParam(':user_profile', $this->user_profile);
        if ($prepared_statement->execute()){
            $this->id = $this->db->lastInsertId();
            $status = array('status' => 200, 'id' => $this->id);
        } else{
            $status = array('status' => 400);
        }
        return $status;
    }

    public function getUsers(){
        $users = array();
        $status = '';
        $query = 'SELECT id, username, user_profile FROM user';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->execute();
        return $prepared_statement->fetchAll();
    }

    public function getUser(){
        $query = 'SELECT id, username, password, user_profile FROM user WHERE id = :id';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->bindParam(':id', $this->id);
        $prepared_statement->execute();
        return $prepared_statement->fetch();
    }

    public function getUserByUsername(){
        $query = 'SELECT username FROM user WHERE username = :username';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->bindParam(':username', $this->username);
        $prepared_statement->execute();
        return $prepared_statement->fetch();
    }

    public function updateUser(){

        $status = "";
        $query = 'UPDATE user SET password = :password, user_profile = :user_profile WHERE id = :id';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->bindParam(':password', $this->password);
        $prepared_statement->bindParam(':user_profile', $this->user_profile);
        $prepared_statement->bindParam(':id', $this->id);
        if ($prepared_statement->execute()){
            $status = array('status' => 200, 'id' => $this->id);
        } else{
            $status = array('status' => 400);
        }
        return $status;
    }

    public function deleteUser(){
        $status = '';
        $query = 'DELETE FROM user WHERE id = :id';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->bindParam(':id', $this->id);
        if ($prepared_statement->execute()){
            $status = array('status' => 200, 'id' => $this->id);
        } else{
            $status = array('status' => 204);
        }
        return $status;
    }
}
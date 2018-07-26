<?php

namespace App\Comment;

class Area{

    private $db;
    public $id;
    public $name;

    public function __construct($db){
        $this->db = $db;
    }

    public function getAllArea(){
        $query = 'SELECT * FROM oirs_ambiental.area';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->execute();
        $areas = $prepared_statement->fetchAll();
        return $areas;
    }
}
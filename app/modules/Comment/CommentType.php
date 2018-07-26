<?php

namespace App\Comment;

class CommentType{

    private $db;
    public $id;
    public $name;

    public function __construct($db){
        $this->db = $db;
    }

    public function getAllCommentTypes(){
        $query = 'SELECT * FROM oirs_ambiental.tipo_comentario';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->execute();
        $comment_types = $prepared_statement->fetchAll();
        return $comment_types;
    }
}
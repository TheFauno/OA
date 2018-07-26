<?php

namespace App\Comment;

class Comment{

    private $db;
    public $id;
    public $tipo_comentario;
    public $area;
    public $comentario;
    public $rut;


    public function __construct($db){
        $this->db = $db;
    }

    public function insertComment(){
        $query = 'INSERT INTO comentario (tipo_comentario, area, comentario, estudiante_rut) 
                    VALUES(:tipo_comentario, :area, :comentario, :rut)';
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->bindParam(':tipo_comentario', $this->tipo_comentario);
        $prepared_statement->bindParam(':area', $this->area);
        $prepared_statement->bindParam(':comentario', $this->comentario);
        $prepared_statement->bindParam(':rut', $this->rut);
        $status = $prepared_statement->execute();
        return $status;
    }

    public function IsValidStudent(){
        $query = "SELECT * FROM estudiante WHERE rut = :rut AND vigente = 'S'";
        $prepared_statement = $this->db->prepare($query);
        $prepared_statement->bindParam(':rut', $this->rut);
        $prepared_statement->execute();
        return $prepared_statement->fetch();
    }
}
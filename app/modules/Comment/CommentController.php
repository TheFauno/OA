<?php

namespace App\Comment;

use App\Comment\Area;
use App\Comment\CommentType;
use App\Comment\Comment;

class CommentController{

    private $area;
    private $commentType;

    public function __construct($db){
        $this->area = new Area($db);
        $this->commentType = new CommentType($db);
        $this->comment = new Comment($db);
    }
   
    public function getAllArea(){
        $areas = $this->area->getAllArea();
        return $areas;
    }

    public function getAllCommentTypes(){
        $commentTypes = $this->commentType->getAllCommentTypes();
        return $commentTypes;
    }

    public function insertComment($body){
        $respuesta = array(
            'estado' => 'Error',
            'mensaje' => 'Tu RUT no esta registrado');
        $body['rut'] = FILTER_VAR($body['rut'], FILTER_SANITIZE_STRING);
        $body['rut'] = str_replace('.', '', $body['rut']);
        $rut = explode('-', $body['rut']);
        //verifica el rut
        $this->comment->rut = intval($rut[0]);
        $valido = $this->validaRUT();
        if ($valido){
            $body['area'] = FILTER_VAR($body['area'], FILTER_SANITIZE_STRING);
            $body['tipo_comentario'] = FILTER_VAR($body['tipo_comentario'], FILTER_SANITIZE_STRING);
            $body['comentario'] = FILTER_VAR($body['comentario'], FILTER_SANITIZE_STRING);
            $this->comment->area = $body['area'];
            $this->comment->tipo_comentario = $body['tipo_comentario'];
            $this->comment->comentario = $body['comentario'];
            $status = $this->comment->insertComment();
            if ($status > 0){
                $respuesta['estado'] = 'Success';
                $respuesta['mensaje'] = 'El comentario fue registrado';
            }
        }

        return $respuesta;
    }

    private function validaRUT(){
        $valido = false;
        if ($this->comment->IsValidStudent()){
            $valido = true;
        }
        return $valido;
    }
}
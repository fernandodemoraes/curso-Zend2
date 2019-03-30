<?php

namespace Livraria\Model;

/**
 * Class Categoria
 *
 * @package Livraria\Model
 */
class Categoria
{
    /**
     * Id
     *
     * @var
     */
    public $id;

    /**
     * Nome
     *
     * @var
     */
    public $nome;

    /**
     * @param $data
     */
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
    }
}
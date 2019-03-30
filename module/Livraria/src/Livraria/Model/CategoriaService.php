<?php

namespace Livraria\Model;

/**
 * Class CategoriaService.
 *
 * @package Livraria\Model
 */
class CategoriaService
{
    /**
     * @var CategoriaTable
     */
    protected $categoriaTable;

    /**
     * CategoriaService constructor.
     *
     * @param CategoriaTable $table
     */
    public function __construct(CategoriaTable $table)
    {
        $this->categoriaTable = $table;
    }

    /**
     * Fechall
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fechAll() {
        $resultSet = $this->categoriaTable->select();

        return $resultSet;
    }
}
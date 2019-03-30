<?php

namespace Livraria\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class CategoriaTable
 *
 * @package Livraria\Model
 */
class CategoriaTable extends AbstractTableGateway
{
    protected $table = 'categorias';

    /**
     * CategoriaTable constructor.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Categoria());
        $this->initialize();
    }
}
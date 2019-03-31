<?php

namespace LivrariaAdmin\Controller;

use Livraria\Entity\Categoria;

class CategoriasController extends AbstractActionCrudController
{
    /**
     * CategoriasController constructor.
     */
    public function __construct()
    {
        $this->entity     = Categoria::class;
        $this->form       = \LivrariaAdmin\Form\Categoria::class;
        $this->service    = \Livraria\Service\Categoria::class;
        $this->controller = 'categorias';
        $this->route      = 'livraria-admin';
    }
}
<?php

namespace LivrariaAdmin\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Form;

class Categoria extends Form
{
    /**
     * Categoria constructor.
     *
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('categoria');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new CategoriaFilter());

        $this->add([
            'name' => 'id',
            'type' => 'Hidden',
        ]);

        $this->add([
            'name' => 'nome',
            'type' => 'Text',
            'options' => [
                'label' => 'Nome',
            ],
            'attributes' => [
                'id' => 'nome',
                'placeholder' => 'Informe a categoria',
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'value' => 'Salvar',
                'class' => 'btn-primary'
            ]
        ]);
    }
}
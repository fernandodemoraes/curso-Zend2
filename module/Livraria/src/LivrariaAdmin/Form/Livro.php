<?php

namespace LivrariaAdmin\Form;

use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

/**
 * Class Livro
 *
 * @package LivrariaAdmin\Form
 */
class Livro extends Form
{
    /**
     * Categorias
     * @var
     */
    protected $categorias;

    /**
     * Livro constructor.
     *
     * @param null $name
     * @param array $categorias
     */
    public function __construct($name = null, array $categorias)
    {
        parent::__construct('livro');
        $this->categorias = $categorias;

        $this->setAttribute('method', 'post');

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
                'placeholder' => 'Informe o nome do livro',
            ]
        ]);

        $categoria = new Select();
        $categoria->setLabel("Categoria")
                  ->setName("categoria")
                  ->setOptions([
                      "value_options" => $this->categorias
                  ]);
        $this->add($categoria);

        $this->add([
            'name' => 'autor',
            'type' => 'Text',
            'options' => [
                'label' => 'Autor',
            ],
            'attributes' => [
                'id' => 'nome',
                'placeholder' => 'Informe o nome do autor',
            ]
        ]);

        $this->add([
            'name' => 'isbn',
            'type' => 'Text',
            'options' => [
                'label' => 'ISBN',
            ],
            'attributes' => [
                'id' => 'nome',
                'placeholder' => 'Informe o ISBN',
            ]
        ]);

        $this->add([
            'name' => 'valor',
            'type' => 'Text',
            'options' => [
                'label' => 'Valor',
            ],
            'attributes' => [
                'id' => 'nome',
                'placeholder' => 'Informe o valor',
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
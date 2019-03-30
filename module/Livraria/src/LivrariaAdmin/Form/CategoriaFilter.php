<?php

namespace LivrariaAdmin\Form;

use Zend\InputFilter\InputFilter;

class CategoriaFilter extends InputFilter
{
    /**
     * CategoriaFilter constructor.
     */
    public function __construct()
    {
        $this->add([
            'name' => 'nome',
            'required' => true,
            'filters' => [
                [
                    'name' => 'StripTags'
                ],
                [
                    'name' => 'StringTrim'
                ]
            ],
            'validators' => [
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            'isEmpty' => 'Nome não pode está em branco'
                        ]
                    ]
                ]
            ]
        ]);
    }
}
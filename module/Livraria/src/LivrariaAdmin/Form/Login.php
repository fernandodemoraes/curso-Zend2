<?php

namespace LivrariaAdmin\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Form;

/**
 * Class User
 *
 * @package LivrariaAdmin\Form
 */
class Login extends Form
{
    /**
     * User constructor.
     *
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('login');

        $this->setAttribute('method', 'post');

        $this->add([
            'name' => 'email',
            'options' => [
                'label' => 'E-mail',
                'type' => 'email',
            ],
            'attributes' => [
                'type' => 'email',
                'placeholder' => 'Informe o e-mail',
            ]
        ]);

        $this->add([
            'name' => 'password',
            'options' => [
                'label' => 'Senha',
                'type' => 'Password',
            ],
            'attributes' => [
                'type' => 'password',
                'placeholder' => 'Informe a senha',
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'attributes' => [
                'value' => 'Login',
                'class' => 'btn-primary'
            ]
        ]);
    }
}
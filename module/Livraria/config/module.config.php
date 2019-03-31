<?php

namespace Livraria;

use Livraria\Controller\IndexController;
use LivrariaAdmin\Controller\AuthController;
use LivrariaAdmin\Controller\CategoriasController;
use LivrariaAdmin\Controller\LivrosController;
use LivrariaAdmin\Controller\UsersController;

return [
    'router' => [
        'routes' => [
            'livraria-home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Livraria\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            'livraria-admin-interna' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin/[:controller[/:action][/:id]]',
                    'constraints' => [
                        'id' => '[0-9]+'
                    ]
                ]
            ],
            'livraria-admin' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin/[:controller[/:action][/page/:page]]',
                    'defaults' => [
                        'action' => 'index',
                        'page' => 1,
                    ]
                ]
            ],
            'livraria-admin-auth' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/admin/auth',
                    'defaults' => [
                        'action' => 'index',
                        'controller' => 'livraria-admin/auth'
                    ]
                ]
            ],
            'livraria-admin-logout' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/admin/auth/logout',
                    'defaults' => [
                        'action' => 'logout',
                        'controller' => 'livraria-admin/auth'
                    ]
                ]
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Livraria\Controller\Index' => IndexController::class,
            'categorias'                => CategoriasController::class,
            'livros'                    => LivrosController::class,
            'users'                     => UsersController::class,
            'livraria-admin/auth'       => AuthController::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'livraria/index/index'    => __DIR__ . '/../view/livraria/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];

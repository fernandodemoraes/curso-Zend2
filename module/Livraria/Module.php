<?php

namespace Livraria;

use Doctrine\ORM\EntityManager;
use Livraria\Model\CategoriaTable;
use Livraria\Service\Categoria as CategoriaService;
use Livraria\Service\Livro as LivroService;
use Livraria\Service\User as UserService;
use LivrariaAdmin\Form\Livro as LivroForm;
use Livraria\Auth\Adapter as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Adapter\Adapter;
use Zend\ModuleManager\ModuleManager;
use Zend\Authentication\Storage\Session as SessionStorage;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ . 'Admin' => __DIR__ . '/src/' . __NAMESPACE__ . 'Admin',
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * Verifica se o usuário está logado
     *
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach('ZendMvcControllerAbstractActionController', 'dispatch', function ($e) {
            $auth = new AuthenticationService();
            $auth->setStorage(new SessionStorage("LivrariaAdmin"));

            $controller   = $e->getTarget();
            $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();


            if (!$auth->hasIdentity() and ($matchedRoute == 'livraria-admin' or $matchedRoute == 'livraria-admin-interna')) {
                return $controller->redirect()->toRoute('livraria-admin-auth');
            }
        }, 99);
    }

    /**
     * Get Service Config
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'Livraria\Model\CategoriaService' => function($service) {
                    $dbAdapter = $service->get(Adapter::class);
                    $categoriaTable = new CategoriaTable($dbAdapter);
                    $categoriaService = new \Livraria\Model\CategoriaService($categoriaTable);

                    return $categoriaService;
                },
                'Livraria\Service\Categoria' => function($service) {
                    return new CategoriaService($service->get(EntityManager::class));
                },
                'Livraria\Service\Livro' => function($service) {
                    return new LivroService($service->get(EntityManager::class));
                },
                'Livraria\Service\User' => function($service) {
                    return new UserService($service->get(EntityManager::class));
                },
                'LivrariaAdmin\Form\Livro' => function($service) {
                    // injeta as categorias no form de livros
                    $em = $service->get(EntityManager::class);
                    $repository = $em->getRepository(\Livraria\Entity\Categoria::class);
                    $categorias = $repository->fetchPairs();
                    return new LivroForm(null, $categorias);
                },
                'Livraria\Auth\Adapter' => function($service) {
                    return new AuthAdapter($service->get(EntityManager::class));
                }
            ]
        ];
    }
}

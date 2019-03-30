<?php

namespace Livraria\Controller;

use Doctrine\ORM\EntityManager;
use Livraria\Entity\Categoria;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * Index Model
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get(EntityManager::class);
        $repo = $em->getRepository(Categoria::class);

        $categorias = $repo->findAll();

        return new ViewModel([
            'categorias' => $categorias,
        ]);
    }
}

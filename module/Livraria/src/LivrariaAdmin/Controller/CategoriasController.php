<?php

namespace LivrariaAdmin\Controller;

use Doctrine\ORM\EntityManager;
use Livraria\Entity\Categoria;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class CategoriasController extends AbstractActionController
{
    /**
     * Entity manager
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * Index action
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $list = $this->getEm()
            ->getRepository(Categoria::class)
            ->findAll();

        $page = $this->params()->fromRoute('page');

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);

        return new ViewModel([
            'data' => $paginator,
            'page' => $page,
        ]);
    }

    /**
     * Form nova categoria
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function newAction()
    {
        $form = new \LivrariaAdmin\Form\Categoria();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get(\Livraria\Service\Categoria::class);
                $service->insert($request->getPost()->toArray());

                return $this->redirect()->toRoute('livraria-admin', [
                    'controller' => 'categorias'
                ]);
            }
        }
        return new ViewModel([
            'form' => $form,
        ]);
    }

    /**
     * Editar
     */
    public function editAction()
    {
        $form = new \LivrariaAdmin\Form\Categoria();

        $request = $this->getRequest();

        $repository = $this->getEm()->getRepository(Categoria::class);

        $id = $this->params()->fromRoute('id', 0);
        $entity = $repository->find($id);

        // vamos preencher esse form aí...
        if ($id) {
            $form->setData($entity->toArray());
        }

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get(\Livraria\Service\Categoria::class);
                $service->update($request->getPost()->toArray());

                return $this->redirect()->toRoute('livraria-admin', [
                    'controller' => 'categorias'
                ]);
            }
        }
        return new ViewModel([
            'form' => $form,
        ]);
    }

    /**
     * Get Entity Manager
     *
     * @return array|EntityManager|object
     */
    protected function getEm()
    {
        if ($this->em === null) {
            $this->em = $this->getServiceLocator()->get(EntityManager::class);
        }
        return $this->em;
    }
}
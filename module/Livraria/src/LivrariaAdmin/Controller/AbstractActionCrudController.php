<?php

namespace LivrariaAdmin\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

abstract class AbstractActionCrudController extends AbstractActionController
{
    /**
     * Entity manager
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * Service
     *
     * @var
     */
    protected $service;

    /**
     * Entity
     *
     * @var
     */
    protected $entity;

    /**
     * Form
     *
     * @var
     */
    protected $form;

    /**
     * Route
     *
     * @var
     */
    protected $route;

    /**
     * Controller
     *
     * @var
     */
    protected $controller;

    /**
     * Index action
     *
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $list = $this->getEm()
            ->getRepository($this->entity)
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
        $form = new $this->form;
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());

                return $this->redirect()->toRoute($this->route, [
                    'controller' => $this->controller
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
        $form = new $this->form;

        $request = $this->getRequest();

        $repository = $this->getEm()->getRepository($this->entity);

        $id = $this->params()->fromRoute('id', 0);
        $entity = $repository->find($id);

        // vamos preencher esse form aí...
        if ($id) {
            $form->setData($entity->toArray());
        }

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());

                return $this->redirect()->toRoute($this->route, [
                    'controller' => $this->controller
                ]);
            }
        }
        return new ViewModel([
            'form' => $form,
        ]);
    }

    /**
     * Deletar
     *
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        $service = $this->getServiceLocator()->get($this->service);

        if ($service->delete($this->params()->fromRoute('id', 0))) {
            return $this->redirect()->toRoute($this->route, [
                'controller' => $this->controller
            ]);
        }
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
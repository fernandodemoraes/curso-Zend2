<?php

namespace LivrariaAdmin\Controller;

use Livraria\Entity\Livro;
use Zend\View\Model\ViewModel;

class LivrosController extends AbstractActionCrudController
{
    /**
     * LivrosController constructor.
     */
    public function __construct()
    {
        $this->entity     = Livro::class;
        $this->form       = \LivrariaAdmin\Form\Livro::class;
        $this->service    = \Livraria\Service\Livro::class;
        $this->controller = 'livros';
        $this->route      = 'livraria-admin';
    }

    /**
     * Novo action
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function newAction()
    {
        $form = $this->getServiceLocator()->get($this->form);
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
     * Editar action
     */
    public function editAction()
    {
        $form = $this->getServiceLocator()->get($this->form);

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
}
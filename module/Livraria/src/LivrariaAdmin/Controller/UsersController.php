<?php

namespace LivrariaAdmin\Controller;

use Livraria\Entity\User;
use Zend\View\Model\ViewModel;

/**
 * Class UsersController
 *
 * @package LivrariaAdmin\Controller
 */
class UsersController extends AbstractActionCrudController
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->entity     = User::class;
        $this->form       = \LivrariaAdmin\Form\User::class;
        $this->service    = \Livraria\Service\User::class;
        $this->controller = 'users';
        $this->route      = 'livraria-admin';
    }

    /**
     * Editar
     * Sobreescrita necessária para o form editar não vir com a senha carregada
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
            $array = $entity->toArray();
            unset($array['password']);

            // seta os dados do editar sem a senha
            $form->setData($array);
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
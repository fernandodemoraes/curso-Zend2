<?php

namespace LivrariaAdmin\Controller;

use Livraria\Auth\Adapter;
use LivrariaAdmin\Form\Login as LoginForm;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class AuthController
 *
 * @package LivrariaAdmin\Controller
 */
class AuthController extends AbstractActionController
{
    /**
     * Index action
     *
     * @return array|\Zend\Http\Response|ViewModel
     */
    public function indexAction()
    {
        $form = new LoginForm();
        $erro = false;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $request->getPost()->toArray();

                $auth = new AuthenticationService();

                $sessionStorage = new SessionStorage("LivrariaAdmin");
                $auth->setStorage($sessionStorage);

                $authAdapter = $this->getServiceLocator()->get(Adapter::class);
                $authAdapter
                    ->setUsername($data['email'])
                    ->setPassword($data['password']);

                $result = $auth->authenticate($authAdapter);

                if ($result->isValid()) {
                    $sessionStorage->write($auth->getIdentity()['user'], null);
                    return $this->redirect()->toRoute('livraria-admin', ['controller' => 'categorias']);
                } else {
                    $erro = true;
                }
            }
        }
        return new ViewModel([
            'form'  => $form,
            'error' => $erro
        ]);
    }

    /**
     * Logout action
     *
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage('LivrariaAdmin'));
        $auth->clearIdentity();

        return $this->redirect()->toRoute('livraria-admin-auth');
    }
}
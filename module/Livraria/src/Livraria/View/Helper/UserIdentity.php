<?php

namespace Livraria\View\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\View\Helper\AbstractHelper;

/**
 * Class UserIdentity
 */
class UserIdentity extends AbstractHelper
{
    /**
     * Auth service
     *
     * @var
     */
    protected $authService;

    /**
     * @return mixed
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Invoke
     *
     * @param null $namespace
     * @return bool
     */
    public function __invoke($namespace = null)
    {
        $sessionStorage = new SessionStorage($namespace);
        $this->authService = new AuthenticationService();
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity()) {
            return $this->getAuthService()->getIdentity();
        }
        return false;
    }
}
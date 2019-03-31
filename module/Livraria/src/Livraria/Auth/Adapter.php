<?php

namespace Livraria\Auth;

use Doctrine\ORM\EntityManager;
use Livraria\Entity\User;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

/**
 * Class Adapter
 */
class Adapter implements AdapterInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Usuário
     *
     * @var string
     */
    protected $username;

    /**
     * Senha
     *
     * @var string
     */
    protected $password;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $repository = $this->em->getRepository(User::class);
        $user       = $repository->findByEmailAndPassword($this->getUsername(), $this->getPassword());

        if ($user) {
            return new Result(Result::SUCCESS, [
                'user' => $user
            ],['Usuário logado com sucesso']);
        }
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, []);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
}
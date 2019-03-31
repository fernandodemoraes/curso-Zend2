<?php

namespace Livraria\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 *
 * @package Livraria\Repository
 */
class UserRepository extends EntityRepository
{
    /**
     * Busca o e-mail e senha no banco de dados
     *
     * @param $email
     * @param $password
     * @return bool
     */
    public function findByEmailAndPassword($email, $password)
    {
        $user = $this->findOneByEmail($email);

        if ($user) {
            $hashSenha = $user->encryptPassword($password);

            // verifica se a senha digitada é a mesma do banco de dados
            if ($hashSenha == $user->getPassword()) {
                return $user;
            } else {
                return false;
            }
        }
        return false;
    }
}
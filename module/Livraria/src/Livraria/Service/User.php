<?php

namespace Livraria\Service;

use Doctrine\ORM\EntityManager;
use Livraria\Entity\Configurator;

class User extends AbstractService
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = \Livraria\Entity\User::class;
    }

    /**
     * Atualizar
     * Sobreescrita necessária para não gerar um hash quando não houver senha informada para o usuário.
     *
     * @param array $data
     * @return bool|\Doctrine\Common\Proxy\Proxy|mixed|object|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(array $data)
    {
        // vamos buscar a referencia da entidade
        $entity = $this->em->getReference($this->entity, $data['id']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $entity = Configurator::configure($entity, $data);

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }
}
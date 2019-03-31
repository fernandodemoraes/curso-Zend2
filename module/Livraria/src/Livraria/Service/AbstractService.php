<?php

namespace Livraria\Service;

use Doctrine\ORM\EntityManager;
use Livraria\Entity\Configurator;

abstract class AbstractService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Entity
     *
     * @var
     */
    protected $entity;

    /**
     * AbstractService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Inserir
     *
     * @param array $data
     * @return \Livraria\Entity\Categoria
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(array $data)
    {
        $entity = new $this->entity($data);

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * Atualizar
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
        $entity = Configurator::configure($entity, $data);

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * Remover
     *
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id)
    {
        // vamos buscar a referencia da entidade
        $entity = $this->em->getReference($this->entity, $id);

        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
            return $id;
        }
    }
}
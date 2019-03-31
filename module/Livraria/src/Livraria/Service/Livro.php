<?php

namespace Livraria\Service;

use Doctrine\ORM\EntityManager;
use Livraria\Entity\Configurator;

class Livro extends AbstractService
{
    /**
     * Livro constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = \Livraria\Entity\Livro::class;
    }

    /**
     * Inserir
     *
     * @param array $data
     * @return \Livraria\Entity\Categoria|mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(array $data)
    {
        $entity = new $this->entity($data);

        $categoria = $this->em->getReference(\Livraria\Entity\Categoria::class, $data['categoria']);
        $entity->setCategoria($categoria);

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

        $categoria = $this->em->getReference(\Livraria\Entity\Categoria::class, $data['categoria']);
        $entity->setCategoria($categoria);

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }
}
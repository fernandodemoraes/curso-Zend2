<?php

namespace Livraria\Service;

use Doctrine\ORM\EntityManager;
use Livraria\Entity\Categoria as CategoriaService;
use Livraria\Entity\Configurator;

class Categoria
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Categoria constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Inserir dados
     *
     * @param array $data
     * @return \Livraria\Entity\Categoria
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(array $data)
    {
        $entity = new CategoriaService($data);

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * Atualizar dados
     *
     * @param array $data
     * @return bool|\Doctrine\Common\Proxy\Proxy|mixed|object|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(array $data)
    {
        // vamos buscar a referencia da entidade
        $entity = $this->em->getReference(\Livraria\Entity\Categoria::class, $data['id']);
        $entity = Configurator::configure($entity, $data);

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }
}
<?php

namespace Livraria\Repository;

use Doctrine\ORM\EntityRepository;

class CategoriaRepository extends EntityRepository
{
    /**
     * Fetch pairs
     *
     * @return array
     */
    public function fetchPairs()
    {
        $entities = $this->findAll();

        $array = [];

        foreach ($entities as $entity) {
            $array[$entity->getId()] = $entity->getNome();
        }
        return $array;
    }
}
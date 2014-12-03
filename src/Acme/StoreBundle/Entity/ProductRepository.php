<?php

namespace Acme\StoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProductRepository
 *
 * @package Acme\StoreBundle\Entity
 */
class ProductRepository extends EntityRepository
{
    public function findAllOrderByName()
    {
        return $this->findAll();

        return $this->getEntityManager()->createQuery(
            'select p from AcmeStoreBundle:Product p order by p.name ASC'
        )->getResult();
    }
}

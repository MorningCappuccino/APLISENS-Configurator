<?php

namespace AppBundle\Repository;

/**
 * EqModeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EqModeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByLetters($string){
        return $this->getEntityManager()->createQuery('SELECT e FROM AppBundle:EqMode e
                WHERE e.name LIKE :string')
            ->setParameter('string','%'.$string.'%')
            ->getResult(2);
    }
}

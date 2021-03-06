<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Beer;
use AppBundle\Entity\User;

/**
 * LikingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LikingRepository extends \Doctrine\ORM\EntityRepository
{
    public function getRatedBeers(User $user)
    {
        return $this->createQueryBuilder('l')
            ->where('l.author = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function getBeerRatings(Beer $beer)
    {
        return $this->createQueryBuilder('l')
            ->where('l.beer = :beerId')
            ->setParameter('beerId', $beer->getId())
            ->getQuery()
            ->getResult();
    }
}

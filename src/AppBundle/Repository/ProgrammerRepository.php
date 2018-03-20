<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;
use AppBundle\Entity\Programmer;

class ProgrammerRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return Programmer[]
     */
    public function findAllForUser(User $user)
    {
        return $this->findBy(array('user' => $user));
    }

    /**
     * @param string $nickname
     * @return Programmer|object
     */
    public function findOneByNickname($nickname)
    {
        return $this->findOneBy(array('nickname' => $nickname));
    }

    public function findAllQueryBuilder($filter = '')
    {
        $qb = $this->createQueryBuilder('programmer');

        if ($filter) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('programmer.nickname', ':filter'),
                    $qb->expr()->like('programmer.tagLine', ':filter'))
            )->setParameter('filter', '%'.$filter.'%');
        }

        return $qb;
    }
}

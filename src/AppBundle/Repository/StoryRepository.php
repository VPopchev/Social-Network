<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Story;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * StoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StoryRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(Story::class));
    }

    public function getStories(User $user)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('SELECT s,o
                                        FROM AppBundle:Story s
                                        JOIN s.owner o
                                        WHERE o IN (:ufr)
                                        ORDER BY s.startTime DESC');

        $query->setParameter('ufr',$user->getFriends());
        $result = $query->getResult();
        return $result;
    }
}

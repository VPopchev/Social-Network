<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 29.1.2018 г.
 * Time: 12:05 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Post;
use AppBundle\Entity\PostLike;
use AppBundle\Entity\User;
use AppBundle\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManager;

class PostLikeService implements PostLikeServiceInterface
{
    /**
     * @var PostLikeRepository
     */
    private $postLikeRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * PostLikeService constructor.
     * @param PostLikeRepository $postLikeRepository
     * @param EntityManager $entityManager
     */
    public function __construct(PostLikeRepository $postLikeRepository,
                                EntityManager $entityManager)
    {
        $this->postLikeRepository = $postLikeRepository;
        $this->entityManager = $entityManager;
    }


    public function insert(PostLike $like, User $user,Post $post): bool
    {
        if ($this->postLikeRepository->isLiked($post,$user)){
            return false;
        }

        $like->setUser($user);
        $like->setPost($post);
        $this->entityManager->persist($like);
        $this->entityManager->flush();
        return true;
    }
}
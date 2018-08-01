<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 9.2.2018 г.
 * Time: 12:38 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Repository\CommentRepository;
use Doctrine\ORM\EntityManager;

class CommentService implements CommentServiceInterface
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CommentService constructor.
     * @param CommentRepository $commentRepository
     * @param EntityManager $entityManager
     */
    public function __construct(CommentRepository $commentRepository,
                                EntityManager $entityManager)
    {
        $this->commentRepository = $commentRepository;
        $this->entityManager = $entityManager;
    }


    public function addComment(Comment $comment,User $owner,
                               Post $post,string $content): bool
    {
        $comment->setOwner($owner);
        $comment->setPost($post);
        $comment->setContent($content);
        $comment->setDate(new \DateTime('NOW'));
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
        return true;
    }
}
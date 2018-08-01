<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 29.1.2018 г.
 * Time: 10:27 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Repository\PostRepository;
use Doctrine\ORM\EntityManager;

class PostService implements PostServiceInterface
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * PostService constructor.
     * @param PostRepository $postRepository
     * @param EntityManager $entityManager
     */
    public function __construct(PostRepository $postRepository,
                                EntityManager $entityManager)
    {
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
    }


    public function insert(Post $post,User $user)
    {
        $post->setOwner($user);
        $post->setPostDate(new \DateTime('NOW'));
        $file = $post->getImage();
        $fileUploader = new FileUploader('app/images');
        $fileName = $fileUploader->upload($file);
        $post->setImage($fileName);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function getAll()
    {
        return $this->postRepository->getAll();
    }

    public function getFollowedPosts(User $user){
        return $this->postRepository->getFollowedPosts($user);
    }
}
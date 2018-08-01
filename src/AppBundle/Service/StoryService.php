<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 7.5.2018 г.
 * Time: 12:18 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Story;
use AppBundle\Entity\User;
use AppBundle\Repository\StoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class StoryService implements StoryServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var StoryRepository
     */
    private $storyRepository;

    /**
     * StoryService constructor.
     * @param EntityManagerInterface $entityManager
     * @param StoryRepository $storyRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                StoryRepository $storyRepository)
    {
        $this->entityManager = $entityManager;
        $this->storyRepository = $storyRepository;
    }


    public function create(Story $story, User $owner)
    {
        $story->setOwner($owner);
        $story->setStartTime(new \DateTime('NOW'));
        $file = $story->getPicture();
        $fileUploader = new FileUploader('app/images/story/');
        $fileName = $fileUploader->upload($file);
        $story->setPicture($fileName);
        $this->entityManager->persist($story);
        $this->entityManager->flush();
    }

    public function getStories(User $user)
    {
        return $this->storyRepository->getStories($user);
    }

    public function addViewer(User $user, Story $story)
    {
        if (!$story->getViewers()->contains($user)) {
            $story->addViewer($user);
            $this->entityManager->flush();
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 22.1.2018 г.
 * Time: 13:13 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Repository\MessageRepository;
use Doctrine\ORM\EntityManager;

class MessageService implements MessageServiceInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * MessageService constructor.
     * @param EntityManager $entityManager
     * @param MessageRepository $messageRepository
     */
    public function __construct(EntityManager $entityManager,
                                MessageRepository $messageRepository)
    {
        $this->entityManager = $entityManager;
        $this->messageRepository = $messageRepository;
    }


    public function send(Message $message,User $sender)
    {
        $message->setSender($sender);
        $message->setIsRead(false);
        $message->setSendDate(new \DateTime('NOW'));
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }

    public function getUserOutbox(int $userId)
    {
        return $this->messageRepository->getUserOutbox($userId);
    }

    public function getUserInbox(int $userId)
    {
        return $this->messageRepository->getUserInbox($userId);
    }

    public function setRead(Message $message)
    {
        $message->setIsRead(true);
        $this->entityManager->flush();
    }

    public function delete(Message $message)
    {
        $this->entityManager->remove($message);
        $this->entityManager->flush();
    }
}
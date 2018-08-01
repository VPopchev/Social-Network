<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 22.1.2018 г.
 * Time: 13:12 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Message;
use AppBundle\Entity\User;

interface MessageServiceInterface
{
    public function send(Message $message,User $sender);

    public function getUserOutbox(int $userId);

    public function getUserInbox(int $userId);

    public function setRead(Message $message);

    public function delete(Message $message);
}
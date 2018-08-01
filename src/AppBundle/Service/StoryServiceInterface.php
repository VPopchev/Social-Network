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

interface StoryServiceInterface
{
    public function create(Story $story,User $owner);

    public function getStories(User $user);

    public function addViewer(User $user,Story $story);
}
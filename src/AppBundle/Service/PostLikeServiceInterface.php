<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 29.1.2018 г.
 * Time: 12:04 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Post;
use AppBundle\Entity\PostLike;
use AppBundle\Entity\User;

interface PostLikeServiceInterface
{
    public function insert(PostLike $like,User $user,Post $post);
}
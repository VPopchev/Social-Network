<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 29.1.2018 г.
 * Time: 10:26 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Post;
use AppBundle\Entity\User;

interface PostServiceInterface
{
    public function insert(Post $post,User $user);

    public function getAll();

    public function getFollowedPosts(User $user);
}
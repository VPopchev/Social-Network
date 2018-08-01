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

interface CommentServiceInterface
{
    public function addComment(Comment $comment,User $owner,Post $post,string $content):bool;
}
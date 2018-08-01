<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\PostLike;
use AppBundle\Service\PostLikeServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostLikeController extends Controller
{
    /**
     * @var PostLikeServiceInterface
     */
    private $postLikeService;

    /**
     * PostLikeController constructor.
     * @param PostLikeServiceInterface $postLikeService
     */
    public function __construct(PostLikeServiceInterface $postLikeService)
    {
        $this->postLikeService = $postLikeService;
    }


    /**
     * @param Post $post
     * @Route("post/like/{id}",name="like_post")
     * @return string
     */
    public function newLikeAction(Post $post){
        $user = $this->getUser();
        $like = new PostLike();

        if (!$this->postLikeService->insert($like,$user,$post)){
            return new JsonResponse('',409);
        }
        return new JsonResponse($post->getLikes()->count(),200);
    }

    /**
     * @param Post $post
     * @Route("post/viewLikes/{id}",name="view_likes")
     * @return JsonResponse
     */
    public function getLikes(Post $post){
        $likes = $post->getLikes();
        $resultData = [];
        foreach ($likes as $like){
            $resultData[] = $like->getUser();
        }
        return new JsonResponse(json_encode($resultData),200);
    }
}

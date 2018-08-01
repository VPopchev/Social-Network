<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Service\CommentServiceInterface;
use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     * @var CommentServiceInterface
     */
    private $commentService;

    /**
     * CommentController constructor.
     * @param CommentServiceInterface $commentService
     */
    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @param Post $post
     * @param Request $request
     * @return JsonResponse
     * @Route("/post/view/new/comment/{id}",name="new_comment")
     */
    public function addComment(Post $post,Request $request){
        $user = $this->getUser();
        $comment = new Comment();
        $content = $request->request->get('content');
        $this->commentService->addComment($comment,$user,$post,$content);
        $comments = $post->getComments();
        return new JsonResponse($comments,200);
    }


}

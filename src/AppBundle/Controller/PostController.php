<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Form\CommentType;
use AppBundle\Form\PostType;
use AppBundle\Service\CommentServiceInterface;
use AppBundle\Service\PostServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @var PostServiceInterface
     */
    private $postService;

    /**
     * @var CommentServiceInterface
     */
    private $commentService;

    /**
     * PostController constructor.
     * @param PostServiceInterface $postService
     */
    public function __construct(PostServiceInterface $postService,
                                CommentServiceInterface $commentService)
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("post/new",name="new_post")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function createAction(Request $request){
        $post = new Post();
        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            /** @var User $user */
            $user = $this->getUser();
            $this->postService->insert($post,$user);
            return $this->redirectToRoute('homepage');
        }

        return $this->render('post/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Post $post
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("post/view/{id}",name="view_post")
     */
    public function viewAction(Post $post,Request $request){
        return $this->render('post/view.html.twig',[
            'post' => $post
        ]);
    }

}

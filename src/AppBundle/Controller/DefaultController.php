<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Story;
use AppBundle\Entity\User;
use AppBundle\Service\PostServiceInterface;
use AppBundle\Service\StoryServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @var PostServiceInterface
     */
    private $postService;

    /**
     * @var StoryServiceInterface
     */
    private $storyService;

    /**
     * DefaultController constructor.
     * @param PostServiceInterface $postService
     */
    public function __construct(PostServiceInterface $postService,
                                StoryServiceInterface $storyService)
    {
        $this->postService = $postService;
        $this->storyService = $storyService;
    }


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        if (null === $user){
            return $this->redirectToRoute('login');
        }
        /** @var Post[] $posts */
        $posts = $this->postService->getFollowedPosts($user);
        /** @var Story[] $stories */
        $stories = $this->storyService->getStories($user);
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'posts' => $posts,
            'stories' => $stories
        ]);
    }
}

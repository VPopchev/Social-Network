<?php
/**
 * Created by PhpStorm.
 * User: Viktor
 * Date: 7.5.2018 г.
 * Time: 12:20 ч.
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Story;
use AppBundle\Form\StoryType;
use AppBundle\Service\StoryServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StoryController extends Controller
{
    /**
     * @var StoryServiceInterface
     */
    private $storyService;

    /**
     * StoryController constructor.
     * @param StoryServiceInterface $storyService
     */
    public function __construct(StoryServiceInterface $storyService)
    {
        $this->storyService = $storyService;
    }

    /**
     * @param Request $request
     * @Route("story/create",name="new_story")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){
        $story = new Story();
        $form = $this->createForm(StoryType::class,$story);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()){
            $this->storyService->create($story,$user);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('story/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Story $story
     * @Route("story/view/{id}",name="view_story")
     * @return JsonResponse
     */
    public function getUserStory(Story $story){
        return new JsonResponse(
            $story->getPicture(),
            200);
    }

    /**
     * @param Story $story
     * @Route("story/viewer/{id}",name="view_story")
     * @return JsonResponse
     */
    public function setViewerAction(Story $story){
        $user = $this->getUser();
        $this->storyService->addViewer($user,$story);
        return new JsonResponse(null,200);
    }

}
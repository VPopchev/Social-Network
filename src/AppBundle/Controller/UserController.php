<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @param UserServiceInterface $userService
     * @internal param $UserServiceInterface
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @param Request $request
     * @Route("/register",name="register_user")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request){
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->userService->register($user);
            return $this->redirectToRoute('login');
        }
        return $this->render('user/register.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile",name="user_profile")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function profileAction(){
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('user/profile.html.twig',[
            'user' => $user
        ]);
    }

    /**
     * @Route("/users",name="find_users")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request){
        $form = $this->createFormBuilder()
            ->add('input',TextType::class,['label' => false])
            ->add('Search',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        /** @var User[] $users */
        if($form->isSubmitted() && $form->isValid()){
            $input = $form->get('input')->getData();
            $users = $this->userService->findByUsername($input);

        } else {
            $users = $this->userService->findAll();
        }

        return $this->render('user/all.html.twig',[
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/follow/{id}",name="follow_friend")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addFriendAction(User $user){
        /** @var User $loggedUser */
        $loggedUser = $this->getUser();
        $this->userService->addFriend($loggedUser,$user);
        return $this->redirectToRoute('find_users');
    }
}

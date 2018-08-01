<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("user/login", name="login")
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        return $this->render('user/login.html.twig', [
            'error' => $error
        ]);
    }

    /**
     * @Route("user/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }

}

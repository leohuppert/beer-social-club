<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/login", name="login")
     */
    public function loginAction(): Response
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();



        return $this->render('security/login.html.twig', array(
            'error'         => $error,
            'last_username' => $lastUsername
        ));
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @return Response
     *
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()
                ->getManager();

            $encoder = $this->get('security.password_encoder');

            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

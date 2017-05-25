<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController
 * @package AppBundle\Controller
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}", name="user_show")
     */
    public function showAction(User $user)
    {
        return $this->render(':user:show.html.twig', array(
            'user' => $user,
        ));
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Beer;
use AppBundle\Entity\Liking;
use AppBundle\Form\LikingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LikingController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/rate/{id}", name="beer_rate")
     */
    public function newAction(Request $request, Beer $beer)
    {
        $liking = new Liking();
        $form = $this->createForm(LikingType::class, $liking);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();

            $liking->setAuthor($this->getUser());
            $liking->setBeer($beer);

            $em->persist($liking);
            $em->flush();

            return $this->redirectToRoute('beer_show', array('id' => $beer->getId()));
        }

        return $this->render(':liking:rate.html.twig', array(
            'form' => $form->createView(),
            'beer' => $beer,
        ));
    }
}

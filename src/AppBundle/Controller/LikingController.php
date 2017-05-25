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
     * @Route("/beer/rate/{id}", name="beer_rate")
     * @param Request $request
     * @param Beer $beer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
            $liking->setDate(new \DateTime());

            $em->persist($liking);
            $em->flush();

            return $this->redirectToRoute('beer_show', array('id' => $beer->getId()));
        }

        return $this->render(':liking:rate.html.twig', array(
            'form' => $form->createView(),
            'beer' => $beer,
        ));
    }

    /**
     * @Route("/beer/update-rating/{id}", name="rate_update")
     * @param Request $request
     * @param Liking $liking
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Liking $liking)
    {
        $editForm = $this->createForm(LikingType::class, $liking);
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid()) {
            $liking->setDate(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('beer_show', array(
                'id' => $liking->getBeer()->getId(),
            ));
        }

        return $this->render(':liking:rate.html.twig', array(
            'form'   => $editForm->createView(),
            'beer'   => $liking->getBeer(),
            'liking' => $liking,
        ));
    }
}

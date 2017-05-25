<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Beer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Beer controller.
 *
 * @Route("beer")
 */
class BeerController extends Controller
{
    /**
     * Lists all beer entities.
     *
     * @Route("/", name="beer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $beers = $em->getRepository('AppBundle:Beer')->findAll();

        return $this->render('beer/index.html.twig', array(
            'beers' => $beers,
        ));
    }

    /**
     * Creates a new beer entity.
     *
     * @Route("/new", name="beer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $beer = new Beer();
        $form = $this->createForm('AppBundle\Form\BeerType', $beer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();

            //Handling picture
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $beer->getFile();
            if($file instanceof UploadedFile) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('pictures_directory'),
                    $fileName
                );
                $beer->setPicture($fileName);
            }

            $em->persist($beer);
            $em->flush();

            return $this->redirectToRoute('beer_show', array('id' => $beer->getId()));
        }

        return $this->render('beer/new.html.twig', array(
            'beer' => $beer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a beer entity.
     *
     * @Route("/{id}", name="beer_show")
     * @Method("GET")
     */
    public function showAction(Beer $beer)
    {
        $deleteForm = $this->createDeleteForm($beer);

        $em = $this->getDoctrine()
            ->getManager();

        $ratedBeersByUser = $em->getRepository('AppBundle:Liking')
            ->getRatedBeers($this->getUser());
        $beerRatings = $em->getRepository('AppBundle:Liking')
            ->getBeerRatings($beer);

        $isRated = false;
        $liking = null;

        foreach($ratedBeersByUser as $rating) {
            if($rating->getBeer() == $beer) {
                $isRated = true;
                $liking = $rating;
                break;
            }
        }

        return $this->render('beer/show.html.twig', array(
            'beer'         => $beer,
            'delete_form'  => $deleteForm->createView(),
            'is_rated'     => $isRated,
            'liking'       => $liking,
            'beer_ratings' => $beerRatings,
        ));
    }

    /**
     * Displays a form to edit an existing beer entity.
     *
     * @Route("/{id}/edit", name="beer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Beer $beer)
    {
        $deleteForm = $this->createDeleteForm($beer);
        $editForm = $this->createForm('AppBundle\Form\BeerType', $beer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('beer_edit', array('id' => $beer->getId()));
        }

        return $this->render('beer/edit.html.twig', array(
            'beer' => $beer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a beer entity.
     *
     * @Route("/{id}", name="beer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Beer $beer)
    {
        $form = $this->createDeleteForm($beer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($beer);
            $em->flush();
        }

        return $this->redirectToRoute('beer_index');
    }

    /**
     * Creates a form to delete a beer entity.
     *
     * @param Beer $beer The beer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Beer $beer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('beer_delete', array('id' => $beer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

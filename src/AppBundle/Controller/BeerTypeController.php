<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BeerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Beertype controller.
 *
 * @Route("beertype")
 */
class BeerTypeController extends Controller
{
    /**
     * Lists all beerType entities.
     *
     * @Route("/", name="beertype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $beerTypes = $em->getRepository('AppBundle:BeerType')->findAll();

        return $this->render('beertype/index.html.twig', array(
            'beerTypes' => $beerTypes,
        ));
    }

    /**
     * Creates a new beerType entity.
     *
     * @Route("/new", name="beertype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $beerType = new Beertype();
        $form = $this->createForm('AppBundle\Form\BeerTypeType', $beerType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($beerType);
            $em->flush();

            return $this->redirectToRoute('beertype_show', array('id' => $beerType->getId()));
        }

        return $this->render('beertype/new.html.twig', array(
            'beerType' => $beerType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a beerType entity.
     *
     * @Route("/{id}", name="beertype_show")
     * @Method("GET")
     */
    public function showAction(BeerType $beerType)
    {
        $deleteForm = $this->createDeleteForm($beerType);

        return $this->render('beertype/show.html.twig', array(
            'beerType' => $beerType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing beerType entity.
     *
     * @Route("/{id}/edit", name="beertype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BeerType $beerType)
    {
        $deleteForm = $this->createDeleteForm($beerType);
        $editForm = $this->createForm('AppBundle\Form\BeerTypeType', $beerType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('beertype_edit', array('id' => $beerType->getId()));
        }

        return $this->render('beertype/edit.html.twig', array(
            'beerType' => $beerType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a beerType entity.
     *
     * @Route("/{id}", name="beertype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BeerType $beerType)
    {
        $form = $this->createDeleteForm($beerType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($beerType);
            $em->flush();
        }

        return $this->redirectToRoute('beertype_index');
    }

    /**
     * Creates a form to delete a beerType entity.
     *
     * @param BeerType $beerType The beerType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BeerType $beerType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('beertype_delete', array('id' => $beerType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

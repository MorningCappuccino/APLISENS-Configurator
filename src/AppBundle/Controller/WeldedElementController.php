<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\WeldedElement;
use AppBundle\Form\WeldedElementType;

/**
 * WeldedElement controller.
 *
 * @Route("/weldedelement")
 */
class WeldedElementController extends Controller
{
    /**
     * Lists all WeldedElement entities.
     *
     * @Route("/", name="weldedelement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $weldedElements = $em->getRepository('AppBundle:WeldedElement')->findAll();

        return $this->render('weldedelement/index.html.twig', array(
            'weldedElements' => $weldedElements,
        ));
    }

    /**
     * Creates a new WeldedElement entity.
     *
     * @Route("/new", name="weldedelement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $weldedElement = new WeldedElement();
        $form = $this->createForm('AppBundle\Form\WeldedElementType', $weldedElement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($weldedElement);
            $em->flush();

            return $this->redirectToRoute('weldedelement_show', array('id' => $weldedElement->getId()));
        }

        return $this->render('weldedelement/new.html.twig', array(
            'weldedElement' => $weldedElement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a WeldedElement entity.
     *
     * @Route("/{id}", name="weldedelement_show")
     * @Method("GET")
     */
    public function showAction(WeldedElement $weldedElement)
    {
        $deleteForm = $this->createDeleteForm($weldedElement);

        return $this->render('weldedelement/show.html.twig', array(
            'weldedElement' => $weldedElement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing WeldedElement entity.
     *
     * @Route("/{id}/edit", name="weldedelement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, WeldedElement $weldedElement)
    {
        $deleteForm = $this->createDeleteForm($weldedElement);
        $editForm = $this->createForm('AppBundle\Form\WeldedElementType', $weldedElement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($weldedElement);
            $em->flush();

            return $this->redirectToRoute('weldedelement_edit', array('id' => $weldedElement->getId()));
        }

        return $this->render('weldedelement/edit.html.twig', array(
            'weldedElement' => $weldedElement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a WeldedElement entity.
     *
     * @Route("/{id}", name="weldedelement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, WeldedElement $weldedElement)
    {
        $form = $this->createDeleteForm($weldedElement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($weldedElement);
            $em->flush();
        }

        return $this->redirectToRoute('weldedelement_index');
    }

    /**
     * Creates a form to delete a WeldedElement entity.
     *
     * @param WeldedElement $weldedElement The WeldedElement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(WeldedElement $weldedElement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('weldedelement_delete', array('id' => $weldedElement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

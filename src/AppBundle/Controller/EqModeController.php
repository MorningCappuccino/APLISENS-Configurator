<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\EqMode;
use AppBundle\Form\EqModeType;

/**
 * EqMode controller.
 *
 * @Route("admin/eqmode")
 */
class EqModeController extends Controller
{
    /**
     * Lists all EqMode entities.
     *
     * @Route("/", name="eqmode_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eqModes = $em->getRepository('AppBundle:EqMode')->findAll();

        return $this->render('eqmode/index.html.twig', array(
            'eqModes' => $eqModes,
        ));
    }

    /**
     * Creates a new EqMode entity.
     *
     * @Route("/new", name="eqmode_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $eqMode = new EqMode();
        $form = $this->createForm('AppBundle\Form\EqModeType', $eqMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eqMode);
            $em->flush();

            return $this->redirectToRoute('eqmode_show', array('id' => $eqMode->getId()));
        }

        return $this->render('eqmode/new.html.twig', array(
            'eqMode' => $eqMode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EqMode entity.
     *
     * @Route("/{id}", name="eqmode_show")
     * @Method("GET")
     */
    public function showAction(EqMode $eqMode)
    {
        $deleteForm = $this->createDeleteForm($eqMode);

        return $this->render('eqmode/show.html.twig', array(
            'eqMode' => $eqMode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EqMode entity.
     *
     * @Route("/{id}/edit", name="eqmode_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EqMode $eqMode)
    {
        $deleteForm = $this->createDeleteForm($eqMode);
        $editForm = $this->createForm('AppBundle\Form\EqModeType', $eqMode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eqMode);
            $em->flush();

            return $this->redirectToRoute('eqmode_edit', array('id' => $eqMode->getId()));
        }

        return $this->render('eqmode/edit.html.twig', array(
            'eqMode' => $eqMode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EqMode entity.
     *
     * @Route("/{id}", name="eqmode_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EqMode $eqMode)
    {
        $form = $this->createDeleteForm($eqMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eqMode);
            $em->flush();
        }

        return $this->redirectToRoute('eqmode_index');
    }

    /**
     * Creates a form to delete a EqMode entity.
     *
     * @param EqMode $eqMode The EqMode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EqMode $eqMode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eqmode_delete', array('id' => $eqMode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\EqType;
use AppBundle\Form\EqTypeType;

/**
 * EqType controller.
 *
 * @Route("admin/eqtype")
 */
class EqTypeController extends Controller
{
    /**
     * Lists all EqType entities.
     *
     * @Route("/", name="eqtype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eqTypes = $em->getRepository('AppBundle:EqType')->findAll();

        return $this->render('eqtype/index.html.twig', array(
            'eqTypes' => $eqTypes,
        ));
    }

    /**
     * Creates a new EqType entity.
     *
     * @Route("/new", name="eqtype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $eqType = new EqType();
        $form = $this->createForm('AppBundle\Form\EqTypeType', $eqType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eqType);
            $em->flush();

            return $this->redirectToRoute('eqtype_show', array('id' => $eqType->getId()));
        }

        return $this->render('eqtype/new.html.twig', array(
            'eqType' => $eqType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EqType entity.
     *
     * @Route("/{id}", name="eqtype_show")
     * @Method("GET")
     */
    public function showAction(EqType $eqType)
    {
        $deleteForm = $this->createDeleteForm($eqType);

        return $this->render('eqtype/show.html.twig', array(
            'eqType' => $eqType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EqType entity.
     *
     * @Route("/{id}/edit", name="eqtype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EqType $eqType)
    {
        $deleteForm = $this->createDeleteForm($eqType);
        $editForm = $this->createForm('AppBundle\Form\EqTypeType', $eqType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eqType);
            $em->flush();

            return $this->redirectToRoute('eqtype_edit', array('id' => $eqType->getId()));
        }

        return $this->render('eqtype/edit.html.twig', array(
            'eqType' => $eqType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EqType entity.
     *
     * @Route("/{id}", name="eqtype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EqType $eqType)
    {
        $form = $this->createDeleteForm($eqType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eqType);
            $em->flush();
        }

        return $this->redirectToRoute('eqtype_index');
    }

    /**
     * Creates a form to delete a EqType entity.
     *
     * @param EqType $eqType The EqType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EqType $eqType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eqtype_delete', array('id' => $eqType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

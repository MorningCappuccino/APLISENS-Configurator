<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ValveUnit;
use AppBundle\Form\ValveUnitType;

/**
 * ValveUnit controller.
 *
 * @Route("/valveunit")
 */
class ValveUnitController extends Controller
{
    /**
     * Lists all ValveUnit entities.
     *
     * @Route("/", name="valveunit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $valveUnits = $em->getRepository('AppBundle:ValveUnit')->findAll();

        return $this->render('valveunit/index.html.twig', array(
            'valveUnits' => $valveUnits,
        ));
    }

    /**
     * Creates a new ValveUnit entity.
     *
     * @Route("/new", name="valveunit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $valveUnit = new ValveUnit();
        $form = $this->createForm('AppBundle\Form\ValveUnitType', $valveUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($valveUnit);
            $em->flush();

            return $this->redirectToRoute('valveunit_show', array('id' => $valveUnit->getId()));
        }

        return $this->render('valveunit/new.html.twig', array(
            'valveUnit' => $valveUnit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ValveUnit entity.
     *
     * @Route("/{id}", name="valveunit_show")
     * @Method("GET")
     */
    public function showAction(ValveUnit $valveUnit)
    {
        $deleteForm = $this->createDeleteForm($valveUnit);

        return $this->render('valveunit/show.html.twig', array(
            'valveUnit' => $valveUnit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ValveUnit entity.
     *
     * @Route("/{id}/edit", name="valveunit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ValveUnit $valveUnit)
    {
        $deleteForm = $this->createDeleteForm($valveUnit);
        $editForm = $this->createForm('AppBundle\Form\ValveUnitType', $valveUnit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($valveUnit);
            $em->flush();

            return $this->redirectToRoute('valveunit_edit', array('id' => $valveUnit->getId()));
        }

        return $this->render('valveunit/edit.html.twig', array(
            'valveUnit' => $valveUnit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ValveUnit entity.
     *
     * @Route("/{id}", name="valveunit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ValveUnit $valveUnit)
    {
        $form = $this->createDeleteForm($valveUnit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($valveUnit);
            $em->flush();
        }

        return $this->redirectToRoute('valveunit_index');
    }

    /**
     * Creates a form to delete a ValveUnit entity.
     *
     * @param ValveUnit $valveUnit The ValveUnit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ValveUnit $valveUnit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('valveunit_delete', array('id' => $valveUnit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

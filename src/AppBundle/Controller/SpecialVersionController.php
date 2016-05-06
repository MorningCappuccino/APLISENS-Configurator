<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\SpecialVersion;
use AppBundle\Form\SpecialVersionType;

/**
 * SpecialVersion controller.
 *
 * @Route("/specialversion")
 */
class SpecialVersionController extends Controller
{
    /**
     * Lists all SpecialVersion entities.
     *
     * @Route("/", name="specialversion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialVersions = $em->getRepository('AppBundle:SpecialVersion')->findBy(array(), ['name' => 'ASC']);

        return $this->render('specialversion/index.html.twig', array(
            'specialVersions' => $specialVersions,
        ));
    }

    /**
     * Creates a new SpecialVersion entity.
     *
     * @Route("/new", name="specialversion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $specialVersion = new SpecialVersion();
        $form = $this->createForm('AppBundle\Form\SpecialVersionType', $specialVersion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialVersion);
            $em->flush();

            return $this->redirectToRoute('specialversion_index', array('id' => $specialVersion->getId()));
        }

        return $this->render('specialversion/new.html.twig', array(
            'specialVersion' => $specialVersion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SpecialVersion entity.
     *
     * @Route("/{id}", name="specialversion_show")
     * @Method("GET")
     */
    public function showAction(SpecialVersion $specialVersion)
    {
        $deleteForm = $this->createDeleteForm($specialVersion);

        return $this->render('specialversion/show.html.twig', array(
            'specialVersion' => $specialVersion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SpecialVersion entity.
     *
     * @Route("/{id}/edit", name="specialversion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SpecialVersion $specialVersion)
    {
        $deleteForm = $this->createDeleteForm($specialVersion);
        $editForm = $this->createForm('AppBundle\Form\SpecialVersionType', $specialVersion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialVersion);
            $em->flush();

            return $this->redirectToRoute('specialversion_edit', array('id' => $specialVersion->getId()));
        }

        return $this->render('specialversion/edit.html.twig', array(
            'specialVersion' => $specialVersion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a SpecialVersion entity.
     *
     * @Route("/{id}", name="specialversion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SpecialVersion $specialVersion)
    {
        $form = $this->createDeleteForm($specialVersion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specialVersion);
            $em->flush();
        }

        return $this->redirectToRoute('specialversion_index');
    }

    /**
     * Creates a form to delete a SpecialVersion entity.
     *
     * @param SpecialVersion $specialVersion The SpecialVersion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SpecialVersion $specialVersion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialversion_delete', array('id' => $specialVersion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Accuracy;
use AppBundle\Form\AccuracyType;

/**
 * Accuracy controller.
 *
 * @Route("/accuracy")
 */
class AccuracyController extends Controller
{
    /**
     * Lists all Accuracy entities.
     *
     * @Route("/", name="accuracy_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accuracies = $em->getRepository('AppBundle:Accuracy')->findAll();

        return $this->render('accuracy/index.html.twig', array(
            'accuracies' => $accuracies,
        ));
    }

    /**
     * Creates a new Accuracy entity.
     *
     * @Route("/new", name="accuracy_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $accuracy = new Accuracy();
        $form = $this->createForm('AppBundle\Form\AccuracyType', $accuracy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accuracy);
            $em->flush();

            return $this->redirectToRoute('accuracy_index', array('id' => $accuracy->getId()));
        }

        return $this->render('accuracy/new.html.twig', array(
            'accuracy' => $accuracy,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Accuracy entity.
     *
     * @Route("/{id}", name="accuracy_show")
     * @Method("GET")
     */
    public function showAction(Accuracy $accuracy)
    {
        $deleteForm = $this->createDeleteForm($accuracy);

        return $this->render('accuracy/show.html.twig', array(
            'accuracy' => $accuracy,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Accuracy entity.
     *
     * @Route("/{id}/edit", name="accuracy_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Accuracy $accuracy)
    {
        $deleteForm = $this->createDeleteForm($accuracy);
        $editForm = $this->createForm('AppBundle\Form\AccuracyType', $accuracy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accuracy);
            $em->flush();

            return $this->redirectToRoute('accuracy_edit', array('id' => $accuracy->getId()));
        }

        return $this->render('accuracy/edit.html.twig', array(
            'accuracy' => $accuracy,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Accuracy entity.
     *
     * @Route("/{id}", name="accuracy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Accuracy $accuracy)
    {
        $form = $this->createDeleteForm($accuracy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($accuracy);
            $em->flush();
        }

        return $this->redirectToRoute('accuracy_index');
    }

    /**
     * Creates a form to delete a Accuracy entity.
     *
     * @param Accuracy $accuracy The Accuracy entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Accuracy $accuracy)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('accuracy_delete', array('id' => $accuracy->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

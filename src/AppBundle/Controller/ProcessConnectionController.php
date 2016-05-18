<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ProcessConnection;
use AppBundle\Form\ProcessConnectionType;

/**
 * ProcessConnection controller.
 *
 * @Route("/processconnection")
 */
class ProcessConnectionController extends Controller
{
    /**
     * Lists all ProcessConnection entities.
     *
     * @Route("/", name="processconnection_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $processConnections = $em->getRepository('AppBundle:ProcessConnection')->findBy([],['name' => 'ASC']);

        return $this->render('processconnection/index.html.twig', array(
            'processConnections' => $processConnections,
        ));
    }

    /**
     * Creates a new ProcessConnection entity.
     *
     * @Route("/new", name="processconnection_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $processConnection = new ProcessConnection();
        $form = $this->createForm('AppBundle\Form\ProcessConnectionType', $processConnection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($processConnection);
            $em->flush();

            return $this->redirectToRoute('processconnection_index');
        }

        return $this->render('processconnection/new.html.twig', array(
            'processConnection' => $processConnection,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ProcessConnection entity.
     *
     * @Route("/{id}", name="processconnection_show")
     * @Method("GET")
     */
    public function showAction(ProcessConnection $processConnection)
    {
        $deleteForm = $this->createDeleteForm($processConnection);

        return $this->render('processconnection/show.html.twig', array(
            'processConnection' => $processConnection,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ProcessConnection entity.
     *
     * @Route("/{id}/edit", name="processconnection_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProcessConnection $processConnection)
    {
        $deleteForm = $this->createDeleteForm($processConnection);
        $editForm = $this->createForm('AppBundle\Form\ProcessConnectionType', $processConnection);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($processConnection);
            $em->flush();

            return $this->redirectToRoute('processconnection_index');
        }

        return $this->render('processconnection/edit.html.twig', array(
            'processConnection' => $processConnection,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ProcessConnection entity.
     *
     * @Route("/{id}", name="processconnection_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProcessConnection $processConnection)
    {
        $form = $this->createDeleteForm($processConnection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($processConnection);
            $em->flush();
        }

        return $this->redirectToRoute('processconnection_index');
    }

    /**
     * Creates a form to delete a ProcessConnection entity.
     *
     * @param ProcessConnection $processConnection The ProcessConnection entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProcessConnection $processConnection)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('processconnection_delete', array('id' => $processConnection->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

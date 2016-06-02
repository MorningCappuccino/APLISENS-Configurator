<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Brace;
use AppBundle\Form\BraceType;

/**
 * Brace controller.
 *
 * @Route("/brace")
 */
class BraceController extends Controller
{
    /**
     * Lists all Brace entities.
     *
     * @Route("/", name="brace_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $braces = $em->getRepository('AppBundle:Brace')->findAll();

        return $this->render('brace/index.html.twig', array(
            'braces' => $braces,
        ));
    }

    /**
     * Creates a new Brace entity.
     *
     * @Route("/new", name="brace_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $brace = new Brace();
        $form = $this->createForm('AppBundle\Form\BraceType', $brace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brace);
            $em->flush();

            return $this->redirectToRoute('brace_show', array('id' => $brace->getId()));
        }

        return $this->render('brace/new.html.twig', array(
            'brace' => $brace,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Brace entity.
     *
     * @Route("/{id}", name="brace_show")
     * @Method("GET")
     */
    public function showAction(Brace $brace)
    {
        $deleteForm = $this->createDeleteForm($brace);

        return $this->render('brace/show.html.twig', array(
            'brace' => $brace,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Brace entity.
     *
     * @Route("/{id}/edit", name="brace_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Brace $brace)
    {
        $deleteForm = $this->createDeleteForm($brace);
        $editForm = $this->createForm('AppBundle\Form\BraceType', $brace);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brace);
            $em->flush();

            return $this->redirectToRoute('brace_edit', array('id' => $brace->getId()));
        }

        return $this->render('brace/edit.html.twig', array(
            'brace' => $brace,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Brace entity.
     *
     * @Route("/{id}", name="brace_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Brace $brace)
    {
        $form = $this->createDeleteForm($brace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($brace);
            $em->flush();
        }

        return $this->redirectToRoute('brace_index');
    }

    /**
     * Creates a form to delete a Brace entity.
     *
     * @param Brace $brace The Brace entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Brace $brace)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('brace_delete', array('id' => $brace->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

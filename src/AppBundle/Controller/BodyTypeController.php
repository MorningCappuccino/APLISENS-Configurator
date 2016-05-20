<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\BodyType;
use AppBundle\Form\BodyTypeType;

/**
 * BodyType controller.
 *
 * @Route("/bodytype")
 */
class BodyTypeController extends Controller
{
    /**
     * Lists all BodyType entities.
     *
     * @Route("/", name="bodytype_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bodyTypes = $em->getRepository('AppBundle:BodyType')->findBy(array(), array('name' => 'ASC'));

        return $this->render('bodytype/index.html.twig', array(
            'bodyTypes' => $bodyTypes,
        ));
    }

    /**
     * Creates a new BodyType entity.
     *
     * @Route("/new", name="bodytype_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bodyType = new BodyType();
        $form = $this->createForm('AppBundle\Form\BodyTypeType', $bodyType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bodyType);
            $em->flush();

            return $this->redirectToRoute('bodytype_index', array('id' => $bodyType->getId()));
        }

        return $this->render('bodytype/new.html.twig', array(
            'bodyType' => $bodyType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BodyType entity.
     *
     * @Route("/{id}", name="bodytype_show")
     * @Method("GET")
     */
    public function showAction(BodyType $bodyType)
    {
        $deleteForm = $this->createDeleteForm($bodyType);

        return $this->render('bodytype/show.html.twig', array(
            'bodyType' => $bodyType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BodyType entity.
     *
     * @Route("/{id}/edit", name="bodytype_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BodyType $bodyType)
    {
        $deleteForm = $this->createDeleteForm($bodyType);
        $editForm = $this->createForm('AppBundle\Form\BodyTypeType', $bodyType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bodyType);
            $em->flush();

            return $this->redirectToRoute('bodytype_index', array('id' => $bodyType->getId()));
        }

        return $this->render('bodytype/edit.html.twig', array(
            'bodyType' => $bodyType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BodyType entity.
     *
     * @Route("/{id}", name="bodytype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BodyType $bodyType)
    {
        $form = $this->createDeleteForm($bodyType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bodyType);
            $em->flush();
        }

        return $this->redirectToRoute('bodytype_index');
    }

    /**
     * Creates a form to delete a BodyType entity.
     *
     * @param BodyType $bodyType The BodyType entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BodyType $bodyType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bodytype_delete', array('id' => $bodyType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

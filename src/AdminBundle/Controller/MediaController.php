<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Media;
use AdminBundle\Form\MediaType;

class MediaController extends Controller
{
    /**
     * @Route("/administration/multimedias", name="admin-medias")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $medias = $em->getRepository('AppBundle:Media')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($medias, $request->query->getInt('page', 1), 10);

        return $this->render('admin/media/medias.html.twig', array(
            'medias' => $pagination,
        ));
    }

    /**
     * @Route("/administration/multimedias/ajouter", name="admin-medias-add")
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(new MediaType(), new Media(), array(
            'method' => 'POST',
            'action' => $this->generateUrl('admin-medias-add')
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            $this->get('meli.flasher')->flashSuccess('La gallerie a été créée.');

            return $this->redirectToRoute('admin-medias');
        }

        return $this->render('admin/media/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/administration/multimedias/{id}", name="admin-medias-gallery")
     * @Method({"GET", "POST"})
     * @ParamConverter("media", class="AppBundle:Media")
     */
    public function galleryAction(Media $media)
    {
        return $this->render('admin/media/gallery.html.twig', array(
            'media' => $media
        ));
    }
}

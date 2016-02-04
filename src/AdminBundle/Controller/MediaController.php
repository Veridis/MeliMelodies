<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Form\GalleryType;

class MediaController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/administration/multimedias", name="admin-medias")
     * @Method("GET")
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
     * @param Request $request
     * @return Response
     *
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
     * @param Media $media
     * @return Response
     *
     * @Route("/administration/multimedias/{id}", name="admin-medias-gallery")
     * @Method({"GET", "POST"})
     */
    public function galleryAction(Request$request, Media $media)
    {
        $currentUrl = $this->generateUrl('admin-medias-gallery', array('id' => $media->getId()));
        $form = $this->createForm(new GalleryType(), $media, array(
            'method' => 'POST',
            'action' => $currentUrl,
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($form->getData()->getGallery() as $file) {
                $file->upload();
            }
            $em->persist($form->getData());
            $em->flush();

            $this->get('meli.flasher')->flashSuccess(sprintf('%d fichiers ont été ajoutés à la gallerie "%s"',
                $form->getData()->getGallery()->count(), $media->getTitle()));

            return $this->redirect($currentUrl);
        }


        return $this->render('admin/media/gallery.html.twig', array(
            'media' => $media,
            'form' => $form->createView(),
        ));
    }
}

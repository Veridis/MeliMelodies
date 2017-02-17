<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\VideoType;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Media;
use AdminBundle\Form\MediaType;

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
     * @param Request $request
     * @param Media $media
     * @return Response
     *
     * @Route("/administration/multimedias/modifier/{id}", name="admin-medias-edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Media $media)
    {
        $form = $this->createForm(new MediaType(), $media, array(
            'method' => 'POST',
            'action' => $this->generateUrl('admin-medias-edit', array('id' => $media->getId()))
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            $this->get('meli.flasher')->flashSuccess('La gallerie a été Modifiée.');

            return $this->redirectToRoute('admin-medias');
        }

        return $this->render('admin/media/edit.html.twig', array(
            'form' => $form->createView(),
            'media' => $media,
        ));
    }

    /**
     * @param Media $media
     * @return Response
     *
     * @Route("/administration/multimedias/{id}", name="admin-medias-gallery")
     * @Method({"GET", "POST"})
     */
    public function galleryAction(Request $request, Media $media)
    {
        if (Media::CATEGORY_IMAGE === $media->getCategory()) {
            $currentUrl = $this->generateUrl('admin-medias-gallery', array('id' => $media->getId()));
            $form = $this->createForm(new FileType(), null, array(
                'method' => 'POST',
                'action' => $currentUrl,
            ));
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->getData();
                $file->upload();
                $media->addGallery($file);
                $em = $this->getDoctrine()->getManager();
                $em->persist($file);
                $em->persist($media);
                $em->flush();

                $this->get('meli.flasher')->flashSuccess(sprintf('Le fichier %s a été ajouté avec succès.', $file->getName()));

                return $this->redirect($currentUrl);
            }


            return $this->render('admin/media/gallery.html.twig', array(
                'media' => $media,
                'form' => $form->createView(),
            ));
        } elseif (Media::CATEGORY_VIDEO === $media->getCategory()) {
            $currentUrl = $this->generateUrl('admin-medias-gallery', array('id' => $media->getId()));
            $form = $this->createForm(new VideoType(), null, array(
                'method' => 'POST',
                'action' => $currentUrl,
            ));
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $code = $form->getData()['code'];
                $title = $form->getData()['title'];
                $media->addVideo($code, $title);
                $em = $this->getDoctrine()->getManager();
                $em->persist($media);
                $em->flush();

                $this->get('meli.flasher')->flashSuccess(sprintf('La video a été ajoutée avec succès.'));

                return $this->redirect($currentUrl);
            }


            return $this->render('admin/media/gallery.html.twig', array(
                'media' => $media,
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @param int $id
     * @param int $fileId
     * @return Response
     *
     * @Route("/administration/multimedias/{id}/remove-image/{fileId}", name="admin-medias-gallery-remove-image")
     * @Method({"GET", "POST"})
     */
    public function removeImageAction($id, $fileId)
    {
        $em = $this->getDoctrine()->getManager();
        $media = $em->getRepository('AppBundle:Media')->findOneWithRelations($id);
        $file = $em->getRepository('AppBundle:File')->find($fileId);
        $media->removeGallery($file);
        $em->remove($file);
        $em->persist($media);
        $em->flush();

        return $this->redirectToRoute('admin-medias-gallery', array(
            'id' => $id,
        ));
    }

    /**
     * @param int $id
     * @param string $ytCode
     * @return Response
     *
     * @Route("/administration/multimedias/{id}/remove-video/{ytCode}", name="admin-medias-gallery-remove-video")
     * @Method({"GET", "POST"})
     */
    public function removeVideoAction($id, $ytCode)
    {
        $em = $this->getDoctrine()->getManager();
        $media = $em->getRepository('AppBundle:Media')->findOneWithRelations($id);
        $videos = $media->getVideos();
        unset($videos[$ytCode]);
        $media->setVideos($videos);
        $em->persist($media);
        $em->flush();

        return $this->redirectToRoute('admin-medias-gallery', array(
            'id' => $id,
        ));
    }
}

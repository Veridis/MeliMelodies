<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\GuestBookPost;
use AppBundle\Form\GuestBookPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestBookController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/livre-dor/ajouter", name="guestbook-add")
     * @Method("POST")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new GuestBookPostType(), new GuestBookPost(), array(
            'method' => 'POST',
            'action' => $this->generateUrl('guestbook-add'),
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();
            $this->get('meli.flasher')->flashSuccess('Votre message a bien été envoyé. Il apparaîtra une fois ce dernier validé. Merci !');

            return $this->redirectToRoute('guestbook');
        } else {
            $this->get('meli.flasher')->flashDanger('Votre message n\'a pas pu être posté. Il y a des erreurs dans votre formulaire.');
            $posts = $em->getRepository('AppBundle:GuestBookPost')->findAllUnarchived();
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate($posts, $request->query->getInt('page', 1), 10);

            return $this->render('app/app/guestbook.html.twig', array(
                'form' => $form->createView(),
                'posts' => $pagination,
            ));
        }
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/administration/livre-dor", name="admin-guestbook")
     * @Method("GET")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $members = $em->getRepository('AppBundle:GuestBookPost')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($members, $request->query->getInt('page', 1), 10);

        return $this->render('admin/guestbook/guestbook.html.twig', array(
            'posts' => $pagination,
        ));
    }

    /**
     * @param Request $request
     * @param GuestBookPost $post
     * @return Response
     *
     * @Route("/administration/livre-dor/archiver/{post}", name="admin-guestbook-toggle-archive")
     * @Method("GET")
     */
    public function toggleArchiveAction(Request $request, GuestBookPost $post)
    {
        $em = $this->getDoctrine()->getManager();
        $post->toggleArchived();
        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('admin-guestbook', array('page' => $request->query->get('page')));
    }
}

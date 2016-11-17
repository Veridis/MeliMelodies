<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\News;
use AppBundle\Form\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewsController
 * @Route("/administration")
 */
class NewsController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/news", name="admin-news")
     * @Method("GET")
     */
    public function newsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('AppBundle:News')->findAllWithJoin();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($news, $request->query->getInt('page', 1), 10);

        return $this->render('admin/news/news.html.twig', array(
            'news' => $pagination,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("news/ajouter", name="admin-news-add")
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(new NewsType(), new News(), array(
            'method' => 'POST',
            'action' => $this->generateUrl('admin-news-add')
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $news = $form->getData();
            $news->setAuthor($this->getUser());
            $em->persist($news);
            $em->flush();

            $this->get('meli.flasher')->flashSuccess('La news a été créée.');

            return $this->redirectToRoute('admin-news');
        }

        return $this->render('admin/news/add.html.twig', array(
            'form' => $form->createView(),
            'submit' => 'Ajouter',
        ));
    }

    /**
     * @param Request $request
     * @param News $news
     * @return Response
     *
     * @Route("news/modifier/{news}", name="admin-news-edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, News $news)
    {
        $form = $this->createForm(new NewsType(), $news, array(
            'method' => 'POST',
            'action' => $this->generateUrl('admin-news-edit', array('news' => $news->getId())),
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $news = $form->getData();
            $em->persist($news);
            $em->flush();

            $this->get('meli.flasher')->flashSuccess('La news a été modifiée.');

            return $this->redirectToRoute('admin-news');
        }

        return $this->render('admin/news/add.html.twig', array(
            'form' => $form->createView(),
            'submit' => 'Modifier',
        ));
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return Response
     *
     * @Route("news/appercu/{slug}", name="admin-news-show")
     * @Method("GET")
     */
    public function showAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('AppBundle:News')->findOneBySlug($slug);



        return $this->render('admin/news/show.html.twig', array(
            'news' => $news,
        ));
    }
}

<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\File;
use AppBundle\Entity\Member;
use AppBundle\Form\MemberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MemberController extends Controller
{
    /**
     * @Route("/administration/presentation", name="admin-presentation")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $members = $em->getRepository('AppBundle:Member')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($members, $request->query->getInt('page', 1), 10);

        return $this->render('admin/presentation/presentation.html.twig', array(
            'members' => $pagination,
        ));
    }

    /**
     * @Route("/administration/presentation/membre/ajouter", name="admin-member-add")
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(new MemberType(), new Member(), array(
            'method' => 'POST',
            'action' => $this->generateUrl('admin-member-add')
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $member = $form->getData();
            $file = new File();
            $file->setFile($request->files->get('member')['photo']);
            $file->upload();
            $member->setPhoto($file);
            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();

            $this->get('meli.flasher')->flashSuccess('Le membre a été créée.');

            return $this->redirectToRoute('admin-presentation');
        }

        return $this->render('admin/presentation/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\File;
use AppBundle\Entity\Member;
use AppBundle\Form\MemberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Image;

class MemberController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/administration/presentation", name="admin-presentation")
     * @Method("GET")
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
     * @param Request $request
     * @return Response
     *
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
            $ic = $this->getImageMemberConstraint();
            $errors = $this->get('validator')->validate($request->files->get('member')['photo'], $ic);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $form->get('photo')->addError(new FormError($error->getMessage()));
                }

                return $this->render('admin/presentation/add.html.twig', array(
                    'form' => $form->createView(),
                ));
            }
            $em = $this->getDoctrine()->getManager();
            $member = $form->getData();
            $file = new File();
            $file->setFile($request->files->get('appbundle_member')['photo']);
            $file->upload();
            $member->setPhoto($file);
            $em->persist($member);
            $em->flush();

            $this->get('meli.flasher')->flashSuccess('Le membre a été créée.');

            return $this->redirectToRoute('admin-presentation');
        }

        return $this->render('admin/presentation/add.html.twig', array(
            'form' => $form->createView(),
            'submit' => 'Ajouter',
        ));
    }

    /**
     * @param Request $request
     * @param Member $member
     * @return Response
     *
     * @Route("/administration/presentation/membre/modifier/{member}", name="admin-member-edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Member $member)
    {
        $form = $this->createForm(new MemberType(), $member, array(
            'method' => 'POST',
            'action' => $this->generateUrl('admin-member-edit', array('member' => $member->getId())),
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ic = $this->getImageMemberConstraint();
            $errors = $this->get('validator')->validate(
                $request->files->get('member')['photo'],
                $ic
            );
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $form->get('photo')->addError(new FormError($error->getMessage()));
                }

                return $this->render('admin/presentation/add.html.twig', array(
                    'form' => $form->createView(),
                ));
            }

            $member = $form->getData();
            if (null !== $request->files->get('member')['photo']) {
                $file = new File();
                $file->setFile($request->files->get('member')['photo']);
                $file->upload();
                $member->setPhoto($file);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();

            $this->get('meli.flasher')->flashSuccess('Le membre a été modifié.');

            return $this->redirectToRoute('admin-presentation');
        }

        return $this->render('admin/presentation/add.html.twig', array(
            'form' => $form->createView(),
            'submit' => 'Modifier',
        ));
    }

    /**
     * @param Member $member
     * @return Response
     *
     * @Route("/administration/presentation/membre/appercu/{id}", name="admin-member-appercu")
     * @Method("GET")
     */
    public function appercuAction(Member $member)
    {
        return $this->render('admin/presentation/member_widget.html.twig', array(
            'member' => $member,
        ));
    }

    /**
     * @return Image
     */
    private function getImageMemberConstraint()
    {
        $ic = new Image();
        $ic->minHeight = 200;   $ic->maxHeight = 500;
        $ic->minWidth = 200;    $ic->maxWidth = 500;
        $ic->allowPortrait = false; $ic->allowLandscape = false;
        $ic->maxHeightMessage = $ic->maxWidthMessage = $ic->minWidthMessage = $ic->minHeightMessage
            = 'La hauteur et la largeur doivent être comprises entre 200px et 500px';
        $ic->allowPortraitMessage = $ic->allowLandscapeMessage
            = 'Le format de l\'image doit être carrée (hauteur égale largeure)';

        return $ic;
    }
}

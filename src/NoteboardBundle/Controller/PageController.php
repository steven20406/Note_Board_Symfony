<?php

namespace NoteboardBundle\Controller;

use NoteboardBundle\Entity\Boarddata;
use NoteboardBundle\Entity\Comment;
use NoteboardBundle\Form\BoarddataType;
use NoteboardBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction(Request $request) {
        $boarddata = new Boarddata();
        $form = $this->createForm(BoarddataType::class, $boarddata);

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Boarddata::class);
        $noteData = $repository->findNote($repository);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $doctrine->getManager();
                $em->persist($boarddata);
                $em->flush();

                return $this->redirect($request->getUri());
            }
        }

        return $this->render('NoteboardBundle:Page:index.html.twig',
                array(
                        'form' => $form->createView(),
                        'datas' => $noteData
                ));
    }

    public function aboutAction($page, Request $request) {

        $noteRepository = $this->getDoctrine()->getRepository(Boarddata::class);
        $noteData = $noteRepository->findOne($page, $noteRepository);

        $repository = $this->getDoctrine()->getRepository(Comment::class);
        $commentData = $repository->getComments($page, $repository);

        $comment = new Comment();
        $comment->setCommentNoteID($noteData);

        $form = $this->createForm(CommentType::class, $comment);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                return $this->redirect($request->getUri());
            }
        }

        return $this->render('NoteboardBundle:Page:about.html.twig',
                array(
                        'form' => $form->createView(),
                        'noteData' => $noteData,
                        'commentData' => $commentData,
                ));
    }

    public function editAction($page, Request $request)
    {
        $noteRepository = $this->getDoctrine()->getRepository(Boarddata::class);
        $noteData = $noteRepository->findOne($page, $noteRepository);

        $boarddata = new Boarddata();
        $form = $this->createForm(BoarddataType::class, $boarddata);

        if($request->getMethod() == 'POST'){
            $form->handleRequest($request);

            if($form->isValid()){
                $note = $form->getData();
                $em = $this->getDoctrine()->getRepository(Boarddata::class)
                        ->editNote($page, $note);
                return $this->redirect($request->getUri());
            }
        }

        return $this->render('NoteboardBundle:Page:edit.html.twig',array(
                'form' => $form->createView(),
                'noteData' => $noteData
        ));
    }
}
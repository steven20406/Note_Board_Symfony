<?php

namespace NoteboardBundle\Controller;

use NoteboardBundle\Entity\Boarddata;
use NoteboardBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller {
    /**
     * Index page
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request) {
        $boarddata = new Boarddata();
        $form = $this->createForm('NoteboardBundle\Form\BoarddataType', $boarddata);

        $em = $this->getDoctrine()->getManager('default');
        $noteData = $em->getRepository('NoteboardBundle:Boarddata')->findAll();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em->persist($boarddata);
                $em->flush();

                return $this->redirect($request->getUri());
            }
        }

        return $this->render(
                'NoteboardBundle:Page:index.html.twig', [
                        'form' => $form->createView(),
                        'datas' => $noteData,
                        ]);
    }

    /**
     * Note page
     *
     * @param $page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction($page, Request $request) {
        $em = $this->getDoctrine()->getManager('default');

        $noteData = $em->getRepository('NoteboardBundle:Boarddata')->findOne($page);

        $commentData = $em->getRepository('NoteboardBundle:Comment')->getComments($page);

        $comment = new Comment();
        $comment->setCommentNoteId($noteData);

        $form = $this->createForm('NoteboardBundle\Form\CommentType', $comment);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em->persist($comment);
                $em->flush();

                return $this->redirect($request->getUri());
            }
        }

        return $this->render(
                'NoteboardBundle:Page:about.html.twig', [
                        'form' => $form->createView(),
                        'noteData' => $noteData,
                        'commentData' => $commentData,
                        ]);
    }

    /**
     * Edit page
     *
     * @param $page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($page, Request $request) {
        $noteRepository = $this->getDoctrine()->getRepository('NoteboardBundle:Boarddata');
        $noteData = $noteRepository->findOne($page);

        $boarddata = new Boarddata();
        $form = $this->createForm('NoteboardBundle\Form\BoarddataType', $boarddata);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $note = $form->getData();
                $edit = $noteRepository->editNote($page, $note);

                return $this->redirect($request->getUri());
            }
        }

        return $this->render(
                'NoteboardBundle:Page:edit.html.twig', [
                        'form' => $form->createView(),
                        'noteData' => $noteData
                ]);
    }

    /**
     * @Route("/admin")
     * @return Response
     */
    public function adminAction() {
        return new Response('<html><body>Admin page</body></html>');
    }
}
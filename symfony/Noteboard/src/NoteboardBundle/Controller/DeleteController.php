<?php

namespace NoteboardBundle\Controller;

use NoteboardBundle\Entity\Boarddata;
use NoteboardBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeleteController extends Controller {
    /**
     * Delete note and comments
     *
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($page) {
        $em = $this->getDoctrine()->getManager('default');
        $emComment = $em->getRepository('NoteboardBundle:Comment')->deleteComments($page);
        $emNote = $em->getRepository('NoteboardBundle:Boarddata')->deleteNote($page);

        $response = $this->forward('NoteboardBundle:Page:index');

        return $response;
    }
}
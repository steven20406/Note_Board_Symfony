<?php

namespace NoteboardBundle\Controller;

use NoteboardBundle\Entity\Boarddata;
use NoteboardBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeleteController extends Controller
{
    public function deleteAction($page)
    {
        $emComment = $this->getDoctrine()->getRepository(Comment::class)->deleteComments($page);
        $emNote = $this->getDoctrine()->getRepository(Boarddata::class)->deleteNote($page);

        $response = $this->forward('NoteboardBundle:Page:index');
        return $response;
    }
}
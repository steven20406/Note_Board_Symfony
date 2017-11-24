<?php

namespace NoteboardBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function getComments($noteId,CommentRepository $repository)
    {
        $comments = $repository->findBy(
                array('commentNoteID' => $noteId)
        );

        return $comments;
    }

    public function deleteComments($noteId)
    {
        $em = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NoteboardBundle:Comment', 'c')
                ->where('c.commentNoteID = ?1')
                ->setParameter(1, $noteId)
                ->getQuery()->execute();
    }
}
<?php

namespace NoteboardBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository {
    /**
     * Get all comments
     *
     * @param $noteId
     * @return mixed
     */
    public function getComments($noteId) {
        $comments = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('c')
                ->from('NoteboardBundle:Comment', 'c')
                ->where('c.comment_note_id = :id')
                ->setParameter('id', $noteId)
                ->getQuery()->execute();

        return $comments;
    }

    /**
     * Delete all comments
     *
     * @param $noteId
     */
    public function deleteComments($noteId) {
        $em = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NoteboardBundle:Comment', 'c')
                ->where('c.comment_note_id = :id')
                ->setParameter('id', $noteId)
                ->getQuery()->execute();
    }
}
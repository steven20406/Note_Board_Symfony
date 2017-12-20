<?php

namespace NoteboardBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NoteboardBundle\Entity\Boarddata;

class BoarddataRepository extends EntityRepository {
    /**
     * Fine one note by note id
     *
     * @param $noteId
     * @return Boarddata|null|object
     */
    public function findOne($noteId) {
        $data = $this->getEntityManager()
                ->getRepository(Boarddata::class)
                ->find($noteId);

        return $data;
    }

    /**
     * Delete one note by note id
     *
     * @param $noteId
     */
    public function deleteNote($noteId) {
        $em = $this->getEntityManager('default')
                ->createQueryBuilder()
                ->delete('NoteboardBundle:Boarddata', 'b')
                ->where('b.id = :id')
                ->setParameter('id', $noteId)
                ->getQuery()->execute();
    }

    /**
     * Edit note text
     *
     * @param $noteId
     * @param $note
     */
    public function editNote($noteId, $note) {
        $em = $this->getEntityManager('default')
                ->createQueryBuilder()
                ->update('NoteboardBundle:Boarddata', 'b')
                ->where('b.id = :id')
                ->set('b.note', ':note')
                ->setParameter('id', $noteId)
                ->setParameter('note', $note->getNote())
                ->getQuery()->execute();
    }
}
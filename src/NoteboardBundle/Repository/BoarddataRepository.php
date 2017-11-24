<?php

namespace NoteboardBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BoarddataRepository extends EntityRepository
{
    public function findNote(BoarddataRepository $repository)
    {
        $data = $repository->findAll();

        return $data;
    }

    public function findOne($noteId ,BoarddataRepository $repository)
    {
        $data = $repository->find($noteId);

        return $data;
    }

    public function deleteNote($noteId)
    {
        $em = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NoteboardBundle:Boarddata', 'b')
                ->where('b.id = ?1')
                ->setParameter(1, $noteId)
                ->getQuery()->execute();
    }

    public function editNote($noteId, $note)
    {
        $em = $this->getEntityManager()
                ->createQueryBuilder()
                ->update('NoteboardBundle:Boarddata', 'b')
                ->where('b.id = ?1')
                ->set('b.note', '?2')
                ->setParameter(1,$noteId)
                ->setParameter(2,$note->getNote())
                ->getQuery()->execute();
    }
}
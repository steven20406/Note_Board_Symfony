<?php
    require_once "../bootstrap.php";

    $id = $_GET["id"];

    $qb = $entityManager->createQueryBuilder();

    $query = $qb->delete('Comment', 'c')
        ->where('c.commentNoteID  = ?1')
        ->setParameter(1, $id);

    $execute = $query->getQuery()->execute();
    $query = $qb->delete('Boarddata', 'b')
        ->where('b.id = ?1')
        ->setParameter(1, $id);
    $execute = $query->getQuery()->execute();


    header("Location: /index.php");
    exit();

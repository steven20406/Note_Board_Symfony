<?php
    require_once "../bootstrap.php";

    $id = $_POST["note_id"];
    $name = $_POST["edit_user_name"];
    $text = $_POST["edit_note_text"];

    $qb = $entityManager->createQueryBuilder();
    $query = $qb->select('b')
        ->from('Boarddata', 'b')
        ->where('b.id = ?1')
        ->setParameter(1, $id);

    $result = $query->getQuery()->getResult();

    foreach ($result as $data) {
        if ($name != $data->getUserName()) {
            echo "<script type = 'text/javascript'>alert('Not your note!');</script>";
            echo "<script type = 'text/javascript'>window.location = '/edit_note.php?id=$id';</script>";
            exit();
        }
    }

    $query = $qb->update('Boarddata', 'a')
        ->set('a.note', '?1')
        ->where('a.id = ?2')
        ->setParameter(1, $text)
        ->setParameter(2, $id);
    $execute = $query->getQuery()->execute();

    header("Location: /index.php");
    exit();

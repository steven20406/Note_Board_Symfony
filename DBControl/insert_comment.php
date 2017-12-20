<?php
    require_once "../bootstrap.php";
    require_once "../src/Comment.php";
    require_once '../bootstrap.php';

    $id = $_POST["note_id"];
    $name = $_POST["reply_name"];
    $text = $_POST["reply_note"];

    $Boarddata = $entityManager->find('Boarddata',$id);

    $comment = new Comment();
    $comment->setCommentNoteID($Boarddata);
    $comment->setCommentUsername($name);
    $comment->setCommentNotetext($text);

    $entityManager->persist($comment);
    $entityManager->flush();

    header("Location: /note_info.php?id=$id");
    exit();

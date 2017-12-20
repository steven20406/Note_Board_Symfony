<?php
    require_once "../bootstrap.php";
    require_once "../src/Boarddata.php";

    $name = $_POST["user_name"];
    $note = $_POST["user_note"];

    $boardData = new Boarddata();
    $boardData->setUsername($name);
    $boardData->setNote($note);

    $entityManager->persist($boardData);
    $entityManager->flush();

    header("Location: /index.php");
    exit();

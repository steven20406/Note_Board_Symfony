<!doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <script type = "text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type = "text/javascript" src = "//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel = "stylesheet" href = "//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script>
        $(document).ready(function () {
            $('#note_table').DataTable();
        });
    </script>
    <title>Index</title>
</head>
<body>
<h1 align = "center" style = "font-family: Arial Black">Note Board</h1>
<br>

<table id = "note_table" border = 1>
    <thead>
    <tr>
        <th>Note No.
        <th>User
        <th>Note
        <th>Comment
        <th>Delete
        <th>Edit
    </tr>
    </thead>

    <tbody>
    <?php
        require_once 'bootstrap.php';
        $qb = $entityManager->createQueryBuilder();
        $query = $qb->select('b')
            ->from('boarddata', 'b');
        $result = $query->getQuery()->getResult();

        $Boarddata = $entityManager->getRepository("boarddata")->findAll();

        foreach ($Boarddata as $data)
        {
        ?>
        <tr>
            <td><?php echo $data->getId() ?>
            <td><?php echo $data->getUsername() ?>
            <td><?php echo $data->getNote() ?>
            <td><a href = "note_info.php?id=<?php echo $data->getId() ?>"><?php echo count($data->getComments())?> Reply</a>
            <td><a href = "DBControl/delete_data.php?id=<?php echo $data->getId() ?>">Delete</a>
            <td><a href = "edit_note.php?id=<?php echo $data->getId() ?>">Edit</a>
        </tr>
    <?php } ?>
    </tbody>
</table>
<br>
<form name = "new_note" method = "post" action = "DBControl/insert_data.php" onsubmit = "return checkData()">
    <input name = "user_name" id = "user_name" type = "text" placeholder = "Your name">
    <input name = "user_note" id = "user_note" type = "text" placeholder = "Your note here">
    <button type = "submit" id = "note_submit">Submit</button>
</form>

<script>
    function checkData()
    {
        if ($("#user_name").val() == "") {
            alert("Enter user name!");

            return false;
        }
        if ($("#user_note").val() == "") {
            alert("Enter note!");

            return false;
        }
    }
</script>
</body>
</html>

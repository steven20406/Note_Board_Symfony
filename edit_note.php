<!doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type = "text/javascript" src = "//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel = "stylesheet" href = "//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <title>Edit Note</title>
    <script>
        $(document).ready(function () {
            $('#note_table').DataTable();
        });
    </script>
</head>
<body>
<h1>Edit Note</h1>

<a href = "/index.php">Back</a>

<table id = "note_table" border = 1>
    <thead>
    <tr>
        <td>Note No.
        <td>User
        <td>Note
    </thead>

    <?php
        require_once "bootstrap.php";

        $id = $_GET["id"];
        $qb = $entityManager->createQueryBuilder();
        $query = $qb->select('b')
            ->from('Boarddata', 'b')
            ->where('b.id = ?1')
            ->setParameter(1, $id);
        $result = $query->getQuery()->getResult();

        foreach ($result as $row)
        {
    ?>
    <tr>
        <td><?php echo $row->getId() ?>
        <td><?php echo $row->getUsername() ?>
        <td><?php echo $row->getNote() ?>
            <?php } ?>
</table>
<br>
<form name = "edit_note" action = "DBControl/edit_data.php" method = "POST" onsubmit = "return checkData()">
    <input name = "edit_user_name" id = "edit_user_name" type = "text" placeholder = "Your name"
           value = "<?php echo $row->getUsername() ?>">
    <input name = "edit_note_text" id = "edit_note_text" type = "text" placeholder = "Your note here"
           value = "<?php echo $row->getNote() ?>">
    <input hidden name = "note_id" type = "number" value = <?php echo $row->getId() ?>>
    <button type = "submit" id = "edit_submit">Submit</button>
</form>
<script>
    function checkData()
    {
        if ($("#edit_user_name").val() == "") {
            alert("Enter user name!");

            return false;
        }
        if ($("#edit_note_text").val() == "") {
            alert("Enter note!");

            return false;
        }
    }
</script>
</body>
</html>

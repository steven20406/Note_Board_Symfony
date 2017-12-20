<!doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type = "text/javascript" src = "//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel = "stylesheet" href = "//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <title>Note Information</title>
    <script>
        $(document).ready(function () {
            $('#note_table').DataTable();

            $('#title').DataTable();
        });
    </script>
</head>
<body>
<h1>Note Information</h1>

<a href = "/index.php">Back</a>

<table id = "title" border = 1>
    <tr>
        <td>Note No.
        <td>User
        <td>Note
            <?php
                require_once('bootstrap.php');
                $id = $_GET["id"];
                $qb = $entityManager->createQueryBuilder();
                $qb->select('b')
                    ->from('Boarddata', 'b')
                    ->where('b.id = ?1')
                    ->setParameter(1, $id);
                $q = $qb->getQuery();
                $result = $q->getResult();

                foreach ($result as $data)
                {
            ?>
    <tr>
        <td><?php echo $data->getId() ?>
        <td><?php echo $data->getUsername() ?>
        <td><?php echo $data->getNote() ?>
</table>

            <?php
                }
            ?>

<p>Replies</p>
<table id = "note_table" border = 1>
    <thead>
    <tr>
        <td>User
        <td>Reply Text
    </thead>
    <?php
        $qb = $entityManager->createQueryBuilder();
        $qb->select('c')
            ->from('Comment', 'c')
            ->where('c.commentNoteID = ?1')
            ->setParameter(1, $id);
        $q = $qb->getQuery();
        $result = $q->getResult();

        foreach ($result as $data)
        {
    ?>
    <tr>
        <td><?php echo $data->getCommentUserName() ?>
        <td><?php echo $data->getCommentNoteText() ?>

            <?php
            }
            ?>
</table>
<br>
<form name = "new_note" method = "post" action = "DBControl/insert_comment.php" onsubmit = "return checkData()">
    <input name = "reply_name" id = "reply_name" type = "text" placeholder = "Your name">
    <input name = "reply_note" id = "reply_note" type = "text" placeholder = "Your reply here">
    <input hidden name = "note_id" type = "number" value = <?php echo $id ?>>
    <button type = "submit" id = "note_submit">Submit</button>
</form>

<script>
    function checkData()
    {
        if ($("#reply_name").val() == "") {
            alert("Enter user name!");

            return false;
        }
        if ($("#reply_note").val() == "") {
            alert("Enter note!");

            return false;
        }
    }
</script>
</body>
</html>

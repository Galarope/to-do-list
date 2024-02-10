<?php 
$errors = "";

//connect to database
$db = mysqli_connect('localhost', 'root', '', 'todo', 3306);


if(isset($_POST['submit'])){
    $task = $_POST['task'];

    if (empty($task)){
        $errors = "Vous devez entrer une tâche.";
    }else{
        $sql_insert = "INSERT INTO tasks (task) VALUES ('$task')"; 
        $stmt = mysqli_prepare($db, $sql_insert);

         mysqli_stmt_execute($stmt);

        //  mysqli_stmt_bind_param($stmt, "s", $task);
    
         $result = mysqli_stmt_get_result($stmt);

         header('location: index.php');
    }

}

// delete task

if(isset($_GET['del_task'])){
    $id = $_GET['del_task'];

    $sql_del = "DELETE FROM tasks WHERE id=$id";
    $stmt3 = mysqli_prepare($db, $sql_del);

    mysqli_stmt_execute($stmt3);

    $del_confirm = mysqli_stmt_get_result($stmt3);

    header('location: index.php');
}

$sql_select = "SELECT * FROM tasks";
$stmt2 = mysqli_prepare($db, $sql_select);

mysqli_stmt_execute($stmt2);

$tasks = mysqli_stmt_get_result($stmt2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do-list</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="heading">
        <h2>To-do-list</h2>
    </div>

    <form action="index.php" method="POST">

    <?php
    if(isset($errors)){ ?>
        <p><?php echo $errors; ?></p>
    <?php } ?>


        <input type="text" name="task" class="task_input">
        <button type="submit" class="add_btn" name="submit">Ajouter une to-do-tâche</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Tâche</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 1;
            while($row = mysqli_fetch_array($tasks)){ ?>
             <tr>
                <td class="task_number"><?php echo $i; ?></td>
                <td class="task"><?php echo $row['task']; ?></td>
                <td class="delete"><a href="index.php?del_task=<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i></a></td>

            </tr>
            <?php $i++; } ?>

           
        </tbody>
    </table>

    <script src="https://kit.fontawesome.com/ceac52fb77.js" crossorigin="anonymous"></script>
</body>
</html>
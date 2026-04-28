<?php
require "../../dbhandle/connection.php";
$conn=connection();
try {
    $sql="SELECT * FROM courses JOIN users on users.id=courses.user_id";
    $stm=$conn->prepare($sql);
    $stm->execute();
    $courses=$stm->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="">
        <button>Create Cours</button>
    </form>
    <table>
        <tr>
            <td>title</td>
            <td>desciption</td>
            <td>totalHours</td>
            <td>prof</td>
        </tr>
        <tr>
            <?php
            foreach($courses as $course){
                ?>
                <td><?= $course["title"]?></td>
                <td><?= $course["description"]?></td>
                <td><?= $course["total_hours"]?></td>
                <td><?= "Prof ".$course["firstName"]." ".$course["lastName"]?></td>
                </tr>
                <?php
            }
            ?>
    </table>
</body>
</html>
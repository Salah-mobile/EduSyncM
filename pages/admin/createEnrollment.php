<?php
include "../../dbhandle/connection.php";
$conn =connection();
try {
    $sql="SELECT e.id,u.firstName,u.lastName,c.title,e.status,e.enrolled_at 
    FROM enrollments e 
    JOIN courses c ON c.id=e.course_id 
    JOIN students s ON s.id=e.student_id
    JOIN users u ON u.id=s.user_id
    ";
    $stm=$conn->prepare($sql);
    $stm->execute();
    $enrollments=$stm->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if(isset($_POST["delete"])){
    $enrId=$_POST["delete"];
    try {
        $sql="DELETE FROM enrollments WHERE id=?";
        $stm=$conn->prepare($sql);
        $stm->execute([$enrId]);
        header("Location: createEnrollment.php");
        exit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
if(isset($_POST["createE"])){
    header("Location:fromCreateEnrollment.php");
    exit();
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
    <h1>Gestionner Enrollment</h1>
    <form action="" method="post">
        <button name="createE">Create Enrollment</button>
    </form>
    <table>
        <tr>
            <td>name Student</td>
            <td>name course</td>
            <td>status</td>
            <td>enrolled_at</td>
        </tr>
        <tr>
            <?php
            foreach($enrollments as $enr){
                ?>
                <td><?=$enr["firstName"]." ".$enr["lastName"]?></td>
                <td><?=$enr["title"]?></td>
                <td><?=$enr["status"]?></td>
                <td><?=$enr["enrolled_at"]?></td>
                <td>
                  <form action="#" method="post">
                      <button name="delete" value="<?=$enr["id"]?>">Delete</button>
                    <button name="update" value="<?=$enr["id"]?>">Update</button>
                </form>
                </td>
                </tr>
                <?php
            }
            ?>
    </table>
</body>
</html>
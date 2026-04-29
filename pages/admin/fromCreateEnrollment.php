<?php
include "../../dbhandle/connection.php";
$conn =connection();
try {
    $sql="SELECT * FROM courses";
    $stm=$conn->prepare($sql);
    $stm->execute()
    $courses=$stm->fetchAll();
    $sql="SELECT * FROM students
     JOIN users ON users.id=students.user_id 
     "
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
    
</body>
</html>
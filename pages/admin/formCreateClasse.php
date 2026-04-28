<?php
require "../../dbhandle/connection.php";
$conn=connection();
if(isset($_POST["createC"])){
    $nameC=$_POST["classeN"];
    $roomN=$_POST["classeNM"];
    try {
        $sql="INSERT INTO classes (name,classroom_number) values (?,?)";
        $stm=$conn->prepare($sql);
        $stm->execute([$nameC,$roomN]);
        header("Location:createClasse.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

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
    <form action="#" method="post">
        <label for="">nom de classe</label>
        <input type="text" placeholder='Classe Name' name="classeN" required>
        <label for="">classe room number</label>
        <input type="Number" min=0 placeholder='classe room number' name="classeNM" required>
        <button name="createC">Create Classe</button>
    </form>
</body>
</html>
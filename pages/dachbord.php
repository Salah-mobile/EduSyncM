<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome in the dechbord page  <?php 
    session_start();
if(!empty($_SESSION["Fname"]) && !empty($_SESSION["Lname"])) {
    echo "Mr " . $_SESSION["Fname"] . " " . $_SESSION["Lname"];
} ?></h1>
<form action="" method="post">
    <button type="submit" name="logout" >D'éconnection</button>
</form>
</body>
</html> 
<?php
if(isset($_POST["logout"])){
    session_destroy();  
    header("Location:../pages/signuppage.php");
}
?>
<?php
session_start();
if(empty($_SESSION["Fname"])|| empty($_SESSION["role"])){
        header("Location../signuppage.php");
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

</body>
</html>
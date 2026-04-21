<?php
include "../dbhandle/connection.php";
$conn=connection();
if(isset($_POST["signin"])){
    $email=$_POST["email"];
    $password=$_POST["password"];
    if(connectpass($email,$password,$conn)==true){
        header("Location:../pages/dachbord.php");
        exit();
    }else{
        header("Location:../pages/singinpage.php?psw=inc");
        exit();
    }
}else{
    header("Location:../pages/singinpage.php");
    exit();

}

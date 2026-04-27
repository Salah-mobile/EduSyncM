<?php
session_start();
if(empty($_SESSION["Fname"])){
        header("Location:signuppage.php");
        exit();
}else{
    echo var_dump($_SESSION["role"]);
    if($_SESSION["role"]==="1"){
        header("Location: admin/dachbordA.php");
        exit();
    }
    if($_SESSION["role"]==="2"){
        header("Location: prof/dachbordP.php");
        exit();
    }
    if($_SESSION["role"]==="3"){
         header("Location: student/dachbordS.php");
         exit();
    }
}
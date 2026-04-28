<?php
include "../dbhandle/connection.php";
$conn=connection();
function connectpass($email,$password,$conn){
    try {
        $sql ="SELECT * FROM users WHERE users.emil=? and users.password=?";
        $stm=$conn->prepare($sql);
        $stm->execute([$email,$password]);
        $user=$stm->fetch(PDO::FETCH_ASSOC);
         if($user){
           return $user;
        }
    } catch (PDOException $e) {
         echo "erreur connect acount"; 
    }
}
if(isset($_POST["signin"])){
    $email=$_POST["email"];
    $password=$_POST["password"];
    if(connectpass($email,$password,$conn)){
        session_start();
        $user=connectpass($email,$password,$conn);
        $_SESSION["Fname"]=$user["firstName"];
        $_SESSION["Lname"]=$user["lastName"];
        $_SESSION["role"]=$user["role_id"];
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

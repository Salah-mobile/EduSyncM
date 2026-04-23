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
           return true;
        }else{
            return false;
        }

    } catch (PDOException $e) {
         echo "erreur connect acount"; 
    }
}
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

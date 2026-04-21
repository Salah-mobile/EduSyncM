<?php
include "../dbhandle/connection.php";
 $conn=connection();
function verifierpas($password,$reppassword){
    if($password===$reppassword){
        return true;
    }else{
        return false;
    }
}
function verifierchamp($firstname,$lastname,$email,$password,$reppassword){
    if(empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($reppassword)){
        return false;
    }else{
        return true;
    }
}

function verfierU($email,$conn){
    try {
        $sql="SELECT * FROM users WHERE users.emil= ?";
        $stm=$conn->prepare($sql);
        $stm->execute([$email]);
        $user = $stm->fetch(PDO::FETCH_ASSOC);
        if($user){
           return true;
        }else{
            return false;
        }
    } catch (PDOException $e) {
         echo "ereur eamil verifi";   
    } 
}
function addStudent($firstname,$lastname,$email,$password,$conn){
    try {
        $sql="INSERT INTO  users (firstName,lastName,emil,password,role_id) VALUES (?,?,?,?,?)";
        $stm=$conn->prepare($sql);
        if($stm->execute([$firstname,$lastname,$email,$password,3])){
            echo $conn->lastInsertId();
        }
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}
if(isset($_POST["signU"])){
   $firstname=$_POST["firstname"];
   $lastname=$_POST["lastname"];
   $email=$_POST["email"];
   $password=$_POST["password"];
   $reppassword=$_POST["repasw"];
   if(verifierpas($password,$reppassword)==false){
     header("Location:../pages/loginpage.php?password=match");
     exit();
   }
    if(verifierchamp($firstname,$lastname,$email,$password,$reppassword)==false){
     header("Location:../pages/loginpage.php?empty=yes");
     exit();
   } 
   if(verfierU($email,$conn)){
     header("Location:../pages/singinpage.php?user=exist");
     exit();
   }
    addStudent($firstname,$lastname,$email,$password,$conn);
    header("Location:../pages/dachbord.php");
   
}else{
    header("Location:../pages/loginpage.php");
    exit();
}

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
         echo $e->getMessage();   
    } 
}
function addStudent($firstname,$lastname,$email,$password,$conn){
    try {
        $sql="INSERT INTO  users (firstName,lastName,emil,password,role_id) VALUES (?,?,?,?,?)";
        $stm=$conn->prepare($sql);
        $stm->execute([$firstname,$lastname,$email,$password,3]);
    } catch (PDOException $e) {
        echo "err lors de add";
    }
}
if(isset($_POST["signU"])){
   $firstname=$_POST["firstname"];
   $lastname=$_POST["lastname"];
   $email=$_POST["email"];
   $password=$_POST["password"];
   $reppassword=$_POST["repasw"];
   if(verifierpas($password,$reppassword)==false){
     header("Location:../pages/signuppage.php?password=match");
     exit();
   }
    if(verifierchamp($firstname,$lastname,$email,$password,$reppassword)==false){
     header("Location:../pages/signuppage.php?empty=yes");
     exit();
   } 
   if(verfierU($email,$conn)){
     header("Location:../pages/singinpage.php?user=exist");
     exit();
   }
   session_start();
   addStudent($firstname,$lastname,$email,$password,$conn);
   $_SESSION["email"]=$email;
   $_SESSION["Fname"]=$firstname;
   $_SESSION["Lname"]=$lastname;
    header("Location:../pages/dachbord.php");
   
}else{
    header("Location:../pages/signuppage.php");
    exit();
}


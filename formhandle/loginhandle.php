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
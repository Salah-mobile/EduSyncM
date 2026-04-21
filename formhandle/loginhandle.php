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
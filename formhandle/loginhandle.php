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
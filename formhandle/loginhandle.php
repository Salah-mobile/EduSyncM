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

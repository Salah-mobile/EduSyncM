<?php
if(isset($_POST["update"])){
    echo "welcom in update";
    $userId=$_POST["update"];
    echo $userId;
}
if(isset($_POST["delete"])){
   echo "welcom in delete";  
   $userId=$_POST["delete"];
   echo $userId;

}
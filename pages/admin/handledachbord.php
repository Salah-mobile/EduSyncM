<?php
include "../../dbhandle/connection.php";
if(isset($_POST["update"])){
    echo "welcom in update";
    $userId=$_POST["update"];
}
if(isset($_POST["delete"])){
   echo "welcom in delete";  
   $userId=$_POST["delete"];
    try {
        $conn =connection();
        $sql ="DELETE FROM users WHERE id=?";
        $stm=$conn->prepare($sql);
        $stm->execute([$userId]);
        header("Location: dachbordA.php?action:succ");
        exit();
    } catch (PDOException $e) {
       echo $e->getMessage();
    }

}
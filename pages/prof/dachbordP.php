<?php

session_start();
function connection(){
    try {
     $conn =new PDO("mysql:host=localhost;dbname=edusync", "root", "");
     return $conn;
} catch (PDOException $e) {
    echo "erreur connection";
    return null;
}
}



// Vérifier si l'utilisateur est un Prof
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Prof') {
    
    header('Location: login.php'); 
    exit();
    
    
    $prof_id = 1; 
} else {
    $prof_id = $_SESSION['user_id'];
}






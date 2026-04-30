<?php

session_start();
    try {
     $conn =new PDO("mysql:host=localhost;dbname=edusync", "root", "");
} catch (PDOException $e) {
    echo "erreur connection";

}



// Vérifier si l'utilisateur est un Prof
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Prof') {
    
    header('Location: login.php'); 
    exit();
    
    
    $prof_id = 1; 
} else {
    $prof_id = $_SESSION['user_id'];
}


// 2. Requête SQL pour l'US20 (Mes Enseignements)
$sql = "SELECT id, name, description, hours 
        FROM courses 
        WHERE teacher_id = :prof_id";

$stmt = $conn->prepare($sql);
$stmt->execute(['prof_id' => $prof_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>







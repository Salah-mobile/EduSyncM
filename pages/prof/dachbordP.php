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



if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'prof') {
    header("Location: ../../singinpage.php");
    exit;
}


$prof_id = $_SESSION['user']['id'];

// 4. Requête SQL (US20): Njibo ghir l-cours dial had l-prof
try {
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE instructor_id = ?");
    $stmt->execute([$prof_id]);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur SQL: " . $e->getMessage());
}
?>


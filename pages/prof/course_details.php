<?php
session_start();
require_once '../../dbhandle/connection.php';
$conn=connection();
// verfication des profs
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Prof') {
    header('Location: login.php');
    exit();
}


// url cours 
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID du cours manquant.");
}
$course_id = $_GET['id'];
$prof_id = $_SESSION['user_id'];


// 3. course de ce prof?(Security Check)
$check_sql = "SELECT id, name FROM courses WHERE id = :c_id AND teacher_id = :p_id";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->execute(['c_id' => $course_id, 'p_id' => $prof_id]);
$course = $check_stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die("Vous n'avez pas l'autorisation d'accéder à ce cours.");
}

// Jointure SQL pour les etudients
$sql = "SELECT 
            u.username, 
            u.email, 
            e.status, 
            e.enrolled_at 
        FROM users u
        INNER JOIN enrollments e ON u.id = e.student_id
        WHERE e.course_id = :c_id";

$stmt = $conn->prepare($sql);
$stmt->execute(['c_id' => $course_id]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
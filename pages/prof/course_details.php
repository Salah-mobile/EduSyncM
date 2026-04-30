<?php
session_start();
require_once 'db_connect.php';

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
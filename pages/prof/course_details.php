<?php
session_start();
require_once 'db_connect.php';

// verfication des profs
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Prof') {
    header('Location: login.php');
    exit();
}
<?php
// pages/prof/dachbordP.php°

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'prof') {
    header("Location: ../../singinpage.php");
    exit;
}


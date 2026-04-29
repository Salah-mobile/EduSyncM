<?php
// pages/prof/dachbordP.php°
require_once "../../dbhandle/connection.php";

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'prof') {
    header("Location: ../../singinpage.php");
    exit;
}

// 3. Kat-jib l-ID dial l-prof m-la session
$prof_id = $_SESSION['user']['id'];


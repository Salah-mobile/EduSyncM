<?php
function connection()
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=edusync12", "root", "");
        return $conn;
    } catch (PDOException $e) {
        echo "erreur connection";
        return null;
    }
}

<?php
function connection(){
    try {
     $conn =new PDO("mysql:host=localhost;dbname=edusync", "root", "");
     return $conn;
} catch (PDOException $e) {
    echo "erreur connection";
    return null;
}
}
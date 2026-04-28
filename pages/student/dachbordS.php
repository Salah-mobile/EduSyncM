<?php
session_start();
require_once "../../dbhandle/connection.php";

$conn=connection();
if (!isset($_SESSION["Fname"])) {
    header("Location: login.php");
    exit;
}
$email=$_SESSION["email"];
try {
    $sql="SELECT * 
        FROM users 
        JOIN students ON users.id = students.user_id 
        WHERE users.emil = ?";
    $stm=$conn->prepare($sql);
    $stm->execute([$email]);
    $user=$stm->fetch();
} catch (PDOException $e) {
    echo $e->getMessage();
}
$user_id = $user["user_id"];
$class_id = $user["classe_id"];
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">







<nav class="bg-blue-600 text-white p-4 flex justify-between">
    <h1 class="font-bold">Student Dashboard</h1>
    <a href="../scripts/logout.php" class="bg-red-500 px-3 py-1 rounded">Logout</a>
</nav>







<div class="p-6 space-y-6">
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-2">Mon Profil</h2>
    <p><b>Nom:</b> <?= $user["firstName"]." ".$user["lastName"] ?></p>
    <p><b>Email:</b> <?= $user["emil"]?></p>
</div>

<?php






$sql = "SELECT * FROM  enrollments 
JOIN students ON students.id=enrollments.student_id
JOIN users ON users.id=students.user_id
JOIN courses ON enrollments.course_id=courses.id
WHERE students.user_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>





<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-2">Mes Cours</h2>

    <?php foreach($courses as $row): ?>
        <div class="border p-3 rounded mb-2">
            <p><b>Cours:</b> <?= $row["title"] ?></p>
            <p><b>Prof:</b> <?= $row["firstName"] ?></p>
            <p><?= $row["description"] ?></p>
            <p><b>Hours:</b> <?= $row["total_hours"] ?>h</p>
        </div>
    <?php endforeach; ?>
</div>

<?php




$sql2 = "SELECT * 
FROM  users 
JOIN students ON students.user_id=users.id
JOIN classes ON classes.id=students.classe_id
WHERE classe_id=?
";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute([$class_id]);
$classmates = $stmt2->fetchAll();
?>








<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-2">Mes Camarades</h2>




    <ul class="list-disc ml-5">
        <?php foreach($classmates as $row): ?>
            <li><?= $row["firstName"] . " " . $row["lastName"] ?></li>
        <?php endforeach; ?>
    </ul>
</div>

</div>

</body>
</html> 
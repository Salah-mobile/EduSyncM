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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>EduSync - Gestion des Effectifs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-6xl mx-auto">
        <!-- Back Button -->
        <a href="dashboard_prof.php" class="text-green-700 hover:text-green-900 font-semibold flex items-center mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Retour au Dashboard
        </a>

        <!-- Header -->
        <div class="bg-white p-6 rounded-t-2xl shadow-sm border-b flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-graduation-cap text-green-600 mr-2"></i>
                    Liste des étudiants : <?= htmlspecialchars($course['name']) ?>
                </h1>
                <p class="text-gray-500 text-sm italic">Affichage de l'effectif inscrit pour ce module.</p>
            </div>
            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-bold">
                Total : <?= count($students) ?>
            </span>
        </div>

        <!-- US21 Table -->
        <div class="bg-white rounded-b-2xl shadow-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 border-b">Nom Complet</th>
                        <th class="px-6 py-4 border-b">Email</th>
                        <th class="px-6 py-4 border-b text-center">Date d'inscription</th>
                        <th class="px-6 py-4 border-b text-right">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (count($students) > 0): ?>
                        <?php foreach ($students as $s): ?>
                            <tr class="hover:bg-green-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    <?= htmlspecialchars($s['username']) ?>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <?= htmlspecialchars($s['email']) ?>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-500 text-sm">
                                    <?= date('d/m/Y', strtotime($s['enrolled_at'])) ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                                        <?= $s['status'] == 'Actif' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' ?>">
                                        <?= htmlspecialchars($s['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                <i class="fas fa-user-slash text-3xl mb-3 block"></i>
                                Aucun étudiant inscrit à ce cours pour le moment.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
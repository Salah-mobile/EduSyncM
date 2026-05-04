<?php

session_start();
    try {
     $conn =new PDO("mysql:host=localhost;dbname=edusync", "root", "");
} catch (PDOException $e) {
    echo "erreur connection";

}



// Vérifier si l'utilisateur est un Prof
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Prof') {
    
    header('Location: login.php'); 
    exit();
    
    
    $prof_id = 1; 
} else {
    $prof_id = $_SESSION['user_id'];
}


// 2. Requête SQL pour Mes Enseignements
$sql = "SELECT id, name, description, hours 
        FROM courses 
        WHERE teacher_id = :prof_id";

$stmt = $conn->prepare($sql);
$stmt->execute(['prof_id' => $prof_id]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSync - Mes Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">

    <!-- Navigation Simple -->
    <nav class="bg-green-700 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold italic">EduSync <span class="font-light text-sm">| Espace Prof</span></h1>
            <div class="flex items-center gap-4">
                <span class="text-sm border-r pr-4 italic">Bienvenue, Professeur</span>
                <a href="logout.php" class="hover:text-red-300 transition"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-10 px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">📚 US20 : Mes Enseignements</h2>
                <p class="text-gray-500 mt-1">Liste exclusive des modules qui vous sont assignés.</p>
            </div>
            <div class="bg-white p-3 rounded-xl shadow-sm border">
                <span class="block text-xs text-gray-400 uppercase font-bold">Total Cours</span>
                <span class="text-2xl font-black text-green-600"><?= count($courses) ?></span>
            </div>
        </div>

        <!-- Grille des Cours -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (count($courses) > 0): ?>
                <?php foreach ($courses as $c): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-green-600 p-4">
                            <div class="flex justify-between items-center text-white">
                                <i class="fas fa-book-open text-2xl opacity-80"></i>
                                <span class="text-xs font-bold bg-green-800 px-3 py-1 rounded-full">
                                    <?= $c['hours'] ?> HEURES
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 uppercase tracking-tight">
                                <?= htmlspecialchars($c['name']) ?>
                            </h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-6 line-clamp-3">
                                <?= htmlspecialchars($c['description']) ?>
                            </p>
                            
                            <div class="border-t pt-4 flex justify-between items-center">
                                <span class="text-xs font-semibold text-gray-400 uppercase">Action :</span>
                                <a href="course_details.php?id=<?= $c['id'] ?>" 
                                   class="flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                                    <span>Gérer l'effectif</span>
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Cas vide -->
                <div class="col-span-full bg-orange-50 border-2 border-dashed border-orange-200 rounded-2xl p-12 text-center">
                    <i class="fas fa-folder-open text-4xl text-orange-300 mb-4"></i>
                    <p class="text-orange-800 font-medium text-lg">Aucun cours trouvé dans la base pour votre ID.</p>
                    <p class="text-orange-600 text-sm">Vérifiez que vous êtes bien assigné à des cours dans la table `courses`.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>








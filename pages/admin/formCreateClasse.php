<?php
require "../../dbhandle/connection.php";
$conn=connection();
if(isset($_POST["createC"])){
    $nameC=$_POST["classeN"];
    $roomN=$_POST["classeNM"];
    try {
        $sql="INSERT INTO classes (name,classroom_number) values (?,?)";
        $stm=$conn->prepare($sql);
        $stm->execute([$nameC,$roomN]);
        header("Location:createClasse.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Nouvelle classe</h1>
            <p class="text-slate-500 text-sm mb-8">Ajouter une nouvelle salle de classe au système.</p>

            <form action="#" method="post" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nom de classe</label>
                    <input type="text" 
                           placeholder="Ex: Informatique" 
                           name="classeN" 
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Classe room number</label>
                    <input type="number" 
                           min="0" 
                           placeholder="Ex: 101" 
                           name="classeNM" 
                           required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none bg-slate-50/50">
                </div>

                <button name="createC" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-emerald-100 mt-4">
                    Create Classe
                </button>

                <a href="createClasse.php" class="block text-center text-sm text-slate-400 hover:text-slate-600 mt-4 font-medium transition-colors">
                    Retour à la liste
                </a>
            </form>
        </div>
    </div>

</body>
</html>
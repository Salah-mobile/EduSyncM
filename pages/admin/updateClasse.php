<?php
$classId=$_GET["classeId"];
require "../../dbhandle/connection.php";
$conn=connection();
try {
    $sql ="SELECT * FROM classes WHERE id=?";
    $stm=$conn->prepare($sql);
    $stm->execute([$classId]);
    $classe=$stm->fetch();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if(isset($_POST["updateC"])){
    $nomC=$_POST["classeN"];
    $numberRC=$_POST["classeNM"];
    try {
        $sql="UPDATE classes SET name=?,classroom_number=? WHERE id=?";
        $stm=$conn->prepare($sql);
        $stm->execute([$nomC,$numberRC,$classId]);
        header("Location:createClasse.php");
        exit();
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
    <title>Update Class</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Modifier la classe</h1>
            <p class="text-slate-500 text-sm mb-8">Mettez à jour les informations de la classe ci-dessous.</p>

            <form action="#" method="post" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nom de classe</label>
                    <input type="text" 
                           placeholder="Classe Name" 
                           name="classeN" 
                           required 
                           value="<?= $classe["name"] ?>"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Classe room number</label>
                    <input type="number" 
                           min="0" 
                           placeholder="classe room number" 
                           name="classeNM" 
                           required 
                           value="<?= $classe["classroom_number"] ?>"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none bg-slate-50/50">
                </div>

                <button name="updateC" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-indigo-100 mt-4">
                    Update Classe
                </button>
                
                <a href="createClasse.php" class="block text-center text-sm text-slate-400 hover:text-slate-600 mt-4 font-medium transition-colors">
                    Annuler et retourner
                </a>
            </form>
        </div>
    </div>

</body>
</html>
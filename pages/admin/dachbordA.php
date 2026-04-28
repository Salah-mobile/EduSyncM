<?php
 session_start();
 include "../../dbhandle/connection.php";
    try {
        $conn =connection();
        $sql ="SELECT * FROM users WHERE id <> ?";
        $stm=$conn->prepare($sql);
        $stm->execute([1]);
        $users=$stm->fetchAll();
    } catch (PDOException $e) {
       echo $e->getMessage();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen">

    <header class="bg-white border-b border-slate-200 px-6 py-4 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-600 p-2 rounded-xl">
                    <i class="fas fa-grid-2 text-white"></i>
                </div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">AdminPanel</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-xs font-medium text-slate-400 uppercase">Bienvenue</p>
                    <p class="text-sm font-bold text-slate-700">Mr <?php echo $_SESSION["Fname"] ?></p>
                </div>
                <div class="w-10 h-10 bg-indigo-100 border border-indigo-200 text-indigo-700 rounded-full flex items-center justify-center font-bold">
                    <?php echo substr($_SESSION["Fname"], 0, 1) ?>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <?php
        if(isset($_GET["action"])){
            if($_GET["action"]=="succ"){
                echo '
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in duration-500">
                    <i class="fas fa-circle-check"></i>
                    <span class="text-sm font-semibold">Delete with success</span>
                </div>';
            }
        }
        
        if(isset($_POST["createU"])){
            header("Location: createPage.php");
        }
        if(isset($_POST["createC"])){
            header("Location: createClasse.php");
        }
        ?>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">Utilisateurs</h2>
                <p class="text-slate-500 text-sm">Gérez les membres de votre équipe et leurs permissions.</p>
            </div>
            
            <form action="#" method="post" class="flex gap-3">
                <button name="createC" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                    <i class="fas fa-book-open text-indigo-500"></i> Create classe
                </button>
                <button name="createU" class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-lg shadow-indigo-200">
                    <i class="fas fa-plus"></i> Create User
                </button>
            </form>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">First Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Last Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Email</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Role</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($users as $user){ ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                <?php echo $user["firstName"]; ?>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <?php echo $user["lastName"]; ?>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                <?php echo $user["emil"]; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                if($user["role_id"]==2){
                                    echo '<span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-full border border-blue-100">Prof</span>';
                                }elseif($user["role_id"]==3){
                                    echo '<span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full border border-emerald-100">Student</span>';
                                }else{
                                    echo '<span class="px-3 py-1 bg-amber-50 text-amber-600 text-xs font-bold rounded-full border border-amber-100">Admin</span>';
                                }
                                ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="handledachbord.php" method="post" class="flex justify-end gap-2">
                                    <button name="update" value="<?php echo $user["id"] ?>" type="submit" 
                                            class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <i class="fas fa-pen-to-square"></i>
                                    </button>
                                    <button name="delete" value="<?php echo $user["id"] ?>" type="submit" 
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Delete">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200">
                <p class="text-xs font-medium text-slate-500 italic">Affichage de <?php echo count($users); ?> utilisateurs actifs.</p>
            </div>
        </div>
    </main>

</body>
</html>
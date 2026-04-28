<?php
include "../../dbhandle/connection.php";
    try {
        $conn =connection();
        $sql ="SELECT * FROM classes";
        $stm=$conn->prepare($sql);
        $stm->execute();
        $courses=$stm->fetchAll();
    } catch (PDOException $e) {
       echo $e->getMessage();
    }
    if(isset($_POST["delete"])){
        $classe_id=$_POST["delete"];
         try {
            $sql="DELETE FROM classes WHERE id=?";
            $stm=$conn->prepare($sql);
            $stm->execute([$classe_id]);
            header('Location: createClasse.php');
         } catch (PDOException $e) {
            echo $e->getMessage();
         }
    }
    if(isset($_POST["update"])){
        $classe_id=$_POST["update"];
        header("Location:updateClasse.php?classeId=$classe_id");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management | EduManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen pb-12">

    <nav class="bg-white border-b border-slate-200 mb-8 sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-2 rounded-lg shadow-sm shadow-indigo-200">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-tight">EduManager</span>
                </div>
                <div class="text-sm font-medium text-slate-400">
                    Administration Panel
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Classroom Management</h1>
                <p class="text-slate-500 mt-1">Manage your school infrastructure and classroom assignments.</p>
            </div>
            
            <form action="formCreateClasse.php" method="post">
                <button class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-indigo-100 group">
                    <i class="fas fa-plus text-xs transition-transform group-hover:rotate-90"></i>
                    Add New Class
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Index</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Class Information</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Location</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($courses as $course){ ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-5">
                                <span class="font-mono text-sm font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded">
                                    #<?php echo $course["id"]; ?>
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div>
                                        <span class="block text-slate-800 font-bold leading-none mb-1"><?php echo $course["name"]; ?></span>
                                        <span class="text-xs text-slate-400 font-medium uppercase tracking-tighter">Academic Group</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 text-sm font-semibold">
                                    <i class="fas fa-door-open opacity-60"></i>
                                    Room <?php echo $course["classroom_number"]; ?>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <form action="#" method="post" class="flex justify-end gap-3">
                                    <button name="update" value="<?php echo $course["id"] ?>" type="submit" 
                                            class="flex items-center gap-2 px-3 py-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all font-medium text-sm border border-transparent hover:border-indigo-100" title="Edit Class">
                                        <i class="fas fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button name="delete" value="<?php echo $course["id"] ?>" type="submit" 
                                            class="flex items-center gap-2 px-3 py-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all font-medium text-sm border border-transparent hover:border-rose-100" 
                                            title="Delete Class"
                                            onclick="return confirm('Delete this classroom permanently?')">
                                        <i class="fas fa-trash-can"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(empty($courses)){ ?>
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-folder-open text-slate-300 text-2xl"></i>
                                    </div>
                                    <h3 class="text-slate-900 font-bold">No records found</h3>
                                    <p class="text-slate-500 text-sm mt-1">Get started by creating your first classroom entry using the button above.</p>
                                </div>
                            </td>
                        </tr>
                        <?php }; ?>
                    </tbody>
                </table>
            </div>
            <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-200">
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">
                    Total Classes: <?php echo count($courses); ?>
                </p>
            </div>
        </div>
    </main>

</body>
</html>
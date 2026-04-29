<?php
include "../../dbhandle/connection.php";
$conn =connection();
try {
    $sql="SELECT e.id,u.firstName,u.lastName,c.title,e.status,e.enrolled_at 
    FROM enrollments e 
    JOIN courses c ON c.id=e.course_id 
    JOIN students s ON s.id=e.student_id
    JOIN users u ON u.id=s.user_id
    ";
    $stm=$conn->prepare($sql);
    $stm->execute();
    $enrollments=$stm->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

if(isset($_POST["delete"])){
    $enrId=$_POST["delete"];
    try {
        $sql="DELETE FROM enrollments WHERE id=?";
        $stm=$conn->prepare($sql);
        $stm->execute([$enrId]);
        header("Location: createEnrollment.php");
        exit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
if(isset($_POST["createE"])){
    header("Location:fromCreateEnrollment.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Management | EduManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-600 p-2 rounded-lg">
                    <i class="fas fa-graduation-cap text-white"></i>
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">EduManager</span>
            </div>
        </div>
    </nav>
    <?php if(isset($_GET["err"]) && $_GET["err"] == "exist"): ?>
    <div class="max-w-xl mx-auto mt-6 px-6 py-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl flex items-center gap-4 shadow-sm animate-pulse">
        <div class="bg-rose-500/10 p-2 rounded-full">
            <i class="fas fa-exclamation-circle text-rose-600 text-xl"></i>
        </div>
        <div>
            <h3 class="text-rose-900 font-bold text-sm">Opération impossible</h3>
            <p class="text-rose-700 text-xs mt-0.5">Cet étudiant est déjà inscrit à ce cours. Vous ne pouvez pas créer de doublon.</p>
        </div>
    </div>
<?php endif; ?>
    <main class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Manage Enrollments</h1>
                <p class="text-slate-500 mt-1">Track, update, and manage student course registrations.</p>
            </div>
            
            <form action="" method="post">
                <button name="createE" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-indigo-100 group">
                    <i class="fas fa-plus-circle text-sm transition-transform group-hover:scale-110"></i>
                    New Enrollment
                </button>
            </form>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Student Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Course Title</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Registration Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($enrollments as $enr){ ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        <?= strtoupper(substr($enr["firstName"], 0, 1)) ?>
                                    </div>
                                    <span class="font-bold text-slate-800"><?= $enr["firstName"]." ".$enr["lastName"] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-slate-600 font-medium"><?= $enr["title"] ?></span>
                            </td>
                            <td class="px-6 py-5">
                                <?php 
                                    $statusClass = "bg-slate-100 text-slate-600";
                                    if($enr["status"] == "active") $statusClass = "bg-emerald-100 text-emerald-700";
                                    if($enr["status"] == "pending") $statusClass = "bg-amber-100 text-amber-700";
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold <?= $statusClass ?>">
                                    <?= ucfirst($enr["status"]) ?>
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm text-slate-500">
                                    <i class="far fa-calendar-alt mr-2 opacity-50"></i>
                                    <?= date('M d, Y', strtotime($enr["enrolled_at"])) ?>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <form action="#" method="post" class="flex items-center justify-center gap-2">
                                    <button name="update" value="<?=$enr["id"]?>" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Update">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button name="delete" value="<?=$enr["id"]?>" onclick="return confirm('Are you sure you want to delete this enrollment?')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <?php if(empty($enrollments)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-inbox text-slate-300 text-2xl"></i>
                                </div>
                                <h3 class="text-slate-900 font-bold">No Enrollments Found</h3>
                                <p class="text-slate-500 text-sm">Start by adding a student to a course.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    Total: <?= count($enrollments) ?> Entries
                </p>
            </div>
        </div>
    </main>

</body>
</html>
<?php
require "../../dbhandle/connection.php";
$conn=connection();
try {
    $sql="SELECT  courses.id AS course_id,
    courses.title,
    courses.description,
    courses.total_hours,
    users.firstName,
    users.lastName FROM courses JOIN users on users.id=courses.user_id";
    $stm=$conn->prepare($sql);
    $stm->execute();
    $courses=$stm->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if(isset($_POST["delete"])){
    $course_id=$_POST["delete"];
    try {
        $sql="DELETE  FROM courses WHERE id=?";
        $stm=$conn->prepare($sql);
        $stm->execute([$course_id]);
        header("Location:createCourse.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
if(isset($_POST["update"])){
    $course_id=$_POST["update"];
    header("Location: formUpdateCourse.php?icC=$course_id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Catalog | EduManager</title>
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
                    <div class="bg-indigo-600 p-2 rounded-lg shadow-sm">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-tight">EduManager</span>
                </div>
                <div class="hidden md:block text-sm font-medium text-slate-400">
                    Course Management System
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Course Catalog</h1>
                <p class="text-slate-500 mt-1">Manage and view all academic courses and assigned faculty.</p>
            </div>
            
            <form action="formCreateCourse.php" method="post">
                <button class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-indigo-100 group">
                    <i class="fas fa-plus-circle text-sm transition-transform group-hover:scale-110"></i>
                    Create New Course
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Course Title</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Description</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Duration</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Professor</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($courses as $course){ ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                        <i class="fas fa-book text-sm"></i>
                                    </div>
                                    <span class="font-bold text-slate-800"><?= $course["title"]?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-slate-500 text-sm line-clamp-1 max-w-xs" title="<?= $course["description"]?>">
                                    <?= $course["description"]?>
                                </p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    <i class="far fa-clock mr-1.5 opacity-60"></i>
                                    <?= $course["total_hours"]?> Hours
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold text-slate-700">
                                        <?= "Prof. ".$course["firstName"]." ".$course["lastName"]?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <form action="#" method="post" class="flex justify-end gap-2">
                                    <button name="update" value="<?php echo $course["course_id"] ?>" 
                                            class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <i class="fas fa-pen-to-square"></i>
                                    </button>
                                    <button name="delete" value="<?php echo $course["course_id"]?>" 
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Delete">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if(empty($courses)){ ?>
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-layer-group text-slate-300 text-xl"></i>
                                    </div>
                                    <h3 class="text-slate-900 font-bold">Empty Catalog</h3>
                                    <p class="text-slate-500 text-sm mt-1">No courses have been registered in the system yet.</p>
                                </div>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    Showing <?= count($courses) ?> Course Records
                </span>
            </div>
        </div>
    </main>

</body>
</html>
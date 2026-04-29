<?php
require "../../dbhandle/connection.php";
$conn=connection();
try {
    $sql="SELECT * FROM users
     WHERE role_id=2
     ";
     $stm=$conn->prepare($sql);
      $stm->execute();
      $teachers=$stm->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if(isset($_POST["createC"])){
    $title=$_POST["titleC"];
    $des=$_POST["Desc"];
    $numHT=$_POST["NUH"];
    $teacherId=$_POST["teacherId"];
    try {
        $sql="INSERT INTO courses(title,description,total_hours,user_id) VALUES(?,?,?,?)";
        $stm=$conn->prepare($sql);
        $stm->execute([$title,$des,$numHT,$teacherId]);
        header("Location: createCourse.php");
    } catch (PDOException) {
        echo $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course | EduManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-indigo-600 p-2 rounded-lg">
                    <i class="fas fa-graduation-cap text-white"></i>
                </div>
                <span class="text-xl font-bold text-slate-800 tracking-tight">EduManager</span>
            </div>
            <a href="createCourse.php" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Courses
            </a>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
                
                <div class="bg-slate-900 px-10 py-10 text-white relative">
                    <div class="relative z-10">
                        <h1 class="text-2xl font-bold">Create New Course</h1>
                        <p class="text-slate-400 mt-2">Fill in the details below to publish a new academic course.</p>
                    </div>
                    <i class="fas fa-book-open absolute right-10 top-10 text-6xl text-slate-800 opacity-50"></i>
                </div>

                <form action="#" method="post" class="p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Course Title</label>
                            <input type="text" name="titleC" required placeholder="e.g. Introduction to Web Development" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Total Hours</label>
                            <div class="relative">
                                <input type="number" min="0" name="NUH" required placeholder="0" 
                                    class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 uppercase">Hrs</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Assigned Teacher</label>
                            <div class="relative">
                                <select name="teacherId" required 
                                    class="w-full appearance-none px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-slate-700 cursor-pointer">
                                    <option value="" disabled selected>Select a teacher...</option>
                                    <?php foreach($teachers as $teacher){ ?>
                                        <option value="<?=$teacher["id"]?>">
                                            <?= $teacher["firstName"]." ".$teacher["lastName"] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Description</label>
                            <textarea name="Desc" rows="4" placeholder="Briefly describe the course objectives..." 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400 resize-none"></textarea>
                        </div>
                    </div>

                    <div class="mt-10">
                        <button name="createC" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-indigo-200 flex items-center justify-center gap-2 group">
                            <span>Create Course</span>
                            <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
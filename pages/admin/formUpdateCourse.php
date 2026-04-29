<?php
require "../../dbhandle/connection.php";
$conn=connection();
if(isset($_GET["icC"])){
    $courseId=$_GET["icC"];
    try {
        $sql="SELECT * FROM courses  WHERE id =?";
        $stm=$conn->prepare($sql);
        $stm->execute([$courseId]);
        $course=$stm->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();     
    }
    try {
        $sql="SELECT * FROM users  WHERE role_id =?";
        $stm=$conn->prepare($sql);
        $stm->execute([3]);
        $teachers=$stm->fetchAll();
    } catch (PDOEception $e) {
        echo $e->getMessage();
    }
    if(isset($_POST["updateC"])){
        $title=$_POST["courseT"];
        $desciption=$_POST["courseD"];
        $courseH=$_POST["courseH"];
        $teacher=$_POST["teachers"];
        try {
            $sql ="UPDATE courses SET title=? ,description=?,total_hours=?,user_id=? WHERE id=?";
            $stm=$conn->prepare($sql);
            $stm->execute([$title,$desciption,$courseH,$teacher,$courseId]);
            header("Location:createCourse.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course | EduManager</title>
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
                <i class="fas fa-arrow-left mr-2"></i> Cancel Changes
            </a>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
                
                <div class="bg-indigo-600 px-10 py-10 text-white relative">
                    <div class="relative z-10">
                        <h1 class="text-2xl font-bold">Update Course Data</h1>
                        <p class="text-indigo-100 mt-2 opacity-90">Modify the fields below to update the course record in the database.</p>
                    </div>
                    <i class="fas fa-pen-nib absolute right-10 top-10 text-6xl text-indigo-500 opacity-30"></i>
                </div>

                <form action="" method="post" class="p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Course Title</label>
                            <input type="text" name="courseT" value="<?=$course["title"]?>" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-slate-700">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Total Hours</label>
                            <div class="relative">
                                <input type="number" name="courseH" value="<?=$course["total_hours"]?>" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-slate-700">
                                <i class="fas fa-clock absolute right-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Assigned Teacher</label>
                            <div class="relative">
                                <select name="teachers" required
                                    class="w-full appearance-none px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-slate-700 cursor-pointer">
                                    <?php
                                    foreach($teachers as $teacher){
                                        ?>
                                        <option value="<?=$teacher["id"]?>">
                                            <?=$teacher["firstName"]." ".$teacher["lastName"]?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Description</label>
                            <textarea name="courseD" rows="4" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all text-slate-700 resize-none"><?=$course["description"]?></textarea>
                        </div>
                    </div>

                    <div class="mt-10">
                        <button name="updateC" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-3 group">
                            <i class="fas fa-save transition-transform group-hover:scale-110"></i>
                            <span>Update Course Record</span>
                        </button>
                    </div>
                </form>
            </div>
            
            <p class="text-center text-slate-400 text-xs mt-6 uppercase tracking-widest font-bold">
                EduManager Control Panel
            </p>
        </div>
    </main>

</body>
</html>
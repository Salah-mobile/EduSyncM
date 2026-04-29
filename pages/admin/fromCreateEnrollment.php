<?php
include "../../dbhandle/connection.php";
$conn =connection();
try {
    $sql="SELECT students.id,users.firstName,users.lastName 
    FROM students 
    JOIN users ON users.id=students.user_id";
    $stm=$conn->prepare($sql);
    $stm->execute();
    $students=$stm->fetchAll();
    $sql="SELECT * FROM courses";
    $stm=$conn->prepare($sql);
    $stm->execute();
    $courses=$stm->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if(isset($_POST["creatE"])){
$student=$_POST["student"];
$course=$_POST["course"];
$status=$_POST["status"];
try {
    $sql="SELECT * FROM enrollments WHERE student_id=? AND course_id=?";
    $stm=$conn->prepare($sql);
    $stm->execute([$student,$course]);
    $enrollment=$stm->fetch();
    if($enrollment){
        header("Location: createEnrollment.php?err=exist");
        exit();
    }else{
        $sql="INSERT INTO  enrollments(enrolled_at,status,student_id,course_id) VALUES(NOW(),?,?,?)";
        $stm=$conn->prepare($sql);
        $stm->execute([$status,$student,$course]);
        header("Location: createEnrollment.php?action=sucess");
        exit();
    }
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
    <title>Create Enrollment | EduManager</title>
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
            <a href="createEnrollment.php" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-12 flex justify-center">
        <div class="w-full max-w-xl">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
                <div class="bg-slate-900 px-8 py-8 text-white relative">
                    <div class="relative z-10">
                        <h1 class="text-2xl font-bold">Create Enrollment</h1>
                        <p class="text-slate-400 text-sm mt-1">Register a student for a new course module.</p>
                    </div>
                    <i class="fas fa-file-signature absolute right-8 top-1/2 -translate-y-1/2 text-5xl text-white/10"></i>
                </div>

                <form action="#" method="post" class="p-8 space-y-6">
                    
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-700 ml-1">
                            <i class="fas fa-user-student text-indigo-500"></i> Student
                        </label>
                        <select name="student" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all appearance-none cursor-pointer">
                            <option value="" disabled selected>Select a student...</option>
                            <?php foreach($students as $student){ ?>
                                <option value="<?=$student["id"]?>"><?=$student["firstName"]." ".$student["lastName"]?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-700 ml-1">
                            <i class="fas fa-book text-indigo-500"></i> Course
                        </label>
                        <select name="course" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all appearance-none cursor-pointer">
                            <option value="" disabled selected>Select a course...</option>
                            <?php foreach($courses as $course){ ?>
                                <option value="<?=$course["id"]?>"><?=$course["title"]?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-bold text-slate-700 ml-1">
                            <i class="fas fa-info-circle text-indigo-500"></i> Initial Status
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="relative">
                                <input type="radio" name="status" value="active" checked class="peer sr-only">
                                <div class="text-center py-2 px-3 border border-slate-200 rounded-lg cursor-pointer peer-checked:bg-indigo-50 peer-checked:border-indigo-500 peer-checked:text-indigo-700 text-slate-600 font-medium text-sm transition-all">
                                    Active
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="status" value="padding" class="peer sr-only">
                                <div class="text-center py-2 px-3 border border-slate-200 rounded-lg cursor-pointer peer-checked:bg-indigo-50 peer-checked:border-indigo-500 peer-checked:text-indigo-700 text-slate-600 font-medium text-sm transition-all">
                                    Pending
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="status" value="finish" class="peer sr-only">
                                <div class="text-center py-2 px-3 border border-slate-200 rounded-lg cursor-pointer peer-checked:bg-indigo-50 peer-checked:border-indigo-500 peer-checked:text-indigo-700 text-slate-600 font-medium text-sm transition-all">
                                    Finish
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button name="creatE" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-indigo-200 flex items-center justify-center gap-2 active:scale-[0.98]">
                            <i class="fas fa-check-circle"></i>
                            Confirm Enrollment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <h1>classe gestion</h1>
    <form action="formCreateClasse.php" method="post">
        <button>Create classe</button>
    </form>
    <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">classe Id</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">classe Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">classe Number</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach($courses as $course){ ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                <?php echo $course["id"]; ?>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                <?php echo $course["name"]; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                               echo $course["classroom_number"];
                                ?>
                            </td>
                            <td>
                                <form action="#" method="post" class="flex justify-end gap-2">
                                    <button name="update" value="<?php echo $course["id"] ?>" type="submit" 
                                            class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <i class="fas fa-pen-to-square"></i>
                                    </button>
                                    <button name="delete" value="<?php echo $course["id"] ?>" type="submit" 
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Delete">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
</body>
</html>
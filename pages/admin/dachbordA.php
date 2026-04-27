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
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    Welcom Mr <?php echo  $_SESSION["Fname"] ?>
<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                  First Name
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                   Last Name
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                   Email
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                   Role
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($users as $user){
                ?>
                <tr class="bg-neutral-primary border-b border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    <?php
                   echo $user["firstName"];
                    ?>
                </th>
                <td class="px-6 py-4">
                      <?php
                   echo $user["lastName"];
                    ?>
                </td>
                <td class="px-6 py-4">
                   <?php
                   echo $user["emil"];
                    ?>
                </td>
                <td class="px-6 py-4">
                   <?php
                    if($user["role_id"]==2){
                        echo "Prof";
                    }else{
                        echo "Student";
                    }
                    ?>
                </td>
                <td class="px-6 py-4">
                    <form action="handledachbord.php" method="post">
                  <button 
                    name="delete"
                    value="<?php echo $user["id"] ?>"
                    type="submit" 
                    class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 shadow-md transition duration-200">
                        DELETE
                </button>

                <button 
                    name="update"
                    type="submit" 
                    value="<?php echo $user["id"] ?>"
                    class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 shadow-md transition duration-200">
                        UPDATE
                </button>
                 </form>
                </td>
                <?php
            }
            ?>
            </tr>        
        </tbody>
    </table>
</div>
</body>
</html>
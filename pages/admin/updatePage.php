<?php
include "../../dbhandle/connection.php";

if(isset($_GET["id"])){
    $userId=$_GET["id"];
    try {
    $conn=connection();
    $sql="SELECT * FROM users WHERE id = ?";
    $stm=$conn->prepare($sql);
    $stm->execute([$userId]);
    $user=$stm->fetch();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if(isset($_POST["update"])){
    $name=$_POST["firstname"];
    $lastName=$_POST["lastname"];
    $password=$_POST["password"];
    $role=$_POST["role"];
    echo "the name :".$name;
    echo "the lastName :".$lastName;
    echo "the role :".$role;
     try {
    $conn=connection();
    $sql="UPDATE users SET firstName=? , lastName=? , password=? , role_id=? WHERE id=?";
    $stm=$conn->prepare($sql);
    $stm->execute([$name,$lastName,$password,$role,$userId]);
    header("Location: dachbordA.php");
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
</head>
<body>
    <section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
          edusync    
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Update Page 
              </h1>
              <form class="space-y-4 md:space-y-6" action="#" method="post">
                  <div>
                      <label for="firstname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">new First Name</label>
                      <input type="text" name="firstname" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required value=<?php echo $user["firstName"]?>>
                  </div>
                  <div>
                      <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">new Last Name</label>
                      <input type="text" name="lastname" id="lastname" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required value=<?php echo $user["lastName"]?>>
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">new Password</label>
                      <input type="password" name="password" id="password"  class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required value=<?php echo $user["password"]?>>
                  </div>
                  <select 
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg px-4 py-2"
                    name="role"
                    >
                    <option 
                    value="3">
                        Student
                    </option>
                    <option 
                    value="1">
                        Admin
                    </option>

                    <option 
                    value="2">
                        Professeur
                    </option>

                </select>
                  <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="update">Update </button>
              </form>
          </div>
      </div>
  </div>
</section>
</body>
</html>
<?php
}

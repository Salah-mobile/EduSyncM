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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <label for="">title</label>
    <input type="text" name="titleC" >
    <label for="">description</label>
    <input type="text" name="Desc">
    <label for="">total hours</label>
    <input type="Number" min=0 name="NUH">
    <label for="">Teacher</label>
    <select name="" id="">
       <?php
        foreach($teachers as $teacher){
            ?>
             <option value="<?=$teacher["id"]?>"><?= $teacher["firstName"]." ".$teacher["lastName"] ?></option>
            <?php
        }
       ?>
    </select>
    <div>
        <h1>Students</h1>
        <button id="DS">add Students </button>
         <div id="students">
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
            <div>fhjfgkjkjfkjarfkjh</div>
         </div>
    </div>
    <button>Add</button>
</form>    
<script>
    let btnD=document.getElementById("DS")
    btnD.addEventListner("click",()=>{
        document.getElementById("students").style.display="none"
    })
</script>
</body>
</html>
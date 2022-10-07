<?php
    include('../../php/auth.php'); 
    include('../../php/cnn.php'); 

    if(isset($_GET['id'])){$id = $_GET['id'];}else{header('Location: ../tareas.php');}
    $query = "SELECT * FROM tareas WHERE id = '$id'";
    if($result = $conn->query($query)){
        while($row = $result->fetch_assoc()){
            $enplazo = $row['en_plazo'];
        }
    }
    if($enplazo == "No"){$en = "Yes";}else{$en = "No";}
    $sql_update = "UPDATE `tareas` SET `en_plazo` = '$en' WHERE `tareas`.`id` = '$id'";
    if(mysqli_query($conn, $sql_update)){header('Location: cdh.php?id='.$id.'');}else{echo "<script>alert('Ha ocurrido un error');</script>";}
?>
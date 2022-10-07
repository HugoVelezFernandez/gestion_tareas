<?php
    include('../../php/auth.php'); 
    include('../../php/cnn.php'); 

    if(isset($_GET['id'])){$id = $_GET['id'];}else{header('Location: ../tareas.php');}
    $query = "SELECT id, realizado FROM trabajos WHERE id = '$id'";
    if($result = $conn->query($query)){
        while($row = $result->fetch_assoc()){
            $entregado = $row['realizado'];
        }
    }
    if($entregado == "No"){$en = "Yes";}else{$en = "No";}
    $sql_update = "UPDATE `trabajos` SET `realizado` = '$en' WHERE `trabajos`.`id` = '$id'";
    if(mysqli_query($conn, $sql_update)){header('Location: cdw.php?id='.$id.'');}else{echo "<script>alert('Ha ocurrido un error');</script>";}
?>
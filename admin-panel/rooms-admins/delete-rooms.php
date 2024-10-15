<?php 
require"../../config/config.php";

if(isset($_GET['id'])) {
    $id=$_GET['id'];
    $getImage=$conn->query("SELECT id FROM rooms WHERE id='$id'");
    $getImage->execute();

    $fetch=$getImage->fetch(PDO::FETCH_OBJ);

    unlink("room_images/");

    $delete =$conn->query("DELETE FROM rooms WHERE id='$id'");
    $delete->execute();

    header("Location:show-rooms.php");

}
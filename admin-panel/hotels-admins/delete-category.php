<?php 
require"../../config/config.php";

if(isset($_GET['id'])) {
    $id=$_GET['id'];
    $getImage=$conn->query("SELECT id FROM hotels WHERE id='$id'");
    $getImage->execute();

    $fetch=$getImage->fetch(PDO::FETCH_OBJ);

    unlink("hotel_images/");

    $delete =$conn->query("DELETE FROM hotels WHERE id='$id'");
    $delete->execute();

    header("Location:show-hotels.php");

}
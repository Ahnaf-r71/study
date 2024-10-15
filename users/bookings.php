<?php require "../reUse/header.php";?>
<?php require "../config/config.php";?>

<?php

    if(!isset($_SESSION['username'])){
        echo "<script>window.location.href='".APPURL."'</script>"; 
        // divert if not logged in 
    }

    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        if($_SESSION['id'] != $id) {
            echo "<script>window.location.href='".APPURL."'</script>";

        }
    }
?>

    <?php
    
        if(isset($_GET['id'])){

            $id = $_GET['id'];

            $bookings = $conn->query("SELECT * FROM bookings WHERE user_id = '$id'");
            $bookings->execute();

            $allBookings = $bookings->fetchAll(PDO::FETCH_OBJ);
        }
        else{
            echo "<script>window.location.href='".APPURL."404.php'</script>";
        }
        
    
    ?>
<div class="container">
    <?php if(count($allBookings)>0):?>
<table class="table mt-5">
    <thead>
        <tr>
        <th scope="col">Check In check_in</th>
        <th scope="col">Check Out check_out</th>
        <th scope="col">email</th>
        <th scope="col">Phone Number phone_number</th>
        <th scope="col">Full Name full_name</th>
        <th scope="col">Hotel Name hotel_name</th>
        <th scope="col">Room Name room_name</th>
        <th scope="col">Status status</th>
        <th scope="col">Payment payment</th>
        <th scope="col">Created At created_at</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($allBookings as $booking):
        ?>
            <tr>
            <th scope="row"><?php echo $booking->check_in;?></th>
            <td><?php echo $booking->check_in;?></td>
            <td><?php echo $booking->email;?></td>
            <td><?php echo $booking->phone_number;?></td>
            <td><?php echo $booking->full_name;?></td>
            <td><?php echo $booking->hotel_name;?></td>
            <td><?php echo $booking->room_name;?></td>
            <td><?php echo $booking->status;?></td>
            <td><?php echo $booking->payment;?></td>
            <td><?php echo $booking->created_at;?></td>
            </tr>
        <?php 
            endforeach;
        ?>
    </tbody>
</table>
    <?php else :?>
         <div class="alert alert-primary" role="alert">
         No Bookings history found, Book now to display
       </div>   
   <?php endif; ?>
</div>

<?php require "../reUse/footer.php"; ?>

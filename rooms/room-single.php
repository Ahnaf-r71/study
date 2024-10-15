<?php require "../reUse/header.php";?>
<?php require "../config/config.php";?>

<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		// Fetch the room details
		$room= $conn->query("SELECT * FROM rooms WHERE status = 1 AND id='$id'"); 
		$room->execute();

		$singleRoom = $room->fetch(PDO::FETCH_OBJ);

		// Fetch the utilities for the room
		$utilities = $conn->query("SELECT * FROM utilities WHERE room_id='$id'");
        $utilities->execute();

		$allUtilities = $utilities->fetchAll(PDO::FETCH_OBJ); 
		
		// Form submission handling
		if(isset($_POST['submit'])){
			// Check if any required fields are empty
			if(empty($_POST['email']) OR empty($_POST['phone_number']) OR empty($_POST['full_name'])
			OR empty($_POST['check_in']) OR empty($_POST['check_out'])){
				echo "<script>alert('Fields Cannot Be Empty');</script>";
			} else {
				// Assign the form inputs to variables
				$check_in = $_POST['check_in'];
				$check_out = $_POST['check_out'];
				$email = $_POST['email'];
				$phone_number = $_POST['phone_number'];
				$full_name = $_POST['full_name'];
				$hotel_name = $singleRoom->hotel_name;
				$room_name = $singleRoom->name;
				$user_id = $_SESSION['id']; // Assuming session is active and user is logged in
				$status ="Pending"; // Static for now, admin will update after payment
				$payment = $singleRoom->price;
				
				// Validate the dates
				$today = new DateTime();  // Get today's date
				$checkInDate = new DateTime($check_in);
				$checkOutDate = new DateTime($check_out);
				
				$days=date_diff($checkInDate,$checkOutDate);
				
			

				// Store price in session
				$_SESSION['price'] = $singleRoom->price * intval($days->format('%R%a'));

				

				// Compare the dates
				if($checkInDate < $today || $checkOutDate < $today) {
					echo "<script>alert('Cannot book for past dates, please select a valid date starting from tomorrow');</script>";
				} else if($checkInDate >= $checkOutDate) {
					echo "<script>alert('Check-in date must be before check-out date');</script>";
				} else {
					// Proceed with booking logic if dates are valid
					$booking = $conn->prepare("INSERT INTO bookings 
						(check_in, check_out, email, phone_number, full_name, hotel_name, room_name, status, payment, user_id)
						VALUES (:check_in, :check_out, :email, :phone_number, :full_name, :hotel_name, :room_name, :status, :payment, :user_id)"
					);
					$booking->execute([
						"check_in" => $_POST['check_in'],
						"check_out" => $_POST['check_out'],
						"email" => $email,
						"phone_number" => $phone_number,
						"full_name" => $full_name,
						"hotel_name" => $hotel_name,
						"room_name" => $room_name,
						"status" => $status,
						"payment" => $_SESSION['price'],
						"user_id" => $user_id
					]);
					echo "<script>alert('Booking successful! Pending Payment');</script>";
					echo "<script>window.location.href='".APPURL."/rooms/pay.php'</script>";
					
				}
			}
		}
	}else{
		echo "<script>window.location.href='".APPURL."404.php'</script>";
	}
?>

<!-- Room Display and Booking Form -->
<div class="hero-wrap js-fullheight" style="background-image: url('<?php echo APPURL;?>images/<?php echo $singleRoom->image; ?>');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
            <div class="col-md-7 ftco-animate">
                <h2 class="subheading">Welcome to Lux Inn</h2>
                <h1 class="mb-4"><?php echo $singleRoom->name; ?></h1>
            </div>
        </div>
    </div>
</div>

<!-- Book Form -->
<section class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
	<div class="container">
		<div class="row justify-content-end">
			<div class="col-lg-4">
				<form action="room-single.php?id=<?php echo $id; ?>" method="POST" class="appointment-form" style="margin-top: -568px;">
					<h3 class="mb-3">Book this room</h3>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="email" class="form-control" placeholder="Email">
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="full_name" class="form-control" placeholder="Full Name">
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<input type="text" name="phone_number" class="form-control" placeholder="Phone Number">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<div class="input-wrap">
									<div class="icon"><span class="ion-md-calendar"></span></div>
									<input type="text" name="check_in" class="form-control appointment_date-check-in" placeholder="Check-In">
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<div class="icon"><span class="ion-md-calendar"></span></div>
								<input type="text" name="check_out" class="form-control appointment_date-check-out" placeholder="Check-Out">
							</div>
						</div>

						<!-- Hidden fields for hotel_name and room_name -->
						<input type="hidden" name="hotel_name" value="<?php echo $singleRoom->hotel_name; ?>">
						<input type="hidden" name="room_name" value="<?php echo $singleRoom->name; ?>">

						<div class="col-md-12">
							<div class="form-group">
								<input type="submit" name="submit" value="Book and Pay Now" class="btn btn-primary py-3 px-4">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- Display Room Utilities -->
<section class="ftco-section bg-light">
	<div class="container">
		<div class="row no-gutters">
			<div class="col-md-6 wrap-about">
				<div class="img img-2 mb-4" style="background-image: url(../images/image_2.jpg);"></div>
				<h2>The most recommended Hotel for your visit in Australia</h2>
				<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
			</div>
			<div class="col-md-6 wrap-about ftco-animate">
				<div class="heading-section">
					<div class="pl-md-5">
						<h2 class="mb-2">What we offer</h2>
					</div>
				</div>
				<div class="pl-md-5">
					<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
					<div class="row">
						<?php foreach( $allUtilities as $utility ): ?>
							<div class="services-2 col-lg-6 d-flex w-100">
								<div class="icon d-flex justify-content-center align-items-center">
									<span class="<?php echo $utility->icon; ?>"></span>
								</div>
								<div class="media-body pl-3">
									<h3 class="heading"><?php echo $utility->name; ?></h3>
									<p><?php echo $utility->description; ?></p>
								</div>
							</div> 
						<?php endforeach; ?>
					</div>  
				</div>
			</div>
		</div>
	</div>

<!-- Footer -->
<?php require "../reUse/footer.php";?>

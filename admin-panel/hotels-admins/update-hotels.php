<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the hotel record
    $hotel = $conn->prepare("SELECT * FROM hotels WHERE id = :id");
    $hotel->execute([':id' => $id]);

    $hotelSingle = $hotel->fetch(PDO::FETCH_OBJ);

    // Check if the hotel was found
    if (!$hotelSingle) {
        echo "<script>alert('Hotel not found');</script>";
        exit; // Exit the script if hotel doesn't exist
    }

    // Handle form submission
    if (isset($_POST['submit'])) {
        // Check if fields are empty
        if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['location'])) {
            echo "<script>alert('Fields cannot be empty');</script>";
        } else {
            // Collect updated data
            $name = $_POST['name'];
            $description = $_POST['description'];
            $location = $_POST['location'];

            // Prepare the UPDATE query
            try {
                $update = $conn->prepare("UPDATE hotels SET name = :name, description = :description, location = :location WHERE id = :id");
                $update->execute([
                    ":name" => $name,
                    ":description" => $description,
                    ":location" => $location,
                    ":id" => $id
                ]);

                // Redirect to show-hotels.php upon success
                header("Location: show-hotels.php");
                exit();

            } catch (PDOException $e) {
                echo "<script>alert('Error updating hotel: " . $e->getMessage() . "');</script>";
            }
        }
    }
} else {
    echo "<script>alert('Invalid request');</script>";
    exit();
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Update Hotel</h5>
                <!-- Make sure the form method and action are correct -->
                <form method="POST" action="update-hotels.php?id=<?php echo $id; ?>">
                    <!-- Name input -->
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" value="<?php echo htmlspecialchars($hotelSingle->name); ?>" name="name" class="form-control" placeholder="Name" />
                    </div>

                    <!-- Description input -->
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($hotelSingle->description); ?></textarea>
                    </div>

                    <!-- Location input -->
                    <div class="form-outline mb-4 mt-4">
                        <label for="exampleFormControlTextarea1">Location</label>
                        <input type="text" value="<?php echo htmlspecialchars($hotelSingle->location); ?>" name="location" class="form-control"/>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>

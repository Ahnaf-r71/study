<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
// Start error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='" . ADMINURL . "/admins/login-admins.php'</script>";
} else {
    if (isset($_POST['submit'])) {
        // Check if mandatory fields are filled
        if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['location'])) {
            echo "<script>alert('Fields Cannot Be Empty');</script>";
        } else {
            // Collect form data
            $name = $_POST['name'];
            $description = $_POST['description'];
            $location = $_POST['location'];
            $image = $_FILES['image']['name'];  // Correct file input
            
            // Define target directory
            $dir = "hotel_images/" . basename($image);

            // Insert data into the database
            try {
                $insert = $conn->prepare("INSERT INTO hotels (name, description, location, image) VALUES(:name, :description, :location, :image)");
                $insert->execute([
                    ":name" => $name,
                    ":description" => $description,
                    ":location" => $location,
                    ":image" => $image
                ]);
                // Check if the file was successfully uploaded
                if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
                    // Redirect upon success
                    header("Location: show-hotels.php");
                } else {
                    // File upload failed
                    echo "<script>alert('Image upload failed. Check folder permissions.');</script>";
                }
            } catch (PDOException $e) {
                // Catch and display any database errors
                echo "<script>alert('Database insertion failed: " . $e->getMessage() . "');</script>";
            }
        }
    }
}
?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5 d-inline">Create Hotels</h5>
        <form method="POST" action="create-hotels.php" enctype="multipart/form-data"> <!-- Fixed form action -->
          <!-- Name input -->
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="name" class="form-control" placeholder="Name" />
          </div>

          <!-- Image input -->
          <div class="form-outline mb-4 mt-4">
            <input type="file" name="image" class="form-control" />
          </div>

          <!-- Description input -->
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Description</label>
            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>

          <!-- Location input -->
          <div class="form-outline mb-4 mt-4">
            <label for="exampleFormControlTextarea1">Location</label>
            <input type="text" name="location" class="form-control" />
          </div>

          <!-- Submit button -->
          <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require "../layouts/footer.php"; ?>

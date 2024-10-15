<?php require "reUse/header.php"; ?>
<?php require "config/config.php"; ?>

<?php
// Form submission handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if any required fields are empty
    if (empty($_POST['full_name']) || empty($_POST['email']) || empty($_POST['message'])) {
        echo "<script>alert('Fields Cannot Be Empty');</script>";
    } else {
        // Assign the form inputs to variables
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'] ?? null; // Optional
        $message = $_POST['message'];

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO contact (full_name, email, phone_number, message) VALUES (:full_name, :email, :phone_number, :message)");
        // Execute the statement with the provided data
        if ($stmt->execute([
            ':full_name' => $full_name,
            ':email' => $email,
            ':phone_number' => $phone_number,
            ':message' => $message,
        ])) {
            echo "<script>alert('Message sent successfully!');</script>";
        } else {
            echo "<script>alert('Failed to send message. Please try again.');</script>";
        }
    }
}
?>

<!-- Hero Section -->
<section class="hero-wrap hero-wrap-2" style="background-image: url('images/image_2.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs mb-2"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home <i class="fa fa-chevron-right"></i></a></span> <span>Contact <i class="fa fa-chevron-right"></i></span></p>
                <h1 class="mb-0 bread">Contact Us</h1>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row no-gutters">
            <!-- Map Section -->
            <div class="col-md-8">
                <div id="map" style="width: 100%; height: 450px;"></div>
            </div>

            <!-- Contact Information and Form -->
            <div class="col-md-4 p-4 p-md-5 bg-white">
                <h2 class="font-weight-bold mb-4">Let's Get Started</h2>
                <p>We are happy to assist you. Fill out the form below or reach out via phone or email. We'll get back to you as soon as possible!</p>
                <p><a href="#" class="btn btn-primary">Book Service Now</a></p>
            </div>
<br>
            <div class="col-md-12">
            <br><br>
                <div class="wrapper">
                    <div class="row no-gutters">
                        <!-- Contact Form -->
                        <div class="col-lg-8 col-md-7 d-flex align-items-stretch">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h3 class="mb-4">Get in Touch</h3>
                                <div id="form-message-warning" class="mb-4"></div>
                                <div id="form-message-success" class="mb-4">Send Us A Message and we will get back to you shortly.</div>
                                <form method="POST" id="contactForm" name="contactForm" class="contactForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label" for="name">Full Name</label>
                                                <input type="text" class="form-control" name="full_name" id="name" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="label" for="email">Email Address</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label" for="subject">Phone Number</label>
                                                <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label" for="message">Message</label>
                                                <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" value="Send Message" class="btn btn-primary">
                                                <div class="submitting"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="col-lg-4 col-md-5 d-flex align-items-stretch">
                            <div class="info-wrap bg-primary w-100 p-md-5 p-4">
                                <h3>Let's Get in Touch</h3>
                                <p class="mb-4">We're open for any suggestions or just to have a chat</p>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-map-marker"></span></div>
                                    <div class="text pl-3"><p><span>Address:</span> 198 West 21th Street, Suite 721, Sydney, NSW</p></div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-phone"></span></div>
                                    <div class="text pl-3"><p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p></div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-paper-plane"></span></div>
                                    <div class="text pl-3"><p><span>Email:</span> <a href="mailto:info@yoursite.com">info@yoursite.com</a></p></div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-globe"></span></div>
                                    <div class="text pl-3"><p><span>Website:</span> <a href="#">yoursite.com</a></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leaflet.js and Map Initialization -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function initLeafletMap() {
            // Set the view to the location coordinates
            var map = L.map('map').setView([-32.0653889, 115.7507778], 13); // 32°03'55.4"S 115°45'02.8"E

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add a marker at the specified location
            var marker = L.marker([-32.0653889, 115.7507778]).addTo(map);
            marker.bindPopup("<b>We are here</b> <br> Lux Inn").openPopup();
        }

        // Initialize the map when the window loads
        window.onload = initLeafletMap;
    </script>

<?php require "reUse/footer.php"; ?>

<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
if (!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='" . ADMINURL . "/admins/login-admins.php'</script>";
}

$contacts = $conn->query("SELECT * FROM contact");
$contacts->execute();
$allContacts = $contacts->fetchAll(PDO::FETCH_OBJ);
?>  

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Contact Submissions</h5>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allContacts as $contact): ?>
                        <tr>
                            <td><?php echo $contact->full_name; ?></td>
                            <td><?php echo $contact->email; ?></td>
                            <td><?php echo $contact->subject; ?></td>
                            <td><?php echo $contact->message; ?></td>
                            <td><?php echo $contact->status; ?></td>
                            <td><?php echo $contact->created_at; ?></td>
                            <td><a href="status-contacts.php?id=<?php echo $contact->id; ?>" class="btn btn-warning text-white text-center">Status</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>

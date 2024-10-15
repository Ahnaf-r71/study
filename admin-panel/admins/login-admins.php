<?php require "../layouts/header.php";?>
<?php require "../../config/config.php";?>




<?php 


if (isset($_SESSION['adminname'])) {
  echo "<script>window.location.href='" . ADMINURL . "'</script>";
}

if(isset($_POST['submit']))
  {
  if(empty($_POST['email']) OR empty($_POST['password'])){

      echo "<script>alert('Fields Cannot Be Empty');</script>";
  }
  else{
      $email=$_POST['email'];
      $password=$_POST['password'];

     //validate

     $login = $conn->query("SELECT * FROM admins WHERE email='$email'");
     $login->execute();

     $fetch = $login->fetch(PDO::FETCH_ASSOC);

     //get row count

     if($login->rowCount() > 0){

      if(password_verify($password,$fetch['mypassword'])){
           //echo "<script>alert('Logged in')</script>";
          $_SESSION['adminname']=$fetch['adminname']; // right is is colname form table //plsplspls check tablename in phpmyadmin carefully T_T
          $_SESSION['id']=$fetch['id']; 

          echo "<script>window.location.href='" .ADMINURL. "'</script>";

      }
      else{   
          echo "<script>alert('LogIn Failed')</script>";
      }
  }
  else  {
    echo "<script>alert('Something is Wrong')</script>";
  }


}
  }

?>











      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mt-5">Login</h5>
              <form method="POST" class="p-auto" action="login-admins.php">
                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                   
                  </div>

                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
                    
                  </div>



                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

                 
                </form>

            </div>
       </div>
       <?php require "../layouts/footer.php";?>
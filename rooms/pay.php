<?php require "../reUse/header.php";?>
<?php require "../config/config.php";?>
<!-- cannot access without booking first logic -->
 <?php

    if(!isset($_SERVER['HTTP_REFERER']))
        {
            echo "<script>window.location.href='".APPURL."'</script>";
            exit();
        }

    ?>
<div class="hero-wrap js-fullheight" style=" background-image: url('<?php echo APPURL;?>images/image_2.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true" style="flex-direction:column!important;">
          <div class="col-md-7 ftco-animate" style="text-align:center;">
          <h2 class="subheading" style="color:white; font-weight:600; font-size:50px; text-align:center; margin-top:220px;">Pay Page For your room</h2>

          
    <div class="container" >  
                    <!-- Replace "test" with your own sandbox Business account app client ID -->
                    <script src="https://www.paypal.com/sdk/js?client-id=AdpTe_DZsi8AgwBkeXa3EERFHXzk3ILarucqm0DEXeq92bs7wroNRUE_GprBTz2z1bfB260ilfc_dkri&currency=USD"></script>
                    <!-- Set up a container element for the button -->
                    <div id="paypal-button-container"></div>
                    <script>
                        paypal.Buttons({
                        // Sets up the transaction when a payment button is clicked
                        createOrder: (data, actions) => {
                            return actions.order.create({
                            purchase_units: [{
                                amount: {
                                value:'<?php echo $_SESSION['price'];?>' // Can also reference a variable or function
                                }
                            }]
                            });
                        },
                        // Finalize the transaction after payer approval
                        onApprove: (data, actions) => {
                            return actions.order.capture().then(function(orderData) {
                          
                             window.location.href='http://localhost/luxInn';
                            });
                        }
                        }).render('#paypal-button-container');
                    </script>
                  
                </div>
                </div>
        </div>
      </div>
    </div>

                <?php require "../reUse/footer.php";?>
<?php  require_once ("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS ."header.php"); ?>


    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">
    <h4 class="text-center"><?php display_message(); ?></h4>
      <h1>Checkout</h1>


<form action="" method="post">
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="business" value="business@sparkedtec.com">
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
            <?php cart(); ?>

            
        </tbody>
        
    </table>
    
</form>





<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount">
<?php echo isset($_SESSION['item_qty']) ? $_SESSION['item_qty'] : "0"; ?>
</span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">$
<?php echo isset($_SESSION['total_amnt']) ? $_SESSION['total_amnt'] : "0"; ?>
</span></strong> </td>
</tr>

  </tbody>

</table>
<?php 
    if(isset($_SESSION['total_amnt'])){
        echo '<div id="paypal-button-container"></div>';
    }
?>


    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=AW6CZWcfpnfPnZlIEcRG86otCxAzTPijmRI_EsPZtj6GYQtpiOd0bz3FOkSRQ9Tz7NIopiVldqHIjofx"></script>
    <?php js_paypal(); ?>
    <!-- paypal script -->

</div><!-- CART TOTALS-->


 </div><!--Main Content-->


           <hr>

        <!-- Footer -->
       
    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT. DS . "footer.php");?>
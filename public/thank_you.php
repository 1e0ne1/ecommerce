
<?php  require_once ("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS ."header.php"); ?>


    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">
    
        <h1>Thank you! Your order has been placed.</h1>
        <h3>Order id = 
            <?php 
                if(isset($_GET['order_id'])){
                    echo "00100" . $_GET['order_id'];
                    session_destroy();
                } else {
                    redirect("index.php");
                }
            ?>
        </h3>

     

 </div><!--Main Content-->


           <hr>

        <!-- Footer -->
       
    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT. DS . "footer.php");?>



<?php require_once("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK . DS ."header.php"); ?>

<?php 
    if(!isset($_SESSION['username'])){

        redirect("../../public/index.php");

    } 

?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->


                <?php
                    $flag = 0;
                    // if($_SERVER['REQUEST_URI'] == "/hiperichinas/public/admin/" || $_SERVER['REQUEST_URI'] == "/hiperichinas/public/admin/index.php"){
                    //     include(TEMPLATE_BACK . DS ."admin_content.php");
                    // }
                    
                    if(isset($_GET['orders'])){
                        include(TEMPLATE_BACK . DS ."orders.php");
                        $flag = 1;
                    }

                    if(isset($_GET['products'])){
                        include(TEMPLATE_BACK . DS ."products.php");
                        $flag = 1;
                    }

                    if(isset($_GET['add_product'])){
                        include(TEMPLATE_BACK . DS ."add_product.php");
                        $flag = 1;
                    }

                    if(isset($_GET['categories'])){
                        include(TEMPLATE_BACK . DS ."categories.php");
                        $flag = 1;
                    }

                    if(isset($_GET['users'])){
                        include(TEMPLATE_BACK . DS ."users.php");
                        $flag = 1;
                    }

                    if(isset($_GET['edit_product'])){
                        include(TEMPLATE_BACK . DS ."edit_product.php");
                        $flag = 1;
                    }

                    if($flag==0){
                        include(TEMPLATE_BACK . DS ."admin_content.php");
                    }

                ?>



            </div>


            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <?php include(TEMPLATE_BACK . DS ."footer.php"); ?>
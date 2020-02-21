<?php edit_admin_products(); ?>

<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Add Product
   
</h1>
</div>

<?php 

  if(isset($_GET['id'])){
    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($_GET['id']));
    confirm($query);
    while($row = fetch_array($query)):

?>         


<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" class="form-control" value="<?php echo $row['product_title']; ?>">
       
    </div>


    <div class="form-group">
           <label for="product_description">Product Description</label>
      <textarea name="product_description" id="" cols="30" rows="10" class="form-control"><?php echo $row['product_description']; ?></textarea>
    </div>

    <div class="form-group">
           <label for="product_short_description">Product Short Description</label>
      <textarea name="product_short_description" id="" cols="30" rows="3" class="form-control"><?php echo $row['product_short_description']; ?></textarea>
    </div>


</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
    </div>


     <!-- Product Categories-->
     <hr>
    <div class="form-group">
         <label for="product_category_id">Product Category</label>
          
        <select name="product_category_id" id="" class="form-control">
            <?php show_categories_edit_product($row['product_category_id']); ?>
           
        </select>


      </div>

      





    <!-- Product Brands-->


    <div class="form-group">
      <label for="product_quantity">Product Quantity</label>
         <input type="number" name="product_quantity" class="form-control"  value="<?php echo $row['product_quantity']; ?>">
    </div>


<!-- Product Tags -->


    <div class="form-group">

        
          <label for="product_price">Product Price</label>
          <input type="number" name="product_price" class="form-control"  step="any" value="<?php echo $row['product_price']; ?>">
        
    </div>

    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file">
      
    </div>

    <div class="form-input">
    <img src="<?php echo "../../resources/uploads/" . $row['product_image'] ?>" style="max-height: 120px; width: auto;">
    </div>
    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">



</aside><!--SIDEBAR-->


    
</form>

<?php 

    endwhile;
  } else {
    redirect("index.php");
}


?>


            </div>
            <!-- /.container-fluid -->


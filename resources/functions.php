<?php

// helper

    function set_message($msg){
        if(!empty($msg)){
            $_SESSION['message'] = $msg;
        } else {
            $msg = "";
        }
    }

    function display_message(){
        if(isset($_SESSION["message"])){
            echo $_SESSION["message"];
            unset($_SESSION["message"]);
        }
    }

    function redirect($location){

        header("Location: $location");
    }


    function query($sql){
        
        global $connection;

        return mysqli_query($connection, $sql);
    }


    function confirm($result){
        
        global $connection;

        if(!$result){

            die("QUERY FAILED " . mysqli_error($connection));

        }
    }

    function return_id($result){
        
        global $connection;

        return mysqli_insert_id($connection);
    }


    function escape_string($string){
        
        global $connection;

        return mysqli_real_escape_string($connection, $string);
    }


    function fetch_array($result){

        return mysqli_fetch_array($result); 

    }

    // +++++++++++++++++++++++++++++++++++++++++FRONT END FUNCTIONS++++++++++++++++++++++++++++++++++++++++++++++

// get products

    function get_products(){
        
        $query = query("SELECT * FROM products");
        confirm($query);
        while($row = fetch_array($query)){
            if(substr($row['product_image'],0,4) != "http"){
                $image = "../resources/uploads/" . $row['product_image'];
            } else {
                $image = $row['product_image'];
            }
            $product = <<<DELIMITER
            <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                    <a href="item.php?id={$row['product_id']}"><img src="{$image}" alt=""  style="max-height: 120px; width: auto;"></a>
                    <div class="caption">
                        <h4 class="pull-right">\${$row['product_price']}</h4>
                        <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                        </h4>
                        <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                        <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
                    </div>
                </div>
            </div>
            DELIMITER;

            echo $product;
        }
    }

    function get_categories(){
        $query = query("SELECT * FROM categories");
        confirm($query);
        while($row = fetch_array($query)) {
            $categories = <<<DELIMITER
                <a href="category.php?id={$row['cat_id']}" class='list-group-item'>{$row['cat_title']}</a>

            DELIMITER;
            echo $categories;
        }
        
    }

    function get_products_in_category_page($id){
        $query = query("SELECT * FROM products WHERE product_category_id = ".$id);
        confirm($query);
        while($row = fetch_array($query)) {
            if(substr($row['product_image'],0,4) != "http"){
                $image = "../resources/uploads/" . $row['product_image'];
            } else {
                $image = $row['product_image'];
            }
            $categories_product = <<<DELIMITER
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$image}" alt="">
                    <div class="h-auto">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['product_short_description']}</p>
                        <p>
                            <a href="#" class="btn btn-primary">
                                Buy Now!
                            </a> 
                            <a href="item.php?id={$row['product_id']}" class="btn btn-default">
                                More Info
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            DELIMITER;
            echo $categories_product;
        }
    }

    function get_products_in_shop_page(){
        $query = query("SELECT * FROM products");
        confirm($query);
        while($row = fetch_array($query)) {
            $categories_product = <<<DELIMITER
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row['product_image']}" alt="">
                    <div class="caption" style="height: 240px;">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['product_short_description']}</p>
                        <p>
                            <a href="#" class="btn btn-primary">
                                Buy Now!
                            </a> 
                            <a href="item.php?id={$row['product_id']}" class="btn btn-default">
                                More Info
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            DELIMITER;
            echo $categories_product;
        }
    }

    function login_user(){
        
        if(isset($_POST['submit'])){
            $username = escape_string($_POST['username']);
            $password = escape_string($_POST['password']);

            $query = query("SELECT * FROM users where username = '{$username}' and password = '{$password}'");
            confirm($query);
            
            if(mysqli_num_rows($query) == 0){
                set_message("Your password or username are wrong!");
                redirect("login.php");
            } else {
                $_SESSION['username'] = $username;
                // set_message("Welcome to admin");
                redirect("admin");
            }
        }
    }

    function send_message(){
        if(isset($_POST['submit'])){
            $from_name = $POST['name'];
            $email = $POST['email'];
            $subject = $POST['subject'];
            $message = $POST['message'];

            $headers = "From: {$from_name} ";

            
        }
    }

    function get_orders(){
        $query = query("SELECT * FROM orders");
        confirm($query);
        while($row = fetch_array($query)) {
            echo <<<DELIMETER
            <tr>
                <td>{$row['order_id']}</td>
                <td>{$row['order_amount']}</td>
                <td>{$row['order_transaction']}</td>
                <td>{$row['order_status']}</td>
                <td>{$row['order_date']}</td>
                <td>{$row['payer_email']}</td>
                <td>{$row['invoice_number']}</td>
                <!---<td>
                    <a class='btn btn-danger' href="../../resources/back/delete_order.php">
                        <span class="glyphicon glyphicon-remove">
                    </span>
                    </a>
                </td> -->
            </tr>

            DELIMETER;
        }
    }

    function get_admin_products(){
        $query = query("SELECT a.*, b.cat_title FROM products a inner join categories b on a.product_category_id = b.cat_id");
        confirm($query);
        while($row = fetch_array($query)) {
            if(substr($row['product_image'],0,4) != "http"){
                $image = "../../resources/uploads/" . $row['product_image'];
            } else {
                $image = $row['product_image'];
            }
            
            echo <<<DELIMETER
            <tr>
                <td>{$row['product_id']}</td>
                <td>{$row['product_title']}</td>
                <td>{$row['cat_title']}</td>
                <td>{$row['product_price']}</td>
                <td>{$row['product_quantity']}</td>
                <td><img src="{$image}" style="width=auto; height: 50px;"></td>
                <td>
                    <a class='btn btn-warning' href="?edit_product&id={$row['product_id']}">
                        <span class="glyphicon glyphicon-pencil">
                    </span>
                    </a>
                    <a class='btn btn-danger' href="../../resources/templates/back/delete_products.php?id={$row['product_id']}">
                        <span class="glyphicon glyphicon-remove">
                    </span>
                    </a>
                </td>
            </tr>

            DELIMETER;
        }
    }

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ADD PRODUCTS IN ADMIN++++++++++++++++++++++++++++++++++++++++++++++

    function add_admin_products(){
        if(isset($_POST['publish'])){
            $product_title              = escape_string($_POST['product_title']);
            $product_category_id        = escape_string($_POST['product_category_id']);
            $product_price              = escape_string($_POST['product_price']);
            $product_description        = escape_string($_POST['product_description']);
            $product_short_description  = escape_string($_POST['product_short_description']);
            $product_quantity           = escape_string($_POST['product_quantity']);
            $product_image              = $_FILES['file']['name'];
            $image_temp_location        = $_FILES['file']['tmp_name'];

            move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);
            
            $query = query("INSERT INTO 
                products (
                    product_title,
                    product_category_id,
                    product_price,
                    product_short_description,
                    product_description,
                    product_quantity,
                    product_image
                ) VALUES (
                    '{$product_title}',
                    {$product_category_id},
                    {$product_price},
                    '{$product_short_description}',
                    '{$product_description}',
                    {$product_quantity},
                    '{$product_image}'
                )");
            confirm($query);
            $id = return_id($query);
            set_message("New Product with id {$id} was added");
            redirect("index.php?products");
        }

    }

    function show_categories_add_product(){
        $query = query("SELECT * FROM categories");
        confirm($query);
        while($row = fetch_array($query)) {
            $categories_option = <<<DELIMITER
                <option value="{$row['cat_id']}">{$row['cat_title']}</option>

            DELIMITER;
            echo $categories_option;
        }
        
    }



?>
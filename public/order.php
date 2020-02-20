<?php  require_once ("../resources/config.php"); ?>

<?php

    if(isset($_POST)){
        $status = escape_string($_POST['status']);
        $transaction = escape_string($_POST['transaction_id'])    ;
        $payer_email = escape_string($_POST['email_address']);

        $total_amount = $_SESSION['total_amnt'];
        $query = query("INSERT INTO orders (
                order_amount, 
                order_transaction, 
                order_status, 
                payer_email, 
                order_date
            ) VALUES (
                ".$total_amount.",
                '".$transaction."',
                '".$status."',
                '".$payer_email."',
                DATE(DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -6 HOUR))
        )");
        $order_id= return_id($query);

        foreach($_SESSION as $name => $value){
            if($value > 0){
                if(substr($name, 0, 7) == "product"){
                    $query = query("SELECT * FROM products WHERE product_id = " . escape_string(substr($name, 8, strlen($name) - 8)));
                    confirm($query);
                    
                    while($row = fetch_array($query)){
                        $sub = $row['product_price'] * $value;
                        $product_id = $row['product_id'];
                        $quantity = $value;
                    }
                    $query = query("INSERT INTO order_description (
                        order_id, 
                        product_id, 
                        product_quantity, 
                        subtotal
                    ) VALUES (
                        ".$order_id.",
                        ".$product_id.",
                        ".$quantity.",
                        ".$sub."
                )");   
                }
                
            }
        }
        echo $order_id;
    }

?>
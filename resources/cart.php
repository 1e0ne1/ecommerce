<?php  require_once ("config.php"); ?>

<?php

    if(isset($_GET['add'])){

        $query = query("SELECT * FROM products WHERE product_id = " . escape_string($_GET['add']));
        confirm($query);

        while($row = fetch_array($query)){
            
            if($row['product_quantity'] > $_SESSION['product_' . $_GET['add']]){
                
                $_SESSION['product_' . $_GET['add']] += 1;

            } else {

                set_message("We only have ". $row['product_quantity'] . " " . $row['product_title'] .  " available");
            }
        }
        
        redirect("../public/checkout.php");

    }

    
    if(isset($_GET['remove'])){
            
        if($_SESSION['product_' . $_GET['remove']] > 0){
            
            $_SESSION['product_' . $_GET['remove']] -= 1;

        } else {

            unset($_SESSION['total_amnt']);
            unset($_SESSION['item_qty']);

        }
        
        redirect("../public/checkout.php");

    }


    if(isset($_GET['delete'])){
       
        $_SESSION['product_' . $_GET['delete']] = '0';
        unset($_SESSION['total_amnt']);
        unset($_SESSION['item_qty']);

        redirect("../public/checkout.php");

    }

    function cart(){
        $total_amount=0;
        $item_quantity=0;
        $item_name = 1;
        $item_number = 1;
        $item_amount = 1;
        $item_quantity_form = 1;
        $js_paypal_items = "";

        foreach($_SESSION as $name => $value){
            if($value > 0){
                if(substr($name, 0, 7) == "product"){
                    $query = query("SELECT * FROM products WHERE product_id = " . escape_string(substr($name, 8, strlen($name) - 8)));
                    confirm($query);
                    
                    while($row = fetch_array($query)){
                        $sub = $row['product_price'] * $value;
                        $product = <<<DELIMETER
                        <tr>
                            <td>{$row['product_title']}</td>
                            <td>\${$row['product_price']}</td>
                            <td>{$value}</td>
                            <td>\${$sub}</td>
                            <td>
                                <a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}">
                                    <span class="glyphicon glyphicon-minus">
                                    </span>
                                </a>
                            
                                <a class='btn btn-success' href="../resources/cart.php?add={$row['product_id']}">
                                    <span class="glyphicon glyphicon-plus">
                                    </span>
                                </a>
                            
                                <a class='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}">
                                    <span class="glyphicon glyphicon-remove">
                                    </span>
                                </a>
                            </td>
                        </tr>
                        <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                        <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                        <input type="hidden" name="amount_{$item_amount}" value="{$row['product_price']}">
                        <input type="hidden" name="quantity_{$item_quantity_form}" value="{$value}">
    
                        DELIMETER;

                        $_SESSION['total_amnt'] = $total_amount += $sub;
                        $_SESSION['item_qty'] = $item_quantity += $value;
                        echo $product;
                        $item_name += 1;
                        $item_number += 1;
                        $item_amount += 1;
                        $item_quantity_form += 1;
                    }
                    
                    
                }
            }
            
        }
        
    }


    function js_paypal(){
        
        if(isset($_SESSION['total_amnt'])){
            $js_paypal_script = <<<DELIMETER
            <script>
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [
                            {
                                amount: {
                                    currency_code: "USD",
                                    value: "{$_SESSION['total_amnt']}",
                                    breakdown: {
                                        item_total: {
                                            currency_code: "USD",
                                            value: "{$_SESSION['total_amnt']}"
                                        },
                                        shipping: {
                                            currency_code: "USD",
                                            value: "0.00"
                                        },
                                        tax_total: {
                                            currency_code: "USD",
                                            value: "0.00"
                                        }
                                    }
                                },
                                items: [

            DELIMETER;
            
            foreach($_SESSION as $name => $value){
                if($value > 0){
                    if(substr($name, 0, 7) == "product"){
                        $query = query("SELECT * FROM products WHERE product_id = " . escape_string(substr($name, 8, strlen($name) - 8)));
                        confirm($query);
                        
                        while($row = fetch_array($query)){
                            $js_paypal_script .= <<<DELIMETER
                            {
                                name: "{$row['product_title']}",
                                sku: "sku0{$row['product_id']}",
                                unit_amount: {
                                    currency_code: "USD",
                                    value: "{$row['product_price']}"
                                },
                                quantity: "{$value}"
                            },
                            
                            DELIMETER;

                        }
                    }
                }
            }
            $js_paypal_script = substr($js_paypal_script, 0, strlen($js_paypal_script) - 3);
            $js_paypal_script .= <<<DELIMETER
                            ]
                            }
                        ]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        $.ajax({
                            type: "POST",
                            url: "order.php",
                            data: "status=" + details.purchase_units[0].payments.captures[0].status + 
                                    "&transaction_id=" + details.purchase_units[0].payments.captures[0].id + 
                                    "&email_address=" + details.payer.email_address,
                                success: function(result) {
                                    if(result == 0){
                                        alert("Something went wrong. Please try again.");
                                    } else {
                                        window.location.assign("thank_you.php?order_id=" + result);
                                    }
                                }
                        });
                        //console.log(details.purchase_units[0].payments.captures[0].status);
                        //console.log(details.purchase_units[0].payments.captures[0].id);
                        //console.log(details.payer.email_address);
                    });
                }
            }).render('#paypal-button-container');
            </script>
            DELIMETER;

            echo $js_paypal_script;
        }
        
        
        
    }

    
    
?>

<?php  require_once ("../resources/config.php"); ?>

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
        
        redirect("checkout.php");

    }

    
    if(isset($_GET['remove'])){
            
        if($_SESSION['product_' . $_GET['remove']] > 0){
            
            $_SESSION['product_' . $_GET['remove']] -= 1;

        } else {

            unset($_SESSION['total_amnt']);
            unset($_SESSION['item_qty']);

        }
        
        redirect("checkout.php");

    }


    if(isset($_GET['delete'])){
       
        $_SESSION['product_' . $_GET['delete']] = '0';
        unset($_SESSION['total_amnt']);
        unset($_SESSION['item_qty']);

        redirect("checkout.php");

    }

    function cart(){
        $total_amount=0;
        $item_quantity=0;
        $item_name = 1;
        $item_number = 1;
        $item_amount = 1;
        $item_quantity_form = 1;

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
                                <a class='btn btn-warning' href="cart.php?remove={$row['product_id']}">
                                    <span class="glyphicon glyphicon-minus">
                                    </span>
                                </a>
                            
                                <a class='btn btn-success' href="cart.php?add={$row['product_id']}">
                                    <span class="glyphicon glyphicon-plus">
                                    </span>
                                </a>
                            
                                <a class='btn btn-danger' href="cart.php?delete={$row['product_id']}">
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

    
    
?>
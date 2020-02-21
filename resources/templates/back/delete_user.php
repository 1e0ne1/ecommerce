<?php 

    require_once("../../config.php"); 

    if(isset($_GET['id'])){
        $user_id = escape_string($_GET['id']);

        $query = query("DELETE FROM users WHERE user_id = " . $user_id);
        confirm($query);

        set_message("user with id {$user_id} was deleted");
        redirect("../../../public/admin/index.php?users");

    } else {
        redirect("../../../public/admin/index.php?users");
    }





?>
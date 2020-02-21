<?php 

    require_once("../../config.php"); 

    if(isset($_GET['id'])){
        $category = escape_string($_GET['id']);

        $query = query("DELETE FROM categories WHERE cat_id = " . $category);
        confirm($query);

        set_message("category with id {$category} was deleted");
        redirect("../../../public/admin/index.php?categories");

    } else {
        redirect("../../../public/admin/index.php?categories");
    }





?>
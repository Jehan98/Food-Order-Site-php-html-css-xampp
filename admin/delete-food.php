<?php
     
    include("../config/constants.php");

    if(isset($_GET["id"]) AND isset($_GET["image_name"])){

        //get id of the food
        $id = $_GET["id"];
        $image_name = $_GET["image_name"];
        //sql query to delete food
        $sql = "DELETE FROM tbl_food WHERE id = $id ";
        $res = mysqli_query($conn, $sql);

        //delete image
        if($image_name != ""){
            $path = "../images/food/".$image_name;
            $remove = unlink($path);
        }else{
            $remove = true;
        }

        if($res==TRUE AND $remove == true){
            
            $_SESSION["delete"] = "<div class ='success'> Food deleted successfully</div>";
            //redirect to manage-food
            header("location:".SITEURL."admin/manage-food.php");
        }
        elseif($res==TRUE){
            $_SESSION["delete"] = "<div class ='error-2'> Food deleted. Failed to remove food Image</div>";
            //redirect to manage-food
            header("location:".SITEURL."admin/manage-food.php");
        }
        else{
            //session variable for message
            $_SESSION["delete"] = "<div class ='error'> Failed to delete food</div>";
            //redirect to manage-food
            header("location:".SITEURL."admin/manage-food.php");
        }
    }else{
        //session variable for message
        $_SESSION["delete"] = "<div class ='error'> Failed to delete food</div>";
        //redirect to manage-food
        header("location:".SITEURL."admin/manage-food.php");
    }
?>
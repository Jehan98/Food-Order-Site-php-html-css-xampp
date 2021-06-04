<?php
     
    include("../config/constants.php");

    if(isset($_GET["id"]) AND isset($_GET["image_name"])){

        //get id of the category
        $id = $_GET["id"];
        $image_name = $_GET["image_name"];
        //sql query to delete category
        $sql = "DELETE FROM tbl_category WHERE id = $id ";
        $res = mysqli_query($conn, $sql);

        //delete image
        if($image_name != ""){
            $path = "../images/category/".$image_name;
            $remove = unlink($path);
        }else{
            $remove = true;
        }

        if($res==TRUE AND $remove == true){
            
            $_SESSION["delete"] = "<div class ='success'> Category deleted successfully</div>";
            //redirect to manage-category
            header("location:".SITEURL."admin/manage-category.php");
        }
        elseif($res==TRUE){
            $_SESSION["delete"] = "<div class ='error-2'> Category deleted. Failed to remove category Image</div>";
            //redirect to manage-category
            header("location:".SITEURL."admin/manage-category.php");
        }
        else{
            //session variable for message
            $_SESSION["delete"] = "<div class ='error'> Failed to delete category</div>";
            //redirect to manage-category
            header("location:".SITEURL."admin/manage-category.php");
        }
    }else{
        //session variable for message
        $_SESSION["delete"] = "<div class ='error'> Failed to delete category</div>";
        //redirect to manage-category
        header("location:".SITEURL."admin/manage-category.php");
    }
?>
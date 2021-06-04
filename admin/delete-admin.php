<?php
     
    include("../config/constants.php");

    if(isset($_GET["id"])){

        //get id of the admin
        $id = $_GET["id"];

        //sql query to delete admin
        $sql = "DELETE FROM tbl_admin WHERE id = $id ";
        $res = mysqli_query($conn, $sql);

        //to check whether query is executed successfully
        if($res==TRUE){
            //session variable for message
            $_SESSION["delete"] = "<div class ='success'> Admin deleted successfully</div>";
            //redirect to manage-admin
            header("location:".SITEURL."admin/manage-admin.php");
        }
        else{
            //session variable for message
            $_SESSION["delete"] = "<div class ='error'> Failed to delete Admin</div>";
            //redirect to manage-admin
            header("location:".SITEURL."admin/manage-admin.php");
        }
    }else {
        header("location:".SITEURL."admin/manage-admin.php");
    }
    //redirect to manage-admin page with message


?>
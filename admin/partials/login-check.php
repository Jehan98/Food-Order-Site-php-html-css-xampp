<?php 
    
    //authorization - access control
    //user is logged in or not
    if(!isset($_SESSION["user"])){
        //redirect to login 
        $_SESSION["no-login-message"] = "<div class='error'>You have to Login first</div>";
        header("location:".SITEURL."admin/login.php");
    }

?>
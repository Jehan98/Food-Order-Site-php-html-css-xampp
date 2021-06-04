<?php 
include("../config/constants.php"); 

//session destroy
session_destroy();
//redirect to login
header("location:".SITEURL."admin/login.php");

?>
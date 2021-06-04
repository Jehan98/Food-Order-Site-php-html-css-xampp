<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            //get id of current admin
            $id = $_GET["id"];

            if(isset($_SESSION["update_password"])){
                echo $_SESSION["update_password"]; 
                unset($_SESSION["update_password"]); //removing session key value
            }
        ?>
        <br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td><input type="password" name="current_password" placeholder="Old Password"></td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td><input type="password" name="new_password" placeholder="New Password"></td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm Password"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Update Password" class="btn-secondary"></td>
                </tr>
            </table>
        </form>
        <!-- go back to manage-admin -->
        <form action="manage-admin.php" class="btn-goback">
            <input type="submit" name="go_back" value="Go Back" class="btn-primary">
        </form>
    </div>

</div>

<?php include("partials/footer.php") ?>

<?php 
    // process the value from form and save in database
    
    //check whether button is clicked
    if(isset($_POST["submit"]))
    {
        //button clicked

        // 1. Get data from form
        $current_password = md5($_POST["current_password"]); 
        $new_password = md5($_POST["new_password"]);
        $confirm_password = md5($_POST["confirm_password"]); 

        // 2. Sql query to save data to database
        $sql = "SELECT * FROM tbl_admin WHERE
            id = $id AND password = '$current_password';
            ";

        // 3. execute data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. check whether query is executed
        if($res == TRUE){

            $count = mysqli_num_rows($res);
            //check whether id, password is matched and data is available
            if($count == 1 AND $new_password == $confirm_password){
                //changing password
                $sql = "UPDATE tbl_admin SET
                password = '$new_password'
                WHERE id = $id AND password='$current_password'
                ";
                //execute query
                $res = mysqli_query($conn, $sql) or die(mysqli_error());
                
                if($res == TRUE){
                $_SESSION["update_password"] = "<div class ='success'>Password updated successfully</div>";
                
                //redirect page to add admin
                header("location:".SITEURL."admin/manage-admin.php");
                }
                else{
                    $_SESSION["update_password"] = "<div class ='error'>Password update failed</div>";
                
                    header("location:".SITEURL."admin/update-password.php?id=$id");
                }
            }
            elseif(($count == 1 AND $new_password != $confirm_password)){
                
                $_SESSION["update_password"] = "<div class ='error'>Passwords doesn't match</div>";
                
                header("location:".SITEURL."admin/update-password.php?id=$id");
            }
            else{
                
                $_SESSION["update_password"] = "<div class ='error'>Failed to update Password</div>";
                
                header("location:".SITEURL."admin/update-password.php?id=$id");
            }
        }
        else{
            
            $_SESSION["update_password"] = "<div class ='error'>Failed to update Password</div>";
            
            header("location:".SITEURL."admin/update-password.php?id=$id");
        }
    }
    
?>
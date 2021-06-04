<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
            //get id of current admin
            $id = $_GET["id"];
            // query
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";
            //execute
            $res = mysqli_query($conn, $sql);
            //check whether query is executed or not
            if($res==TRUE){
                //check whether data is available
                $count = mysqli_num_rows($res);
                if($count == 1){
                    $row = mysqli_fetch_assoc($res);
                    
                    $full_name = $row["full_name"];
                    $username = $row["username"];
                }
                else{
                    //redirect to manage-admin.php
                    header("location:".SITEURL."admin/manage-admin.php");
                }
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" value = "<?php echo $full_name ?>"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" value = "<?php echo $username ?>"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Update Admin" class="btn-secondary"></td>
                </tr>
            </table>
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
        $full_name = $_POST["full_name"];
        $username = $_POST["username"];

        // 2. Sql query to save data to database
        $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username'
            WHERE id = $id;
            ";

        // 3. execute data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. check whether data is inserted
        if($res == TRUE){
            //create a variable to display message
            $_SESSION["update"] = "<div class ='success'>Admin updated successfully</div>";
            
            //redirect page to manage admin
            header("location:".SITEURL."admin/manage-admin.php");
        }
        else{
            //create a variable to display message
            $_SESSION["update"] = "<div class ='failed'>Failed to update Admin</div>";
            
            //redirect page to add admin
            header("location:".SITEURL."admin/add-admin.php");
        }
    }
    
?>
<?php include("partials/menu.php") ?>

        <!-- Main Content Section -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br>

                <?php 
                    if(isset($_SESSION["add"])){
                        echo $_SESSION["add"]; 
                        unset($_SESSION["add"]); //removing session key value
                    }

                    if(isset($_SESSION["delete"])){
                        echo $_SESSION["delete"]; 
                        unset($_SESSION["delete"]); //removing session key value
                    }
                    
                    if(isset($_SESSION["update"])){
                        echo $_SESSION["update"]; 
                        unset($_SESSION["update"]); //removing session key value
                    }
                    
                    if(isset($_SESSION["update_password"])){
                        echo $_SESSION["update_password"]; 
                        unset($_SESSION["update_password"]); //removing session key value
                    }
                ?>
                <br><br>
                <!-- button to add admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br/><br><br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        // query to get all admin
                        $sql = "SELECT * FROM tbl_admin";
                        //execute the query
                        $res = mysqli_query($conn, $sql);
                        //check whether query executed
                        if($res==TRUE){
                            //count the rows to check whether we have the data in database or not
                            $count = mysqli_num_rows($res);
                            if($count>0){
                                //wehave data in data base
                                $counter = 1;
                                while( $rows = mysqli_fetch_assoc($res)){
                                    //using while loop to get all data from database and will execute as long as number of rows
                                    $id = $rows["id"];
                                    $full_name = $rows["full_name"];
                                    $username = $rows["username"];
                                    //display values in table
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $counter++ ?>.</td>
                                        <td><?php echo $full_name ?></td>
                                        <td><?php echo $username ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                    </tr>
                                    
                                    <?php
                                }
                            }
                            else{
                                //we dont have data in database
                            }
                        }
                    ?>
                </table>
            </div>
        </div>

<?php include("partials/footer.php") ?>
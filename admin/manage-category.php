<?php include("partials/menu.php") ?>

 <!-- Main Content Section -->
 <div class="main-content">
            <div class="wrapper">
                <h1>Manage Category</h1>
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

                    if(isset($_SESSION["remove_image"])){
                        echo $_SESSION["remove_image"]; 
                        unset($_SESSION["remove_image"]); //removing session key value
                    }
                ?>
                <br><br>

                <!-- button to add admin -->
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
                <br/><br><br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        // query to get all admin
                        $sql = "SELECT * FROM tbl_category";
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
                                    $title = $rows["title"];
                                    $image_name = $rows["image_name"];
                                    $featured = $rows["featured"];
                                    $active = $rows["active"];
                                    //display values in table
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $counter++ ?>.</td>
                                        <td><?php echo $title ?></td>
                                        <td><?php 
                                                if($image_name == ""){
                                                    echo "<div class='error'>Image not added</div>";
                                                }
                                                else{
                                                    ?>
                                                    <img src="<?php echo SITEURL.'images/category/'.$image_name; ?>" width = "100px">
                                                    <?php
                                                } 
                                            ?>
                                        </td>
                                        <td><?php echo $featured ?></td>
                                        <td><?php echo $active ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update category</a>
                                            <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete category</a>
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
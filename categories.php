<?php include("partials-front/menu.php"); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                    // query to get all admin
                    $sql = "SELECT * FROM tbl_category WHERE active='yes'";
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
                                <a href="category-foods.php">
                                <div class="box-3">
                                    <div>
                                    <?php
                                        if($image_name==""){
                                            ?>
                                            <img src="<?php echo SITEURL.'images/No_Image.jpg' ?>" alt="Momo" class="img-responsive img-curve">
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <img src="<?php echo SITEURL.'images/category/'.$image_name; ?>" alt="Momo" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                    </div>
                                    <div class= "float-container">
                                    <h3 class="float-text text-red"><?php echo $title; ?></h3>
                                    </div>
                                </div>
                                </a>  
                                <?php
                            }
                        }
                        else{
                            //we dont have data in database
                            echo "Category not available";
                        }
                    }
                ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


<?php include("partials-front/footer.php"); ?>

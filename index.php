<?php include("partials-front/menu.php"); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="food-search.html" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
                <!-- to get categories -->
                <?php
                    // query to get all admin
                    $sql = "SELECT * FROM tbl_category WHERE active='yes' AND featured='yes' LIMIT 3";
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
                                <div class="box-3 float-container">
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
                                    

                                    <h3 class="float-text text-red"><?php echo $title; ?></h3>
                                </div>
                                </a>  
                                <?php
                            }
                        }
                        else{
                            //we dont have data in database
                        }
                    }
                ?>
                <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                    // query to get all admin
                    $sql = "SELECT * FROM tbl_food WHERE active='yes' AND featured='yes' LIMIT 6";
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
                                $price = $rows["price"];
                                $description = $rows["description"];
                                $image_name = $rows["image_name"];
                                //display values in table
                                ?>
                                    <?php
                                        if($image_name==""){
                                            $image_name = "No_Image.jpg";
                                        }
                                        ?>
                                        <div class="food-menu-box">
                                            <div class="food-menu-img">
                                            <img src="<?php echo SITEURL.'images/food/'.$image_name; ?>" alt="Momo" class="img-responsive img-curve">
                                            </div>

                                            <div class="food-menu-desc">
                                                <h4><?php echo $title ?></h4>
                                                <p class="food-price">$<?php echo $price ?></p>
                                                <p class="food-detail">
                                                    <?php echo $description ?>
                                                </p>
                                                <br>
                                                <a href="<?php echo SITEURL.'order.php'?>" class="btn btn-primary">Order Now</a>
                                            </div>
                                        </div>
                                        <?php        
                                        }
                            }
                        }
                        else{
                            //we dont have data in database
                        }
                ?>

            
            


            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL.'foods.php'?>">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include("partials-front/footer.php"); ?>

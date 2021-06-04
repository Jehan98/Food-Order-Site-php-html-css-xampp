<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br>
        <?php
            if(isset($_SESSION["update"])){
                echo $_SESSION["update"]; 
                unset($_SESSION["update"]); //removing session key value
            }
            if(isset($_SESSION["upload"])){
                echo $_SESSION["upload"]; 
                unset($_SESSION["upload"]); //removing session key value
            }
        ?>
        <br><br>
        <?php
            //get id of current admin
            $id = $_GET["id"];
            // query
            $sql = "SELECT * FROM tbl_food WHERE id=$id";
            //execute
            $res = mysqli_query($conn, $sql);
            //check whether query is executed or not
            if($res==TRUE){
                //check whether data is available
                $count = mysqli_num_rows($res);
                if($count == 1){
                    $row = mysqli_fetch_assoc($res);
                    
                    $title = $row["title"];
                    $price = $row["price"];
                    $description = $row["description"];
                    $image_name = $row["image_name"];
                    $featured = $row["featured"];
                    $active = $row["active"];
                }
                else{
                    //redirect to manage-food.php
                    header("location:".SITEURL."admin/manage-food.php");
                    die();
                }
            }
            ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" maxlength="35"><?php echo $description;?></textarea></td>
                </tr>
                <tr>
                <tr>
                    <td>Price: </td>
                    <td><input type="number" step=".01" name="price" value="<?php echo $price; ?>"></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($image_name != ""){
                                ?>
                                <img src="<?php echo SITEURL.'images/food/'.$image_name; ?>" width = "100px">
                                <?php
                            }
                            else{
                                echo "<div class='error'>Image not added</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Select Category:</td>
                    <td>
                        <select name="category">
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
                                            //display values in table
                                            echo "<option value=".$id.">".$title."</option>";
                                            
                                        }
                                    }
                                    else{
                                        //we dont have data in database
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="yes" <?php if($featured == "yes"){echo "checked";}?>> Yes
                        <input type="radio" name="featured" value="no" <?php if($featured == "no"){echo "checked";}?>> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                    <input type="radio" name="active" value="yes" <?php if($active == "yes"){echo "checked";}?>> Yes
                    <input type="radio" name="active" value="no" <?php if($active == "no"){echo "checked";}?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Update Food" class="btn-secondary"></td>
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
        // 1. Get data from form
        $title = $_POST["title"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $category = $_POST["category"];
        $featured = $_POST["featured"];
        $active = $_POST["active"];
        $remove = true;
        //image upload
        if($_FILES["image"]["name"] != ""){

                //delete image
            if($image_name != ""){
                $path = "../images/food/".$image_name;
                $remove = unlink($path);
            }else{
                $remove = true;
            }
            //to upload we need source name, path, and where to store
            $image_name = $_FILES["image"]["name"];

            // auto renaming image
            //get the extension(jpg, png etc.)
            $ext = end(explode(".",$image_name));

            //rename image
            $image_name = "Food_".rand(0, 99999).".".$ext;

            $source_path = $_FILES["image"]["tmp_name"];
            $destination_path = "../images/food/".$image_name;
            //upload
            $upload = move_uploaded_file($source_path, $destination_path);
            //check whether image is uploaded
            if($upload == FALSE){
                $_SESSION["upload"] = "<div class = 'error'>Failed to upload image</div>";
                header("location:".SITEURL."admin/update-food.php");
                die();
            }
        }


        // 2. Sql query to save data to database
        $id = $_GET["id"];
        $sql = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            price = '$price',
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
            WHERE id = $id;
            ";

        // 3. execute data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. check whether data is inserted
        if($res == TRUE AND $remove == true){
            //create a variable to display message
            $_SESSION["update"] = "<div class ='success'>Food updated successfully</div>";
            
            //redirect page to manage food
            header("location:".SITEURL."admin/manage-food.php");
        }
        elseif($res==TRUE){

            $_SESSION["delete"] = "<div class ='error-2'> Food deleted. Failed to remove previous Image</div>";
            header("location:".SITEURL."admin/manage-food.php");
        }
        else{

            $_SESSION["update"] = "<div class ='failed'>Failed to update food</div>";
            header("location:".SITEURL."admin/update-food.php");
        }
    }
    
?>
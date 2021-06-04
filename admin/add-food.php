<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br>

        <?php
            if(isset($_SESSION["add"])){
                echo $_SESSION["add"]; 
                unset($_SESSION["add"]); //removing session key value
            }
            if(isset($_SESSION["upload"])){
                echo $_SESSION["upload"]; 
                unset($_SESSION["upload"]); //removing session key value
            }
        ?>
        <br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Food Title"></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" maxlength = "35" placeholder="Food Descrption"></textarea></td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" step=".01" placeholder="Food Price"></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
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
                    <td colspan="2">
                        <br>
                        <a href="http://localhost/food-order/admin/add-category.php?page=add-food" class="btn-primary">Add New Category</a>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                    <input type="radio" name="featured" value="yes"> Yes
                    <input type="radio" name="featured" value="no" checked> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                    <input type="radio" name="active" value="yes"> Yes
                    <input type="radio" name="active" value="no" checked> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Add Food" class="btn-secondary"></td>
                </tr>
            </table>
        </form>
    </div>

</div>
<?php include("partials/footer.php");?>
<?php 
    
    //check whether button is clicked
    if(isset($_POST["submit"])){
        // 1. Get data from form
        $title = $_POST["title"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $category = $_POST["category"];
        $featured = $_POST["featured"];
        $active = $_POST["active"]; //password encryption
        
        //image upload
        if($_FILES["image"]["name"] != ""){
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
                header("location:".SITEURL."admin/add-food.php");
                die();
            }
        }
        else{
            $image_name = "";
        }

        // 2. Sql query to save data to database
        $sql = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = '$price',
            category_id = '$category',
            featured = '$featured',
            active = '$active',
            image_name = '$image_name'
            ";

        // 3. execute data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. check whether data is inserted
        if($res == TRUE){
            //create a variable to display message
            $_SESSION["add"] = "<div class ='success'>Food added successfully</div>";
            
            //redirect page to manage food
            header("location:".SITEURL."admin/manage-food.php");
        }
        else{
            //create a variable to display message
            $_SESSION["add"] = "<div class ='failed'>Failed to add food</div>";
            
            //redirect page to add food
            header("location:".SITEURL."admin/add-food.php");
        }
    }
    
?>

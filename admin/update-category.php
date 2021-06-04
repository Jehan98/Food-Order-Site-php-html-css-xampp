<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            //get id of current admin
            $id = $_GET["id"];
            // query
            $sql = "SELECT * FROM tbl_category WHERE id=$id";
            //execute
            $res = mysqli_query($conn, $sql);
            //check whether query is executed or not
            if($res==TRUE){
                //check whether data is available
                $count = mysqli_num_rows($res);
                if($count == 1){
                    $row = mysqli_fetch_assoc($res);
                    
                    $title = $row["title"];
                    $image_name = $row["image_name"];
                    $featured = $row["featured"];
                    $active = $row["active"];
                }
                else{
                    //redirect to manage-category.php
                    header("location:".SITEURL."admin/manage-category.php");
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
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($image_name != ""){
                                ?>
                                <img src="<?php echo SITEURL.'images/category/'.$image_name; ?>" width = "100px">
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
                    <td colspan="2"><input type="submit" name="submit" value="Update Category" class="btn-secondary"></td>
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
        $title = $_POST["title"];
        $featured = $_POST["featured"];
        $active = $_POST["active"];
        $remove = true;
        //image upload
        if($_FILES["image"]["name"] != ""){

                //delete image
            if($image_name != ""){
                $path = "../images/category/".$image_name;
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
            $image_name = "Food_Category_".rand(0, 99999).".".$ext;

            $source_path = $_FILES["image"]["tmp_name"];
            $destination_path = "../images/category/".$image_name;
            //upload
            $upload = move_uploaded_file($source_path, $destination_path);
            //check whether image is uploaded
            if($upload == FALSE){
                $_SESSION["upload"] = "<div class = 'error'>Failed to upload image</div>";
                header("location:".SITEURL."admin/update-category.php");
                die();
            }
        }


        // 2. Sql query to save data to database
        $sql = "UPDATE tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id = $id;
            ";

        // 3. execute data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. check whether data is inserted
        if($res == TRUE AND $remove == true){
            //create a variable to display message
            $_SESSION["update"] = "<div class ='success'>Category updated successfully</div>";
            
            //redirect page to manage category
            header("location:".SITEURL."admin/manage-category.php");
        }
        elseif($res==TRUE){

            $_SESSION["delete"] = "<div class ='error-2'> Category deleted. Failed to remove previous Image</div>";
            header("location:".SITEURL."admin/manage-category.php");
        }
        else{

            $_SESSION["update"] = "<div class ='failed'>Failed to update category</div>";
            header("location:".SITEURL."admin/update-category.php");
        }
    }
    
?>
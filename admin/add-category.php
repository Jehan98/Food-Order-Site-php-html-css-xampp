<?php include("partials/menu.php") ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
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
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
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
                    <td colspan="2"><input type="submit" name="submit" value="Add Category" class="btn-secondary"></td>
                </tr>
            </table>
        </form>
    </div>

</div>

<?php include("partials/footer.php") ?>

<?php 
    //to check whether to which page we go back
    if(isset($_GET["page"])){
        $page = $_GET["page"];
    }
    else{
        $page = "manage-category";
    }
    
    //check whether button is clicked
    if(isset($_POST["submit"])){
        // 1. Get data from form
        $title = $_POST["title"];
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
            $image_name = "Food_Category_".rand(0, 99999).".".$ext;

            $source_path = $_FILES["image"]["tmp_name"];
            $destination_path = "../images/category/".$image_name;
            //upload
            $upload = move_uploaded_file($source_path, $destination_path);
            //check whether image is uploaded
            if($upload == FALSE){
                $_SESSION["upload"] = "<div class = 'error'>Failed to upload image</div>";
                header("location:".SITEURL."admin/add-category.php");
                die();
            }
        }
        else{
            $image_name = "";
        }

        // 2. Sql query to save data to database
        $sql = "INSERT INTO tbl_category SET
            title = '$title',
            featured = '$featured',
            active = '$active',
            image_name = '$image_name'
            ";

        // 3. execute data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. check whether data is inserted
        if($res == TRUE){
            //create a variable to display message
            $_SESSION["add"] = "<div class ='success'>Category added successfully</div>";
            
            //redirect page to manage category
            header("location:".SITEURL."admin/".$page.".php");
        }
        else{
            //create a variable to display message
            $_SESSION["add"] = "<div class ='failed'>Failed to add category</div>";
            
            //redirect page to add category
            header("location:".SITEURL."admin/add-category.php");
        }
    }
?>
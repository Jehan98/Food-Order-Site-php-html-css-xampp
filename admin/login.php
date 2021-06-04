<?php
    include("../config/constants.php");
    
?>

<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head> 
    <body>
        <div class="login text-center">
            <!-- login starts here -->
            <h1>Login</h1>
            <br><br>
            <form action="" method="POST">
                        <p>Username: </p>
                        <input type="text" name="username" placeholder = "Enter Username">
                        <br><br>
                        <p>Password: </p>
                        <input type="password" name="password" placeholder="Enter Password">
                        <br><br><br>
                        <input type="submit" name="submit" value="Login" class="btn-primary">
            </form>
            <br>
            <?php
                if(isset($_SESSION["login"])){
                    echo $_SESSION["login"]; 
                    unset($_SESSION["login"]); //removing session key value
                }
                if(isset($_SESSION["no-login-message"])){
                    echo $_SESSION["no-login-message"]; 
                    unset($_SESSION["no-login-message"]); //removing session key value
                }
            ?>
            <br>
            <p class = "text-center">Created By: <a href="https://www.linkedin.com/in/jehan-kulathilaka-9439831b1/">Jehan</a></p>
            
        </div>
    </body>

</html>

<?php
    // process the value from form and save in database
    
    //check whether button is clicked
    if(isset($_POST["submit"]))
    {
        //button clicked

        // 1. Get data from form
        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        
        // 2. Sql query to get data from database
        $sql = "SELECT * FROM tbl_admin WHERE
            username = '$username' AND
            password = '$password';
            ";

        // 3. execute data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. check whether data is selected
        if($res == TRUE){
            $count = mysqli_num_rows($res);
            
            if($count>=1){
                header("location:".SITEURL."admin/index.php");
                $_SESSION["login"] = "<div class ='success'>Successfully logged in</div>";
                $_SESSION["user"] = $username; //to check whether logged in
            }
            else{
                header("location:".SITEURL."admin/login.php");
                $_SESSION["login"] = "<div class ='error'>Log in Failed</div>";
            }
        }
        else{
            header("location:".SITEURL."admin/login.php");
            $_SESSION["login"] = "<div class ='error'>Log in Failed</div>";
        }
    }
?>
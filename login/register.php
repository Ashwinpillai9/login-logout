<?php
//Made by Ashwin Pillai 
//Enrollment No. - A80105219015
require_once "config.php";

$username = $password = $confirm_password ="";
$username_err = $password_err = $confirm_password_err ="";

if($_SERVER['REQUEST_METHOD']=='POST'){
    //Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username=?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($srmt)
        {
            mysqli_stmt_bind_param($stmt,"s", $param_username);

            //set the value of param username
            $param_username = trim($_POST['username']);

            //try to execute this statement\
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt)==1)
                {
                    $username_err = "This username is already taken";
                }
                else
                {
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        } 

    }
    mysqli_stmt_close($stmt);


    //Check for password
    if(empty(trim($_POST["password"]))){
        $password_err = "Password cannot be blank";
    }
    elseif(strlen(trim($_POST['password']))<5){
        $password_err = "Password cannot be less than 5 charecter";
    }
    else{
        $password = trim($_POST['password']);
    }

    //Check for confirm password field
    if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
        $password_err = "Passwords should match";
    }

    //if there were no errors, go ahead into the database 
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
    {
        $sql = "INSERT INTO users(username,password) VALUES(?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            //set parameters
            $param_username = $username;
            $param_password = password_hash($password,PASSWORD_DEFAULT);

            //TRY TO EXECUTE THE QUERY
            if(mysqli_stmt_execute($stmt))
            {
                header("location: login.php");
            }
            else{
                echo "Something went wrong ...cannot redirect!";
            }
        }
        mysqli_stmt_close($srmt);
    }
    mysqli_stmt_close($conn);

}
?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>PHP Login System</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="login.php">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
    <h2>Please Register Here</h2>
    <hr>
        <form action="" method ="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputEmail4">Username</label>
                <input type="text" name="username" class="form-control" id="inputEmail4">
                </div>
                <div class="form-group col-md-6">
                <label for="inputPassword4">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword4">
                </div>
            </div>
            <div class="form-group ">
                <label for="inputPassword4">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" id="inputPassword">
            </div>

            <button type="submit" class="btn btn-primary">Sign in</button>
            <div class="border-top pt-3">
     		<small class="text-muted">
     		Already Have An Account? <a class="ml-2" href="login.php">Log In</a>
     	</small>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>
<?php
include("sign-connection.php");

if(isset($_POST['signup'])){
   
    
    $username = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $pass = mysqli_real_escape_string($db, $_POST['password']);
    $pass2 = mysqli_real_escape_string($db, $_POST['confirm-Password']);
    
    if(empty($username)){
        array_push($error, "username is required");
    }
    if(empty($email)){
        array_push($error, "Email is required");
    }
    if(empty($pass)){
        array_push($error, "password is required");
    }
    if($pass2 != $pass){ 
        array_push($error, "passwords do not match");
    }
    
   
    $check_email = "SELECT * FROM signup WHERE email='$email' LIMIT 1";
    $result = mysqli_query($db, $check_email);
    if (mysqli_num_rows($result) > 0) {
        array_push($error, "Email already exists");
    }
    
    if(count($error) == 0){
       
        $sql = "INSERT INTO signup (name, email, password) VALUES ('$username', '$email', '$pass')";
        if (mysqli_query($db, $sql)) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Registration successful";
            header('location: login.php');
            exit();
        } else {
            array_push($error, "Database error: " . mysqli_error($db));
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>

    <!-- link google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Signika+Negative:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- link font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>

    <!-- navbar -->

    <nav class="navbar">

        <div class="logo">
            <img src="img/kemet logo.jpg" alt="logo">
            <h1>
                Kemet
            </h1>
        </div>

        <div class="list">
            <ul>
                <a href="home page.html">
                    <li>
                        Home
                    </li>
                </a>
                <a href="home page.html #categories">
                    <li>
                        Categories
                    </li>
                </a>
                <a href="about_us.html">
                    <li>
                        About
                    </li>
                </a>
                <a href="contact.html">
                    <li>
                        Contact Us
                    </li>
                </a>
                <a href="#">
                    <li>
                        <i class="fa-solid fa-heart"></i>
                    </li>
                </a>
                <a href="#">
                    <li>
                        <i class="fa-solid fa-cart-shopping"></i>
                    </li>
                </a>

            </ul>
        </div>
    </nav>


    <!-- end navbar -->

    <div class="main">
        <div class="sign">
            <h1>Sign Up</h1>

            <form class="form" method="post">
                <label for="name">Name</label><br>
                <input type="text" id="name" name="name" required>
                <br>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" required>
                <br>
                <label for="password">Password</label>
                <br>
                <input type="password" id="password" name="password" required>      
                <br>
                <label for="confirm"> Confirm Password</label>
                <br>
                <input type="password" id="confirm" name="confirm-Password" required>
                <br>
                <input type="submit" value="Signup" id="submit" name="signup">
            </form>

            <div class="x">
                <p>Already have an account ? <a href="login.php">log in</a> </p>
            </div>
        </div>
    </div>

</body>

</html>
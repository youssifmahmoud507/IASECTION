<?php include("sign-connection.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Signika+Negative:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>

    <nav class="navbar">

        <div class="logo">
            <img src="img/kemet logo.jpg" alt="logo">
            <h1>
                Kemet
            </h1>
        </div>

        <div class="list">
            <ul>
                <li>
                    <a href="home page.html">Home</a>
                </li>

                <li>
                    <a href="categories page.html">Categories</a>
                </li>
                
                <li>
                    <a href="about_us.html">About</a>
                </li>
                
                <li>
                    <a href="contact.html">Contact Us</a>
                </li>
 
  
                <li>
                    <a href="#"><i class="fa-solid fa-heart"></i></a> 
                </li>

                <li>
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a> 
                </li>

            </ul>
        </div>
    </nav>


    <div class="main" >


        <div class="sign">
            <h1>Login</h1>

            <form method='post' action='home page.html' class="form">
                <div >
            <div>
                <label for="email">Email</label>
                <br>
                <input type="email" id="email" name="em" required>
            </div>
            
            <div>
                <label for="pass">Password</label>
                <br>
                <input type="password" id="pass" name="pas" required>
                <br>
            </div>

                <input type="submit" value="Login" name='register'>
                </div>
            </form>

            <div class="x">
                <p>Don't have an account ? <a href="signup.php" target="_blank">Sign up</a> </p>

            </div>
        </div>

    </div>

</body>

</html>
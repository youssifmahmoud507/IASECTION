<?php
if (!isset($_SESSION)) {
    session_start();
}

$errors = array();
$success_msg = "";

// Connect to database
$db = mysqli_connect('localhost', 'root', '', 'proudct');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// If the user clicks the send button
if (isset($_POST['submit'])) {
    // Get form data
    $full_name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $message = mysqli_real_escape_string($db, $_POST['message']);

    // Validate inputs
    if (empty($full_name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { /*// FILTER_VALIDATE_EMAIL دي يسطا فاليديت ده ايميل ولا لا //*/
        $errors[] = "Invalid email format";
    }

    if (empty($message)) {
        $errors[] = "Message is required";
    }

    // If no errors, insert into database
    if (count($errors) == 0) {
        $query = "INSERT INTO contact_messages (full_name, email, message, created_at) VALUES ('$full_name', '$email', '$message', NOW())";

        if (mysqli_query($db, $query)) {
            $success_msg = "Your message has been sent successfully!";
            // Clear form data after successful submission
            $_POST = array();
        } else {
            $errors[] = "Error: " . mysqli_error($db);
        }
    }
}

/* basel bos 


    full_name 3ady user name
    email bardo eshta
    message tamam
    بالنسبة ل NOW()
    دي يسطا بص دي بتريترن وقت الماسدج اتبعت اامتى
    عشان تكون فاهم
    فا سيبها



*/  





?>




















<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- link google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Signika+Negative:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">


    <!-- link font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />

    <link rel="stylesheet" href="css/contact.css">
</head>

<body>

    <nav class="navbar">

        <div class="logo">
            <img src="./img/kemet logo.jpg" alt="logo">
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
                <a href="login.html">
                    <li>
                        Login
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
    <div class="contact-container">
        <div class="image-section">
            <img src="./img/WhatsApp Image 2024-12-13 at 12.28.27 PM.jpeg" alt="Two models">
        </div>
        <div class="form-section">
            <h1>Contact Us</h1>
            <form action="#" method="post">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name">

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Your Email">

                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Your Message"></textarea>

                <button type="submit">Contact Us</button>
            </form>
            <div class="contact-info">
                <p><strong>Contact:</strong> kemeteg@gmail.com</p>
                <p><strong>Based in:</strong> Egypt, Cairo</p>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer class="site-footer">


        <div class="cont">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="copyright-text">Copyright &copy; 2024 All Rights Reserved by Kemet
                    </p>
                </div>

                <hr style="color: #eee3c3;" />

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <ul class="social-icons">
                        <li><a class="facebook" href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a class="twitter" href="https://x.com/?lang=en"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a class="instagram" href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a class="linkedin" href="https://www.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
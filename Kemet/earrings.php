<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earrings</title>
    <!-- link google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Signika+Negative:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">


    <!-- link font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />

    <link rel="stylesheet" href="./css/earrings.css">

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
                <a href="index.php">
                    <li>
                        Home
                    </li>
                </a>
                <a href="index.php #categories">
                    <li>
                        Categories
                    </li>
                </a>
                <a href="about_us.php">
                    <li>
                        About
                    </li>
                </a>
                <a href="contact.php">
                    <li>
                        Contact Us
                    </li>
                </a>
                <a href="login.php">
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


    <h1>
        Earrings
    </h1>

    <?php
    
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "proudct"; 

$conn = new mysqli($servername, $username, $password, $dbname);
// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// استعلام للحصول على المنتجات من قاعدة البيانات
$sql = "SELECT id, name, Price, Img FROM product WHERE category_id ='9' ORDER BY Price DESC";
$result = $conn->query($sql);

echo '<div class="card-holder">';

if ($result->num_rows > 0) {
    // إخراج بيانات كل صف
    while($row = $result->fetch_assoc()) {
        // للصورة blob، ترميز كـ base64
        $imgSrc = "";
        if ($row["Img"] !== null) {
            $imgData = base64_encode($row["Img"]);
            $imgSrc = "data:image/jpeg;base64," . $imgData;
        } else {
            $imgSrc = "img/default.jpg"; // صورة افتراضي لو كانت فاضيه انا مكسل احطها 
        }
        
        // عرض بطاقة المنتج بتنسيق card
        echo '<div class="card">';
        echo '<img src="' . $imgSrc . '" alt="' . htmlspecialchars($row["name"]) . '">';
        echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
        echo '<h4>' . $row["Price"] . '$</h4>';
        echo '<div class="buttons">';
        echo '<a href="buy.php?id=' . $row["id"] . '"><button class="buy">Buy Now</button></a>';
        echo '<a href="cart.php?action=add&id=' . $row["id"] . '"><button class="add">Add To Cart</button></a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "لا توجد منتجات";
}

echo '</div>'; // إغلاق card-holder

// إغلاق الاتصال
$conn->close();
?>
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kemet</title>

    <!-- link google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Signika+Negative:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- link font awesome icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
      integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <!-- link css file -->
    <link rel="stylesheet" href="css/home page.css" />
  </head>

  <body>
    <!-- navbar -->

    <nav class="navbar">
      <div class="logo">
        <img src="img/kemet logo.jpg" alt="logo" />
        <h1>Kemet</h1>
      </div>

      <div class="list">
        <ul>
          <a href="home page.html" target="_blank">
            <li>Home</li>
          </a>
          <a href="#categories">
            <li>Categories</li>
          </a>
          <a href="about_us.html" target="_blank">
            <li>About</li>
          </a>
          <a href="contact.html" target="_blank">
            <li>Contact Us</li>
          </a>
          <a href="login.html" target="_blank">
            <li>Login</li>
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

    <!-- landing section -->

    <section class="landing">
      <div class="text">
        <h1>Welcome To Kemet</h1>
        <h2>"From the land of gold and sand, elegance crafted by hand."</h2>
      </div>
    </section>

    <!-- end landing section -->

    <!-- second section -->

    <section class="second">
      <div class="card1">
        <p>
          Embrace the timeless beauty of ancient Egypt with our exclusive
          pharaonic accessories.
        </p>
      </div>

      <div class="card2">
        <p>Discover the artistry of the pharaohs—crafted for the modern era.</p>
      </div>

      <div class="card3">
        <p>
          Where history meets elegance—shop authentic Egyptian-inspired jewelry.
        </p>
      </div>
    </section>

    <!-- end second section -->

    <!-- third section -->

    <section class="third" id="categories">
      <div class="title">
        <h1>Our Categories</h1>
      </div>

      <div class="cat-cards">
        <a href="bracelet.html">
          <div class="card">
            <img src="img/bracelete icon.png" alt="Bracelete" />
            <h2>Bracelet</h2>
          </div>
        </a>

        <a href="earrings.html">
          <div class="card">
            <img src="img/earrings icon.png" alt="Earrings" />
            <h2>Earrings</h2>
          </div>
        </a>

        <a href="necklace.html">
          <div class="card">
            <img src="img/necklace icon.png" alt="Necklace" />
            <h2>Necklace</h2>
          </div>
        </a>

        <a href="rings&sets.html">
          <div class="card">
            <img src="img/ring icon.png" alt="Rings" />
            <h2>Rings & Sets</h2>
          </div>
        </a>
      </div>
    </section>

    <!-- end third section -->

    <!-- Forth section -->

    <section class="forth">
      <div class="title">
        <h1>Best Selling</h1>
      </div>

      <div class="cards-holder">
        


      <?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "proudct"; // قاعدة البيانات

$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تعيين ترميز الاتصال للتعامل مع اللغة العربية
$conn->set_charset("utf8mb4");

// استعلام للحصول على المنتجات من قاعدة البيانات
$sql = "SELECT id, name, Price, Img FROM product ORDER BY Price DESC"; // تم تغيير proudct إلى product
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // إخراج بيانات كل صف
    while($row = $result->fetch_assoc()) {
        // للصورة blob، ترميز كـ base64
        $imgSrc = "";
        if ($row["Img"] !== null) {
            $imgData = base64_encode($row["Img"]);
            $imgSrc = "data:image/jpeg;base64," . $imgData;
        } else {
            $imgSrc = "img/default.jpg"; // صورة افتراضية إذا كانت فارغة
        }
        
        // عرض بطاقة المنتج
        echo '<div class="p-card">';
        echo '<img src="' . $imgSrc . '" alt="' . htmlspecialchars($row["name"]) . '" style="height: 250px; width: 100%">';
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

// إغلاق الاتصال
$conn->close();
?>

    <!-- footer -->
    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="footer">
            <p class="copyright-text">
              Copyright &copy; 2024 All Rights Reserved by Kemet
            </p>
          </div>

          <hr style="color: #eee3c3" />

          <div class="footer">
            <ul class="social-icons">
              <li>
                <a
                  class="facebook"
                  href="https://www.facebook.com/"
                  target="_blank"
                  ><i class="fa-brands fa-facebook"></i
                ></a>
              </li>
              <li>
                <a class="twitter" href="https://x.com/?lang=en"
                  ><i class="fa-brands fa-x-twitter"></i
                ></a>
              </li>
              <li>
                <a class="instagram" href="https://www.instagram.com/"
                  ><i class="fa-brands fa-instagram"></i
                ></a>
              </li>
              <li>
                <a class="linkedin" href="https://www.linkedin.com/"
                  ><i class="fa-brands fa-linkedin"></i
                ></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>

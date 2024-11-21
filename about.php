<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- About section start -->
   <section class="about">
        <div class="row">

            <div class="image">
                <img src="./images/about-img.svg" alt="">
            </div>

            <div class="content">
                <h3>why choose us?</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore deleniti quibusdam,
                     aliquam autem suscipit amet sapiente sit culpa doloribus odio consectetur sint optio fuga? 
                     Tenetur at fuga vero possimus maiores?
                </p>

                <a href="courses.php" class="inline-btn">our course</a>
            </div>

        </div>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-graduation-cap"></i>
                <div>
                    <h3>+1k</h3>
                    <span>online courses</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-user-graduate"></i>
                <div>
                    <h3>+25k</h3>
                    <span>brilliants students</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-chalkboard-user"></i>
                <div>
                    <h3>+5k</h3>
                    <span>expert teachers</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-briefcase"></i>
                <div>
                    <h3>100%</h3>
                    <span>job placement</span>
                </div>
            </div>

        </div>
   </section>
  <!-- About section end -->

  <!-- Review section starts -->
   <section class="reviews">

        <h1 class="heading">student's reviews</h1>

        <div class="box-container">

            <div class="box">
                <div class="user">
                    <img src="./images/pic-1.jpg" alt="">
                    <div>
                        <h3>Danh</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolore laborum, qui sit cumque non recusandae quisquam quidem vitae explicabo maxime?</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="./images/pic-3.jpg" alt="">
                    <div>
                        <h3>Phúc</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolore laborum, qui sit cumque non recusandae quisquam quidem vitae explicabo maxime?</p>
            </div>

            <div class="box">
                <div class="user">
                    <img src="./images/pic-6.jpg" alt="">
                    <div>
                        <h3>Bảo</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolore laborum, qui sit cumque non recusandae quisquam quidem vitae explicabo maxime?</p>
            </div>

        </div>
   </section>
  <!-- Review section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>
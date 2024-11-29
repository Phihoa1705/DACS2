<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
  }

  $count_likes = getDatabaseConnection()->prepare("SELECT * FROM likes WHERE user_id = ?"); 
  $count_likes->execute([$user_id]);
  $total_likes = $count_likes->rowCount();

  $count_comments = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE user_id = ?"); 
  $count_comments->execute([$user_id]);
  $total_comments = $count_comments->rowCount();

  $count_bookmark = getDatabaseConnection()->prepare("SELECT * FROM bookmark WHERE user_id = ?"); 
  $count_bookmark->execute([$user_id]);
  $total_bookmark = $count_bookmark->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- Quick select section starts -->
   <section class="quick-select">
    
    <h1 class="heading">quick options</h1>

    <div class="box-container">
      <?php
        if($user_id != '') {
      ?>
        <div class="box">
          <h3 class="title">likes and comments</h3>
          <p>total likes: <span><?php echo $total_likes; ?></span></p>
          <a href="likes.php" class="inline-btn">views likes</a>
          <p>total comments: <span><?php echo $total_comments; ?></span></p>
          <a href="comment.php" class="inline-btn">views comments</a>
          <p>playlist saved: <span><?php echo $total_bookmark; ?></span></p>
          <a href="bookmark.php" class="inline-btn">views bookmark</a>
        </div>
      <?php } else {?>
        <div class="box" style="text-align: center;">
          <h3 class="title">login or register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
          </div>
        </div>
      <?php } ?>

      <div class="box">
        <h3 class="title">top categories</h3>
        <div class="flex">
          <a href="#"><i class="fas fa-code"></i><span>development</span></a>
          <a href="#"><i class="fas fa-chart-simple"></i><span>business</span></a>
          <a href="#"><i class="fas fa-pen"></i><span>design</span></a>
          <a href="#"><i class="fas fa-chart-line"></i><span>marketing</span></a>
          <a href="#"><i class="fas fa-music"></i><span>music</span></a>
          <a href="#"><i class="fas fa-camera"></i><span>photography</span></a>
          <a href="#"><i class="fas fa-cog"></i><span>software</span></a>
          <a href="#"><i class="fas fa-vial"></i><span>science</span></a>
        </div>
      </div>

      <div class="box">
        <h3 class="title">popular topics</h3>
        <div class="flex">
          <a href="#"><i class="fa-brands fa-html5"></i><span>HTML</span></a>
          <a href="#"><i class="fa-brands fa-css3"></i><span>CSS</span></a>
          <a href="#"><i class="fa-brands fa-js"></i><span>JavaScript</span></a>
          <a href="#"><i class="fa-brands fa-react"></i><span>React</span></a>
          <a href="#"><i class="fa-brands fa-php"></i><span>PHP</span></a>
          <a href="#"><i class="fa-brands fa-bootstrap"></i><span>Bootstrap</span></a>
        </div>
      </div>

      <div class="box tutor" >
        <h3  class="title">become a tutor</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit, aperiam.</p>
        <a href="./php/admin/register.php" class="inline-btn">get started</a>
      </div>
    </div>

   </section>
  <!-- Quick select section end -->

  <!-- courses section starts -->
   <section class="course">
    <h1 class="heading">latest courses</h1>
    <div class="box-container">
      <?php
        $select_courses = getDatabaseConnection()->prepare("SELECT * FROM playlist WHERE status = ? 
        ORDER BY creation_date DESC LIMIT 6");
        $select_courses->execute(['active']);

        if($select_courses->rowCount() > 0) {
          while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
            $course_id = $fetch_course['playlist_id'];

            $count_course = getDatabaseConnection()->prepare('SELECT * FROM content WHERE playlist_id = ? AND status = ?');
            $count_course->execute([$course_id, 'active']);
            $total_course = $count_course->rowCount();

            $select_tutor = getDatabaseConnection()->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
            $select_tutor->execute([$fetch_course['tutor_id']]);
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
            // echo $course_id;
      ?>
      <div class="box">
          <div class="tutor">
            <img src="./php/uploaded_files/<?php echo $fetch_tutor['image']; ?>" alt="">
            <div>
              <h3><?php echo $fetch_tutor['tutor_name']; ?></h3>
              <span><?php echo $fetch_course['creation_date']; ?></span>
            </div>
          </div>
          <div class="thumb">
            <span><?php echo $total_course;?></span>
            <img src="./php/uploaded_files/<?php echo $fetch_course['thumb'];?>" alt="">
          </div>
          <h3 class="title"><?php echo $fetch_course['title'];?></h3>
          <a href="playlist.php?get_id=<?php echo $course_id; ?>" class="inline-btn">view playlist</a>
      </div>
      <?php
          }
        } else {
          echo '<p class="emtpy">no courses added yet!</p>';
        }
      ?>
    </div>
    <div style="margin-top: 2rem; text-align: center;">
      <a href="courses.php" class="inline-option-btn">view all</a>
    </div>
   </section>
  <!-- courses section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>
<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
  }

  if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
  } else {
    $tget_id = '';
    header('location:teachers.php');
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tutor Profile</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- Tutor profile section starts -->

  <section class="tutor-profile">

    <h1 class="heading">tutor profile</h1>

    <?php
        $select_tutors = getDatabaseConnection()->prepare("SELECT * FROM `tutors` WHERE email = ? LIMIT 1");
        $select_tutors->execute([$get_id]);
        if($select_tutors->rowCount() > 0){
            while($fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC)){

              $tutor_id = $fetch_tutor['tutor_id'];

              $count_playlist = getDatabaseConnection()->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
              $count_playlist->execute([$tutor_id]);
              $total_playlist = $count_playlist->rowCount();

              $count_content = getDatabaseConnection()->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
              $count_content->execute([$tutor_id]);
              $total_content = $count_content->rowCount();

              $count_likes = getDatabaseConnection()->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
              $count_likes->execute([$tutor_id]);
              $total_likes = $count_likes->rowCount();

              $count_comments = getDatabaseConnection()->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
              $count_comments->execute([$tutor_id]);
              $total_comments = $count_comments->rowCount();
          ?>

    <div class="details">
      <div class="tutor">
        <img src="php/uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
        <h3 class="name"><?= $fetch_tutor['tutor_name']; ?></h3>
        <span class="profession"><?= $fetch_tutor['profession']; ?></span>
        <p class="email"><?= $fetch_tutor['email']; ?></p>
      </div>
      <div class="box-container">
        <p>total playlists : <span><?= $total_playlist; ?></span></p>
        <p>total contents : <span><?= $total_content; ?></span></p>
        <p>total comments : <span><?= $total_comments; ?></span></p>
        <p>total likes : <span><?= $total_likes; ?></span></p>
      </div>
    </div>

    <?php
            }
          }else{
            echo '<p class="empty">no tutors was found</p>';
          }
        ?>

  </section>

  <!-- Tutor profile section ends -->

  <!-- courses section starts -->
<section class="course">
    <h1 class="heading">tutor's courses</h1>
    <div class="box-container">
      <?php
        $select_tutor_email = getDatabaseConnection()->prepare("SELECT * FROM `tutors` WHERE email = ? LIMIT 1");
        $select_tutor_email->execute([$get_id]);
        $fetch_tutor_id = $select_tutor_email->fetch(PDO::FETCH_ASSOC);
        $select_courses = getDatabaseConnection()->prepare("SELECT * FROM playlist WHERE tutor_id = ? AND status = ? 
        ORDER BY creation_date DESC");
        $select_courses->execute([ $fetch_tutor_id['tutor_id'] ,'active']);

        if($select_courses->rowCount() > 0) {
          while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
            $course_id = $fetch_course['playlist_id'];

            $count_course = getDatabaseConnection()->prepare('SELECT * FROM content WHERE playlist_id = ?');
            $count_course->execute([$course_id]);
            $total_course = $count_course->rowCount();

            $select_tutor = getDatabaseConnection()->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
            $select_tutor->execute([$fetch_course['tutor_id']]);
            $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
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
</section>
  <!-- courses section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>
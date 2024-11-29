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
  <title>Tearchers</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- Teachers section start -->
    <section class="teachers">
      <h1 class="heading">expert tutors</h1>

      <form action="sreach_tutor.php" method="POST" class="tutor-search">
        <input type="text" name="search_tutor_box" placeholder="search tutor" maxlength="100" required>
        <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
      </form>

      <div class="box-container">

        <div class="box offer">
          <h3>become a tutor</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore quae inventore reiciendis impedit saepe esse, nihil, architecto eius ab perspiciatis voluptatibus doloribus recusandae nostrum deserunt voluptas commodi quidem? Exercitationem, quam!</p>
          <a href="./php/admin/register.php" class="inline-btn">get started</a>
        </div>

        <?php
        $select_tutors = getDatabaseConnection()->prepare("SELECT * FROM `tutors`");
        $select_tutors->execute();
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
          <div class="box">
            <div class="tutor">
              <img src="php/uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
              <div>
                <h3><?= $fetch_tutor['tutor_name']; ?></h3>
                <span><?= $fetch_tutor['profession']; ?></span>
              </div>
            </div>
            <p>total videos : <span><?= $total_content; ?></span></p>
            <p>total courses : <span><?= $total_playlist; ?></span></p>
            <p>total likes : <span><?= $total_likes; ?></span></p>
            <p>total comments : <span><?= $total_comments; ?></span></p>
            <a href="tuor_profile.php?get_id=<?= $fetch_tutor['email'] ?>" class="inline-btn">view profile</a>
          </div>
          
          <?php
            }
          }else{
            echo '<p class="empty">no tutors was found</p>';
          }
        ?>
      </div>
    </section>

  <!-- Teachers section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>
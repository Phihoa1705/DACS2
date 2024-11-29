<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
    header('location: home.php');
  }

  if(isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_like = getDatabaseConnection()->prepare("SELECT * FROM likes WHERE user_id = ? AND content_id = ?");
    $verify_like->execute([$user_id,$delete_id]);
    
    if($verify_like->rowCount() > 0){
      $remove_like = getDatabaseConnection()->prepare("DELETE FROM likes WHERE user_id = ? AND content_id = ?");
      $remove_like->execute([$user_id,$delete_id]);
      $message[] = 'like removed!';
    } else {
      $message[] = 'already removed from likes!';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Likes</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- courses section starts -->
<section class="course">
  <h1 class="heading">Like Video</h1>
  <div class="box-container">
    <?php
        $select_likes = getDatabaseConnection()->prepare("SELECT * FROM likes WHERE user_id = ?");
        $select_likes->execute([$user_id]);
        if($select_likes->rowCount() > 0) {
          while($fetch_likes = $select_likes->fetch(PDO::FETCH_ASSOC)) {
            $select_courses = getDatabaseConnection()->prepare("SELECT * FROM content WHERE content_id = ? AND status = ? 
            ORDER BY creation_date DESC");
            $select_courses->execute([$fetch_likes['content_id'],'active']);

            if($select_courses->rowCount() > 0) {
              while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                $course_id = $fetch_course['content_id'];

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
          <img src="./php/uploaded_files/<?php echo $fetch_course['thumb'];?>" alt="">
        </div>
        <h3 class="title"><?php echo $fetch_course['title'];?></h3>
        <form action="" method="post" class="flex-btn">
          <input type="hidden" name="delete_id" value="<?php echo $fetch_likes['content_id']; ?>">
          <a href="watch-video.php?get_id=<?php echo $course_id; ?>" class="inline-btn">view video</a>
          <input type="submit" value="remove" class="inline-delete-btn" name="delete">
        </form>
    </div>
    <?php
            }
          } else {
            echo '<p class="emtpy">no courses added yet!</p>';
          }
        }
      } else {
        echo '<p class="empty">nothing added to likes yet!</p>';
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
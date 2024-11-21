<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
  }

  if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location: courses.php');
}

if(isset($_POST['like_content'])){

  if($user_id != '') {
    $like_id = $_POST['content_id'];
    $like_id = filter_var($like_id, FILTER_SANITIZE_STRING);

    $get_content = $conn->prepare("SELECT * FROM content WHERE content_id = ? LIMIT 1");
    $get_content->execute([$like_id]);

    $fetch_get_content = $get_content->fetch(PDO::FETCH_ASSOC);

    $tutor_id = $fetch_get_content['tutor_id'];

    $verify_like = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND content_id = ?");

    $verify_like->execute([$user_id, $like_id]);
    
    if($verify_like->rowCount() > 0){
      $remove_like = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND content_id = ?");
      $remove_like->execute([$user_id, $like_id]);
      $message[] = 'like removed!';
    } else {
      $add_like = $conn->prepare("INSERT INTO likes(user_id, content_id, tutor_id) VALUES(?, ?, ?)");
      $add_like->execute([$user_id, $like_id, $tutor_id]);
      $message[] = 'like added!';
    }
  } else {
     $message[] = 'please login first!';
  }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Watch Video</title>

  <!-- font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <!-- Header section start -->
   <?php require_once './php/components/user_header.php'; ?>
  <!-- Header section end -->

  <!-- watch video section starts -->
   <section class="watch-video">
    <?php
      $select_content = $conn->prepare("SELECT * FROM content WHERE content_id = ? AND status = ?");
      $select_content->execute([$get_id, 'active']);
      if($select_content->rowCount() > 0) {
        while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
          $content_id = $fetch_content['content_id'];

          $select_likes = $conn->prepare("SELECT * FROM likes WHERE content_id = ?");
          $select_likes->execute([$content_id]);
          $total_likes = $select_likes->rowCount();

          $user_likes = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND content_id = ?");
          $user_likes->execute([$user_id, $content_id]);

          $select_tutor = $conn->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
          $select_tutor->execute([$fetch_content['tutor_id']]);
          $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="content">
      <video src="./php/uploaded_files/<?php echo $fetch_content['video']; ?>" controls 
      autoplay poster="./php/uploaded_files/<?php echo $fetch_content['thumb']; ?>" class="video"></video>
      <h3 class="title"><?php echo $fetch_content['title']; ?></h3>
      <div class="info">
        <p><i class="fas fa-calendar"></i><span><?php echo $fetch_content['creation_date']; ?></span></p>
        <p><i class="fas fa-heart"></i><span><?php echo $total_likes; ?></span></p>
      </div>
      <div class="tutor">
        <img src="./php/uploaded_files/<?php echo $fetch_tutor['image']; ?>" alt="">
        <div>
          <h3><?php echo $fetch_tutor['tutor_name']; ?></h3>
          <span><?php echo $fetch_tutor['profession']; ?></span>
        </div>
      </div>
      <form action="" method="post" class="flex">
        <input type="hidden" name=" content_id" value="<?php echo $content_id?>">
        <a href="playlist.php?get_id=<?php echo $fetch_content['playlist_id']; ?>" class="inline-btn">view playlist</a>
        <?php if($user_likes->rowCount() > 0) { ?>
          <button type="submit" class="inline-btn" name="like_content"><i class="fas fa-heart"></i><span>liked</span></button>
        <?php } else { ?>
          <button type="submit" class="inline-option-btn" name="like_content"><i class="far fa-heart"></i><span>like</span></button>
        <?php } ?>
      </form>
      <p class="description">
        <?php echo $fetch_content['description']; ?>
      </p>
    </div>
    <?php
        }
      } else{
        echo '<p class="empty">no content was found!</p>';
      }
    ?>
   </section>
  <!-- watch video section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>
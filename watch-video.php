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

    $get_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE content_id = ? LIMIT 1");
    $get_content->execute([$like_id]);

    $fetch_get_content = $get_content->fetch(PDO::FETCH_ASSOC);

    $tutor_id = $fetch_get_content['tutor_id'];

    $verify_like = getDatabaseConnection()->prepare("SELECT * FROM likes WHERE user_id = ? AND content_id = ?");

    $verify_like->execute([$user_id, $like_id]);
    
    if($verify_like->rowCount() > 0){
      $remove_like = getDatabaseConnection()->prepare("DELETE FROM likes WHERE user_id = ? AND content_id = ?");
      $remove_like->execute([$user_id, $like_id]);
      $message[] = 'like removed!';
    } else {
      $add_like = getDatabaseConnection()->prepare("INSERT INTO likes(user_id, content_id, tutor_id) VALUES(?, ?, ?)");
      $add_like->execute([$user_id, $like_id, $tutor_id]);
      $message[] = 'like added!';
    }
  } else {
     $message[] = 'please login first!';
  }


}
if(isset($_POST['add_comment'])) {
  if($user_id == '') {
    $message[] = 'please login first!';
  } else {
    $comment_id = uniqid();
    $comment_box = $_POST['comment_box'];
    $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);

    $select_content_tutor = getDatabaseConnection()->prepare("SELECT * FROM content WHERE content_id = ?");
    $select_content_tutor->execute([$get_id]);
    $fetch_content_tutor_id = $select_content_tutor->fetch(PDO::FETCH_ASSOC);
    $content_tutor_id = $fetch_content_tutor_id['tutor_id'];

    $verify_comment = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE content_id = ? AND user_id = ? 
    AND tutor_id = ? AND comment = ?");
    $verify_comment->execute([$get_id, $user_id, $content_tutor_id, $comment_box]);

    if($verify_comment->rowCount() > 0) {
      $message[] = 'comment already added!'; 
    } else {
      $add_comment = getDatabaseConnection()->prepare("INSERT INTO comments(comment_id,content_id,user_id, tutor_id, comment)
      VALUES(?,?, ?, ?, ?)");
      $add_comment->execute([$comment_id,$get_id,$user_id, $content_tutor_id, $comment_box]);

      $message[] = 'comment added successfully!';
    }
  }
} 
if(isset($_POST['delete_comment'])){
  $delete_id = $_POST['comment_id'];
  $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING); 

  $verify_comment = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE comment_id = ?");
  $verify_comment->execute([$delete_id]);

  if($verify_comment->rowCount() > 0){
     $delete_comment = getDatabaseConnection()->prepare("DELETE FROM comments WHERE comment_id = ?");
     $delete_comment->execute([$delete_id]);
     $message[] = 'comment deleted successfully';
     header('location:comments.php');
  } else {
     $message[] = 'comment already deleted';
  }
}

if(isset($_POST['edit_comment'])) {
  $edit_id = $_POST['edit_id'];
  $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);

  $comment_box = $_POST['comment_box'];
  $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);

  $verify_edit_comment = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE comment_id = ? AND comment = ?");
  $verify_edit_comment->execute([$edit_id, $comment_box]);

  if($verify_edit_comment->rowCount() > 0) {
    $message[] = 'comment already added!';
  } else {
    $update_comment = getDatabaseConnection()->prepare("UPDATE comments SET comment = ? WHERE comment_id = ?");
    $update_comment->execute([$comment_box, $edit_id]);
    $message[] = 'comment updated successfully!';
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
  <?php
    if(isset($_POST['update_comment'])) {
      $update_id = $_POST['comment_id'];
      $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
      $select_update_comment = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE comment_id = ? LIMIT 1");

      $select_update_comment->execute([$update_id]);
      $fetch_update_comment = $select_update_comment->fetch(PDO::FETCH_ASSOC);
  ?>
  <section class="comment-form">
    <h1 class="heading">update comments</h1>

    <form action="" method="post">
      <input type="hidden" name="edit_id" value="<?php echo $fetch_update_comment['comment_id']; ?>">
      <textarea name="comment_box" class="box" rows="10" cols="30" require 
        maxlength="1000" placeholder="enter your comment"><?php echo $fetch_update_comment['comment']; ?></textarea>
      
      <div class="flex-btn">
        <a href="watch-video.php?get_id=<?php echo $get_id; ?>" class="inline-option-btn">cancel edit</a>  
        <input type="submit" value="edit comment" name="edit_comment" class="inline-btn">
      </div>

    </form>

  </section>
  <?php
    }
  ?>
  <!-- watch video section starts -->
   <section class="watch-video">
    <?php
      $select_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE content_id = ? AND status = ?");
      $select_content->execute([$get_id, 'active']);
      if($select_content->rowCount() > 0) {
        while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
          $content_id = $fetch_content['content_id'];

          $select_likes = getDatabaseConnection()->prepare("SELECT * FROM likes WHERE content_id = ?");
          $select_likes->execute([$content_id]);
          $total_likes = $select_likes->rowCount();

          $user_likes = getDatabaseConnection()->prepare("SELECT * FROM likes WHERE user_id = ? AND content_id = ?");
          $user_likes->execute([$user_id, $content_id]);

          $select_tutor = getDatabaseConnection()->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
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
  
  <section class="comment-form">
    <h1 class="heading">add comments</h1>
    <form action="" method="post">
      <textarea name="comment_box" class="box" rows="10" cols="30" require 
      maxlength="1000" placeholder="enter your comment"></textarea>
      <input type="submit" value="add comment" name="add_comment" class="inline-btn">
    </form>
  </section>

  <!-- Comments section start -->
  <section class="comments">
         <h1 class="heading">User comments</h1>
         
         <div class="box-container">
            <?php
               $select_comments = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE content_id = ?");
               $select_comments->execute([$get_id]);
               if($select_comments->rowCount() > 0) {
                  while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                     $comment_id = $fetch_comment['comment_id'];
                     $select_commentor = getDatabaseConnection()->prepare("SELECT * FROM users WHERE user_id = ?");
                     $select_commentor->execute([$fetch_comment['user_id']]);
                     $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="box" <?php if($fetch_comment['user_id'] == $user_id) {
                  echo 'style:"order: 1-;"';
                } ?>>
               <div class="user">
                  <img src="./php/uploaded_files/<?php echo $fetch_commentor['image'];?>" alt="">
                  <div>
                     <h3><?php echo $fetch_commentor['name'];?></h3>
                     <span><?php echo $fetch_comment['creation_date'];?></span>
                  </div>
               </div>
               <p class="comment-box"><?php echo $fetch_comment['comment'];?></p>
               <?php 
                if($fetch_comment['user_id'] == $user_id) {
               ?>
               <form action="" method="post">
                  <input type="hidden" name="comment_id" value="<?php echo $fetch_comment['comment_id'];?>">
                  <input type="submit" value="update comment" name="update_comment" class="inline-option-btn">
                  <input type="submit" value="delete comment" name="delete_comment" class="inline-delete-btn"
                  onclick="return confirm('delete this comnment?');">
                  
               </form>
               <?php } ?>
            </div>
            <?php
                  }
               } else{
                  echo '<p class="empty">no comments added yet!</p>';
               }
            ?>
         </div>
  </section>
    <!-- Comments section end -->

  <!-- Footer section start -->
   <?php require_once './php/components/footer.php'; ?>
  <!-- Footer section end -->
  <script src="./js/style.js"></script>
</body>
</html>
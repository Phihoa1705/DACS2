<?php

  require_once './php/components/connect.php';

  if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
  } else {
    $user_id = '';
    header('location: home.php');
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
       header('location:comment.php');
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
  <title>All Comments</title>

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
        <a href="comment.php" class="inline-option-btn">cancel edit</a>  
        <input type="submit" value="edit comment" name="edit_comment" class="inline-btn">
      </div>

    </form>

  </section>
  <?php
    }
  ?>

  <!-- Comments section start -->
  <section class="comments">
         <h1 class="heading">your comments</h1>
         
         <div class="box-container">
            <?php
               $select_comments = getDatabaseConnection()->prepare("SELECT * FROM comments WHERE user_id = ?");
               $select_comments->execute([$user_id]);
               if($select_comments->rowCount() > 0) {
                  while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                    $comment_id = $fetch_comment['comment_id'];

                    $select_content = getDatabaseConnection()->prepare("SELECT * FROM content WHERE content_id = ?");
                    $select_content->execute([$fetch_comment['content_id']]);
                    $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="box">
                <div class="comment-content">
                  <p><?php echo $fetch_content['title']; ?></p>
                  <a href="watch-video.php?get_id=<?php echo $fetch_content['content_id']; ?>">View Content</a>
                </div>
               <p class="comment-box"><?php echo $fetch_comment['comment'];?></p>
               <form action="" method="post">
                  <input type="hidden" name="comment_id" value="<?php echo $comment_id;?>">
                  <input type="submit" value="update comment" name="update_comment" class="inline-option-btn">
                  <input type="submit" value="delete comment" name="delete_comment" class="inline-delete-btn"
                  onclick="return confirm('delete this comnment?');">
                  
               </form>
            </div>
            <?php
                  }
               } else{
                  echo '<p class="empty" style="padding:0;">no comments added yet!</p>';
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
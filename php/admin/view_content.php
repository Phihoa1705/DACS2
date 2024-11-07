<?php
require_once '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
 }else{
    $tutor_id = '';
    header('location:login.php');
 }
 if(isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
 } else {
    $get_id = '';
    header('location:playlists.php');
 }

 if(isset($_GET['get_id'])) {
   $get_id = $_GET['get_id'];
} else {
   $get_id = '';
   header('location:playlists.php');
}

if(isset($_POST['delete_content'])) {
   $delete_id = $_POST['content_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_content = $conn->prepare("SELECT * FROM content WHERE content_id = ?");
   $verify_content->execute([$delete_id]);

   if($verify_content->rowCount() > 0) {
      $fecth_content = $verify_content->fetch(PDO::FETCH_ASSOC);
      unlink('../uploaded_files/'.$fecth_content['thumb']);
      unlink('../uploaded_files/'.$fecth_content['video']);
      $delete_comment = $conn->prepare("DELETE FROM comments WHERE content_id = ?");
      $delete_comment->execute([$delete_id]);
      
      $delete_likes = $conn->prepare("DELETE FROM likes WHERE content_id = ?");
      $delete_likes->execute([$delete_id]);

      $delete_content = $conn->prepare("DELETE FROM content WHERE content_id = ?");
      $delete_content->execute([$delete_id]);

      header("location:contents.php");
   } else {
      $message[] = 'content already deleted!';
   }
}

if(isset($_POST['delete_comment'])){
   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING); 

   $verify_comment = $conn->prepare("SELECT * FROM comments WHERE comment_id = ?");
   $verify_comment->execute([$delete_id]);

   if($verify_comment->rowCount() > 0){
      $delete_comment = $conn->prepare("DELETE FROM comments WHERE comment_id = ?");
      $delete_comment->execute([$delete_id]);
      $message[] = 'comment deleted successfully';
      header('location:comments.php');
   } else {
      $message[] = 'comment already deleted';
   }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Content</title>

    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file -->
     <link rel="stylesheet" href="../../css/admin_style.css">
</head>
<body>
    <!-- header section link -->
    <?php require_once '../components/admin_header.php'; ?>

    <!-- View content section start -->
     <section class="view-content">
         <?php
            $select_content  = $conn->prepare("SELECT * FROM content WHERE content_id = ?");
            $select_content->execute([$get_id]);
            if($select_content->rowCount() > 0) {
                while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                  $content_id = $fetch_content['content_id'];

                  // like
                  $count_likes = $conn->prepare("SELECT * FROM likes WHERE tutor_id = ? AND content_id = ?");

                  $count_likes->execute([$tutor_id,$content_id]);

                  $total_likes = $count_likes->rowCount();
                  // comment
                  $count_comments = $conn->prepare("SELECT * FROM comments WHERE tutor_id = ? AND content_id = ?");

                  $count_comments->execute([$tutor_id,$content_id]);

                  $total_comments = $count_comments->rowCount();
         ?>
         <div class="content">
            <video src="../uploaded_files/<?php echo $fetch_content['video']; ?>" 
            poster="../uploaded_files/<?php echo $fetch_content['thumb']; ?>" controls autoplay></video>
            <div class="date"><i class="fas fa-calendar"></i><span><?php echo $fetch_content['creation_date']; ?></span></div>
            <h3 class="title"><?php echo $fetch_content['title']; ?></h3>
            <div class="flex">
               <div><i class="fas fa-heart"></i><span><?php echo $total_likes; ?></span></div>
               <div><i class="fas fa-comment"></i><span><?php echo $total_comments; ?></span></div>
            </div>
            <p class="description"><?php echo $fetch_content['description']; ?></p>
            <form action="" class="flex-btn" method="POST">
               <input type="hidden" name="content_id" value="<?php echo $content_id; ?>">
               <input type="submit" value="delete content" class="delete-btn" name="delete_content">
               <a href="update_content.php?get_id=<?php echo $content_id; ?>" class="option-btn">update content</a>
            </form>
         </div>
         <?php
               }
            } else {
               echo '<p class="empty">content was not found!</p>';
            }
         ?>
         
     </section>
    <!-- View content section end -->

    <!-- Comments section start -->
     <section class="comments">
         <h1 class="heading">User comments</h1>
         
         <div class="box-container">
            <?php
               $select_comments = $conn->prepare("SELECT * FROM comments WHERE content_id = ? AND tutor_id = ?");
               $select_comments->execute([$get_id,$tutor_id]);
               if($select_comments->rowCount() > 0) {
                  while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                     $comment_id = $fetch_comment['comment_id'];
                     $select_commentor = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
                     $select_commentor->execute([$fetch_comment['user_id']]);
                     $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="box">
               <div class="user">
                  <img src="../uploaded_files/<?php echo $fetch_commentor['image'];?>" alt="">
                  <div>
                     <h3><?php echo $fetch_commentor['name'];?></h3>
                     <span><?php echo $fetch_comment['creation_date'];?></span>
                  </div>
               </div>
               <p class="comment-box"><?php echo $fetch_comment['comment'];?></p>
               <form action="" method="post">
                  <input type="hidden" name="comment_id" value="<?php echo $fetch_comment['content_id'];?>">
                  <input type="submit" value="delete comment" name="delete_comment" class="inline-delete-btn">
               </form>
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

    <!-- footer section link -->
    <?php require_once '../components/footer.php'; ?>
    <!-- custom js file -->
    <script src="../../js/admin_script.js"></script>
</body>
</html>